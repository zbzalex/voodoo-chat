<?php


namespace Chat\controller;


use Chat\api\Error;
use Chat\api\Ok;
use Chat\dao\MessageDao;
use Chat\dao\RoomDao;
use Chat\dao\UserDao;
use Chat\dao\WhoDao;
use Chat\repository\MessageRepository;
use Chat\repository\RoomRepository;
use Chat\repository\UserRepository;
use Chat\repository\WhoRepository;
use Chat\vo\Message;
use Chat\vo\Room;
use Chat\vo\User;
use Chat\vo\UserStatus;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController
{
    public function getRoom(Application $app, Request $request)
    {
        $id = $request->query->get("id");

        $roomRepository = new RoomRepository($app['pdo']->getDao(RoomDao::class));
        if (($room = $roomRepository->getById($id)) === null) {
            return new Response(new Error('Not found'));
        }

        return new Response(new Ok([
            'room' => [
                'id' => $room->getId(),
                'title' => $room->getTitle(),
                'topic' => $room->getTopic()
            ]
        ]));
    }

    public function getUser(Application $app, Request $request)
    {
        $id = $request->query->get("id");

        $userRepository = new UserRepository($app['pdo']->getDao(UserDao::class));
        if (($user = $userRepository->getById($id)) === null) {
            return new Response(new Error('Not found'));
        }

        return new Response(new Ok([
            'room' => [
                'id' => $user->getId(),
            ]
        ]));
    }

    public function getRooms(Application $app, Request $request)
    {
        $roomRepository = new RoomRepository($app['pdo']->getDao(RoomDao::class));

        return new Response(new Ok([
            'rooms' => array_map(function ($room) use ($app) {
                /** @var Room $room */
                return [
                    'id' => $room->getId(),
                    'title' => $room->getTitle(),
                    'topic' => $room->getTopic(),
                    'bot' => $room->getBot(),
                    'allowed_users' => $room->isAllowedUsers(),
                    'premoder' => $room->isPremoder(),
                    'last_action' => $room->getLastAction(),
                    'clubonly' => $room->isClubOnly(),
                    'jail' => $room->isJail(),
                    'points' => $room->getPoints(),
                ];
            }, $roomRepository->getAll())
        ]));
    }

    public function getPrivateMessages(Application $app, Request $request)
    {
        $messageRepository = new MessageRepository($app['pdo']->getDao(MessageDao::class));

        return new Response(new Ok([
            'messages' => array_map(function ($message) {
                /** @var Message $message */
                return [
                    'id' => $message->getId()
                ];
            }, $messageRepository->getPrivateMessages())
        ]));
    }

    public function who(Application $app, Request $request)
    {
        $whoRepository = new WhoRepository($app['pdo']->getDao(WhoDao::class));

        $users = [
            [], // ..
            [], // admins
            [], // shamans
            [], // boys
            [], // girls
            [], // they
        ];
        $result = $whoRepository->getAll();
        if (\count($result) > 0) {
            for ($i = 0; $i < count($result); $i++) {
                /** @var User $user */
                $user = $result[$i];

                $tmpUser = [
                    'id' => $user->getId(),
                    'nick' => $user->getNick(),
                    'canonNick' => $user->getCanonNick(),
                    'htmlNick' => $user->getHtmlNick(),
                    'gender' => $user->getGender(),
                ];

                if ($user->getGender() === 1) { // boyd
                    $users[3][] = $tmpUser;
                } else if ($user->getGender() === 2) { // girls
                    $users[4][] = $tmpUser;
                } else if ($user->getGender() === 0) { // they
                    $users[5][] = $tmpUser;
                }
            }
        }

        return new Response(new Ok([
            'users' => $users
        ]));
    }

    public function getMessages(Application $app, Request $request)
    {
        $room = $request->query->get("room", 0);
        $offset = max(0, $request->query->get("offset", 0));
        $limit = max(1, $request->query->get("limit", 10));

        if ($room === 0) {
            return new Response(new Error("Room not found"));
        }

        $messageRepository = new MessageRepository($app['pdo']->getDao(MessageDao::class));
        return new Response(new Ok([
            'messages' => array_map(function ($message) {
                return [
                    'id' => $message->getId(),
                    'from' => $message->getFrom(),
                    'from_without_tags' => $message->getFromWithoutTags(),
                    'from_id' => $message->getFromId(),
                    'to' => $message->getTo(),
                    'to_id' => $message->getToId(),
                    'body' => $message->getBody(),
                    'clan_id' => $message->getClanId()
                ];
            }, $messageRepository->getMessagesByRoom($room, $offset, $limit))
        ]));
    }
}