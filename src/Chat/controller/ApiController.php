<?php


namespace Chat\controller;


use Chat\api\Error;
use Chat\api\Ok;
use Chat\dao\RoomDao;
use Chat\dao\UserDao;
use Chat\repository\RoomRepository;
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
        $room = abs($request->query->get("room", 0));
        $roomRepository = new RoomRepository($app['pdo']->getDao(RoomDao::class));
        if (($_room = $roomRepository->getRoomById($room)) === null) {
            return new Response(new Error("Room not found."));
        }

        $userRepository = new UserRepository($app['pdo']->getDao(UserDao::class));

        $count = 0;
        $users = [
            null,
            [], // admins
            [], // moders (SHAMANS)
            [], // boys
            [], // girls
            [], // they
        ];
        /** @var User[] $entities */
        $entities = $userRepository->getOnlineUsersByRoom($room);
        if (\count($entities) > 0) {
            /** @var int $count */
            $count = count($entities);
            for ($i = 0; $i < $count; $i++) {

                $user = $entities[$i];

                // tmp object
                $tmp = [
                    'id' => $user->getId(),
                    'nick' => $user->getNick(),
                    'canon_nick' => $user->getCanonNick(),
                    'html_nick' => $user->getHtmlNick(),
                    'sex' => $user->getSex(),
                    'have_photo' => $user->getPhotoUrl() !== null,
                    'rewards' => $user->getRewards(),
                    'damneds' => $user->getDamneds(),
                    'married_with' => $user->getMarriedWith(),
                    'bot' => $user->isBot() ? 1 : 0,
                    'online_time' => $user->getOnlineTime(),
                    'status' => $user->getStatus(),
                    'silence' => $user->getSilence(),
                    'silence_start' => $user->getSilenceStart(),
                    'class' => $user->getClass(),
                ];

                if ($user->getSex() == 1) { // boys
                    $users[3][] = $tmp;
                } else if ($user->getSex() == 2) { // girls
                    $users[4][] = $tmp;
                } else if ($user->getSex() == 0) { // they
                    $users[5][] = $tmp;
                }
            }
        }

        return new Response(new Ok([
            'count' => $count,
            'users' => $users
        ]));
    }
}