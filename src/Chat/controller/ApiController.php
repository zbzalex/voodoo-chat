<?php


namespace Chat\controller;


use Chat\api\Ok;
use Chat\dao\UserDao;
use Chat\repository\UserRepository;
use Chat\vo\User;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController
{
    public function getOnlineUsers(Application $app, Request $request)
    {
        /** @var int $room */
        $room = $request->query->get("room", 0);
        $userRepository = new UserRepository($app['pdo']->getDao(UserDao::class));

        $users = [
            [], // ..
            [], // admins
            [], // shamans
            [], // boys
            [], // girls
            [], // they
        ];
        $result = $userRepository->getOnlineUsersByRoom($room);
        if (\count($result) > 0) {
            for ($i = 0; $i < count($result); $i++) {
                /** @var User $user */
                $user = $result[$i];

                $tmpUser = [
                    'id' => $user->getId(),
                    'nick' => $user->getNick(),
                    'canonNick' => $user->getCanonNick(),
                    'htmlNick' => $user->getHtmlNick(),
                    'sex' => $user->getSex(),
                ];

                if ($user->getSex() === 1) { // boyd
                    $users[3][] = $tmpUser;
                } else if ($user->getSex() === 2) { // girls
                    $users[4][] = $tmpUser;
                } else if ($user->getSex() === 0) { // they
                    $users[5][] = $tmpUser;
                }
            }
        }

        return new Response(new Ok([
            'users' => $users
        ]));
    }
}