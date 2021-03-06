<?php

namespace Zrtcommunity\Controller;

use Symfony\Component\HttpFoundation\Request;
use Zrtcommunity\Domain\User;
use Zrtcommunity\Domain\Reponse;
use Zrtcommunity\Domain\Questionaire;
use Silex\Application;
use Zrtcommunity\Form\Type\ProfileType;
use Zrtcommunity\Form\Type\UserType;
use Zrtcommunity\Form\Type\QuestionaireType;
use Zrtcommunity\Controller\HomeController;
use Zrtcommunity\Domain\Notification;
use Doctrine\Common\Collections\ArrayCollection;


use \DateTime;

class UserController{

    public function addUserAction(Request $request, Application $app, $danger=null) {

        $user = new User();
        $userForm = $app['form.factory']->create(new UserType(), $user);
        $userForm->handleRequest($request);
        if($user->getUsername()=="guest" || $user->getUsername()=="admin" ){
            $danger ="Ce nom d'utilisateur est interdit";
        }elseif(!$app['dao.user']->loadUserByUsername($user->getUsername())==null){
            $danger ="Ce nom d'utilisateur est déja utilisé par un membre.";
        }elseif(!$app['dao.user']->loadUserByEmail($user->getEmail())==null){
            $danger ="Cet email est déja utilisée par un membre.";
        }
        elseif ($userForm->isSubmitted() && $userForm->isValid()){
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

                $notif = new Notification();
                $notif->setMessage("Bienvenue sur ZrtCommunity, vous pouvez vous inscrire au serveur Minecraft ZrtCraft en clquant ici");
                $notif->setPath("/member.questionaire");
                $notif->setUser($user);

                $app['dao.notification']->save($notif);

                $success='Vous etes bien inscrits veillez maintenant vous connecter';
                return $app['Home.controller']->loginAction($request, $app, $success);
        }
        return $app['twig']->render('register.html', array(
            'section'=>"default",
            'title' => 'Inscription',
            'userForm' => $userForm->createView(),
            'danger' => $danger));

    }

    public function usersAction(Request $request, Application $app){

        $members = $app['orm.em']->getRepository('Zrtcommunity\Domain\User')->findall();

        return $app['twig']->render( "users.html",array(
            'section'=>"default",
            'title' => "Membres",
            'users' => $members,
            ));
    }

    public function userProfileAction($username, Request $request, Application $app){
        $user = $app['dao.user']->loadUserByUsername($username);
        return $app['twig']->render( "user.html",array(
            'section'=>"default",
            'title' => $user->getUsername(),
            'user' => $user,
            ));
    }

    public function editProfileAction(Request $request, Application $app){
        $user = $app['security']->getToken()->getUser();

        $profilForm = $app['form.factory']->create(new ProfileType(), $user);
        $profilForm->handleRequest($request);

        if ($profilForm->isSubmitted() && $profilForm->isValid()){
            $user->upload();
            $app['dao.user']->save($user);
            return $app->redirect($request->getBasePath().'/membre/'.$user->getUsername());
        }

        return $app['twig']->render( "profilModForm.html",array(
            'section'=>"default",
            'title' => "Mon profil",
            'form' => $profilForm->createView(),
            )
        );

    }
    public function questionnaireProfileAction(Request $request, Application $app){
        $user=$app['security']->getToken()->getUser();
        if($user->getQuestionaireZrtCraft()==null){
            $questionaire = new Questionaire();
            $user->setQuestionaireZrtCraft($questionaire);
            $questionaire->setModel($app['dao.modelQuestionaire']->loadInUse());
            $questionaire->setDate(new DateTime());
            $questionaire->setAccepted(false);
            $questionaire->setUser($user);
            $questionaire->setReponses(new ArrayCollection());
            foreach($questionaire->getModel()->getQuestions() as $question){
                $reponse = new Reponse();
                $reponse->setQuestion($question);
                $reponse->setQuestionaire($questionaire);
                $questionaire->getReponses()->add($reponse);
            }
            $form =  $app['form.factory']->create(new QuestionaireType(), $questionaire);
            if($request->isMethod('POST')){
                $form->handleRequest($request);
                if($form->isSubmitted()){
                    $app['dao.questionaire']->save($questionaire);
                    $app['dao.user']->save($user);
                }
                return $app->redirect($request->getBasePath().'/member/questionaire');
            }
            return $app['twig']->render( "zrtcraftQuestionaire.html",array(
                'section'=>"default",
                'title' => "Questionaire",
                'form' => $form->createView(),
                'questions' => $questionaire->getModel()->getQuestions(),
                )
            );
        }else{
            $questionaire=$user->getQuestionaireZrtCraft();
            return $app['twig']->render( "questionaireRempli.html",array(
                'section'=>"default",
                'title' => "Questionaire",
                'questionaire' => $questionaire
                )
            );
        }

    }
}
