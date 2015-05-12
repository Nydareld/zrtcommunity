<?php

namespace Zrtcommunity\Controller;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use Zrtcommunity\Domain\MessagePrive;
use \DateTime;

class MPController{

    public function inboxAction(Request $request, Application $app) {
        $messages = $app['dao.messPrive']->loadMessageByDestinataire($app['security']->getToken()->getUser());
        return $app['twig']->render('mpInbox.html', array(
            'title' => "Messagerie",
            "mess" => $messages
            ));
    }

    public function outboxAction(Request $request, Application $app) {
        $messages = $app['dao.messPrive']->loadMessageByAuteur($app['security']->getToken()->getUser());
        return $app['twig']->render('mpOutbox.html', array(
            'title' => "Messagerie",
            "mess" => $messages
            ));
    }

    public function unMessageAction($messageid, Request $request, Application $app){
        $mess=$app['dao.messPrive']->loadMessageById($messageid);
        if($app['security']->isGranted('IS_AUTHENTICATED_FULLY')
        || $mess->getAuteur() == $app['security']->getToken()->getUser()
        || $mess->getDestinataire() == $app['security']->getToken()->getUser() ){

            return $app['twig']->render('unMp.html', array(
                'title' => "Messagerie",
                "mess" => $mess,
                ));
        }
        throw new \Exception("Ce message n'existe pas ou ne vous est pas déstiné");

    }

}
