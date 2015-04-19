<?php

namespace Zrtcommunity\Controller;

use Symfony\Component\HttpFoundation\Request;
use Zrtcommunity\Domain\User;
use Silex\Application;
use Zrtcommunity\Form\Type\UserType;
use Zrtcommunity\Controller\HomeController;

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

    public function usersAction(Request $request, Application $app){

        $members = $app['orm.em']->getRepository('Zrtcommunity\Domain\User')->findall();

        return $app['twig']->render( "users.html",array(
            'title' => "Membres",
            'users' => $members,
            ));
    }

    public function userProfileAction($id, Request $request, Application $app){
        $user = $app['dao.user']->find($id);
        return $app['twig']->render( "users.html",array(
            'title' => $user->getUsername(),
            'user' => $user,
            ));
    }
}
