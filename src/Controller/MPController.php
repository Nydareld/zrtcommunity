<?php

namespace Zrtcommunity\Controller;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use Zrtcommunity\Domain\MessagePrive;
use Zrtcommunity\Form\Type\MPType;
use \DateTime;

class MPController{

    public function inboxAction(Request $request, Application $app) {
        $messages = $app['dao.messPrive']->loadMessageByDestinataire($app['security']->getToken()->getUser());
        return $app['twig']->render('mpInbox.html', array(
            'section'=>"default",
            'title' => "Messagerie",
            "mess" => $messages
            ));
    }

    public function outboxAction(Request $request, Application $app) {
        $messages = $app['dao.messPrive']->loadMessageByAuteur($app['security']->getToken()->getUser());
        return $app['twig']->render('mpOutbox.html', array(
            'section'=>"default",
            'title' => "Messagerie",
            "mess" => $messages
            ));
    }

    public function unMessageAction($messageid, Request $request, Application $app){
        $mess=$app['dao.messPrive']->loadMessageById($messageid);
        if($mess->getAuteur() == $app['security']->getToken()->getUser()
        || $mess->getDestinataire() == $app['security']->getToken()->getUser() ){

            if($mess->getDestinataire() == $app['security']->getToken()->getUser()){
                $mess->setLu(true);
                $app['dao.messPrive']->save($mess);
            }

            return $app['twig']->render('unMp.html', array(
                'section'=>"default",
                'title' => "Messagerie",
                "mess" => $mess,
                ));
        }
        throw new \Exception("Ce message ne vous est pas déstiné");

    }

    public function newMessageAction($userid, Request $request, Application $app){
        $mess = new MessagePrive();

        $messageForm = $app['form.factory']->create(new MPType(), $mess);
        $messageForm->handleRequest($request);
        if ($messageForm->isSubmitted() && $messageForm->isValid() ) {
            $mess->setAuteur($app['security']->getToken()->getUser());
            $mess->setDestinataire($app['dao.user']->find($userid));
            $mess->setDate(new DateTime());
            $mess->setLu(false);
            $app['dao.messPrive']->save($mess);

            return $app->redirect($request->getBasePath().'/messagerie/message/'.$mess->getId());
        }
        return $app['twig']->render('basicFormNoSection.html', array(
            'section'=>"default",
            'title' => "Messagerie",
            "form" => $messageForm->createView(),
            ));

    }

}
