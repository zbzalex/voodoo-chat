<?php


namespace VOC\controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VOC\api\Error;
use VOC\api\Ok;
use VOC\dao\MessageDao;
use VOC\dao\RoomDao;
use VOC\dao\UserDao;
use VOC\repository\MessageRepository;
use VOC\repository\RoomRepository;
use VOC\repository\UserRepository;
use VOC\vo\Message;

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
}