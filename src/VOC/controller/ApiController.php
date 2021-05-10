<?php


namespace VOC\controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VOC\api\Error;
use VOC\api\Ok;
use VOC\dao\MessageDao;
use VOC\repository\MessageRepository;
use VOC\vo\Message;

class ApiController
{
    public function getPrivateMessages(Application $app, Request $request)
    {
        $session = $request->query->get("session");
        if ($session === null) {
            //return new Response(new Error("Unauthorized"));
        }

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