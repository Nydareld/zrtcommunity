<?php

namespace Pecheocoup\Controller;

use Symfony\Component\HttpFoundation\Request;
use Pecheocoup\Domain\User;
use Silex\Application;
use Pecheocoup\Form\Type\UserType;
use Pecheocoup\Controller\HomeController;

class UserController{

    public function addUserAction(Request $request, Application $app) {

        $user = new User();
        $userForm = $app['form.factory']->create(new UserType(), $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            // generate a random salt value
            $salt = substr(md5(time()), 0, 23);
            $user->setSalt($salt);
            $plainPassword = $user->getPassword();
            // find the default encoder
            $encoder = $app['security.encoder.digest'];
            // compute the encoded password
            $password = $encoder->encodePassword($plainPassword, $user->getSalt());
            $user->setPassword($password);
            $app['dao.user']->save($user);
            $success='Vous etes bien inscrits veillez maintenant vous connecter';
            return $app['Home.controller']->loginAction($request, $app, $success);
        }
        return $app['twig']->render('register.html', array(
            'title' => 'Inscription',
            'userForm' => $userForm->createView()));

    }

}
