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

}
