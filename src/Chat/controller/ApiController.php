<?php


namespace Chat\controller;


use Chat\api\Error;
use Chat\api\Ok;
use Chat\dao\RoomDao;
use Chat\dao\UserDao;
use Chat\repository\RoomRepository;
use Chat\repository\UserRepository;
use Chat\vo\User;
use Chat\vo\Users;
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
            Users::ADMINS => [],
            Users::SHAMAN => [],
            Users::GIRL => [],
            Users::BOYS => [],
            Users::THEY => [],
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
                    'last_action' => $user->getLastAction(),
                ];

                if (($user->getClass() & User::CLASS_EDIT_USER) != 0) {
                    $users[Users::ADMINS][] = $tmp;
                } else if ($user->getClass() & User::CLASS_BAN) {
                    $users[Users::SHAMAN][] = $tmp;
                } else if ($user->getSex() == User::SEX_MALE) {
                    $users[Users::BOYS][] = $tmp;
                } else if ($user->getSex() == User::SEX_FEMALE) {
                    $users[Users::GIRL][] = $tmp;
                } else if ($user->getSex() == User::SEX_UNKNOWN) {
                    $users[Users::THEY][] = $tmp;
                }
            }
        }

        return new Response(new Ok([
            'count' => $count,
            'users' => $users
        ]));
    }
}