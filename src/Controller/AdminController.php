<?php

namespace Zrtcommunity\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Silex\Application;
use Zrtcommunity\Domain\Region;
use Zrtcommunity\Form\Type\RegionType;
use Zrtcommunity\Domain\Categorie;
use Zrtcommunity\Domain\SousCategorie;
use Zrtcommunity\Domain\ModelQuestionaire;
use Zrtcommunity\Domain\Question;
use Zrtcommunity\Form\Type\CategorieType;
use Zrtcommunity\Form\Type\SousCategorieType;
use Zrtcommunity\Form\Type\SousCatType;
use Zrtcommunity\Form\Type\ModelQuestionaireType;
use Zrtcommunity\Domain\MessagePrive;
use Doctrine\Common\Collections\ArrayCollection;

use \DateTime;

class AdminController{
    public function adminAction(Request $request, Application $app){

        $days = array();
        for ($i = 0; $i < 30; $i++) {
            $days[] = new DateTime(date('Y-m-d',strtotime('-'.$i.'days')));
        }
        $days=array_reverse($days);

        $visits=$app['dao.visit']->findAll();

        $nbVisitsUser=array();
        $nbVisitsGuest=array();

        for($i =0; $i<count($days);$i++){
            $nbVisitsUser[$i]=$app['dao.visit']->findUserVisitByDay($days[$i]);
            $nbVisitsGuest[$i]=$app['dao.visit']->findGuestVisitByDay($days[$i]);
        }

        $navigators=$app['dao.visit']->findVisitByNavigator();
        $devices=$app['dao.visit']->findVisitByDevice();

        return $app['twig']->render( "admin-stat.html",array(
            'panelname' => 'Statistiques',
            'visitsUser' => $nbVisitsUser,
            'visitsGuest' => $nbVisitsGuest,
            'days'=>$days,
            'navigators' => $navigators,
            'devices' => $devices,
            )
        );
    }

    public function regionProjetAction(Request $request, Application $app){
        $region = new Region();

        $projetsAValider = $app['dao.projet']->loadProjetNonValid();

        $regionForm = $app['form.factory']->create(new RegionType(), $region);
        $regionForm->handleRequest($request);
        if( $regionForm->isSubmitted()&& $regionForm->isValid()){
            $app['dao.region']->save($region);
            return $app->redirect($request->getBasePath().'/admin/regionprojet');
        }
        return $app['twig']->render( "adminRegionProjet.html",array(
            'panelname' => "Régions et projets",
            'form' => $regionForm->createView(),
            'projets' => $projetsAValider,
            )
        );
    }

    public function forumAction(Request $request, Application $app){
        $cat = new Categorie;
        $scat = new SousCategorie;
        $scat2 = new SousCategorie;

        $catForm = $app['form.factory']->create(new CategorieType, $cat);
        $scatForm = $app['form.factory']->create(new SousCategorieType, $scat);
        $scatForm2 = $app['form.factory']->create(new SousCatType, $scat2);

        $catForm->handleRequest($request);
        $scatForm->handleRequest($request);
        $scatForm2->handleRequest($request);

        if($catForm->isSubmitted()&& $catForm->isValid()){
            $app['dao.categorie']->save($cat);
            return $app->redirect($request->getBasePath().'/admin/forum');
        }

        if($scatForm->isSubmitted()&& $scatForm->isValid()){
            $scat->setParentSousCategorie($app['dao.scat']->loadSousCategorieById($scatForm["parent"]->getData()));
            $app['dao.scat']->save($scat);
            return $app->redirect($request->getBasePath().'/admin/forum');
        }

        if($scatForm2->isSubmitted()&& $scatForm2->isValid()){
            $scat2->setParentCategorie($app['dao.categorie']->loadCategorieById($scatForm2["parent"]->getData()));
            $app['dao.scat']->save($scat2);
            return $app->redirect($request->getBasePath().'/admin/forum');
        }

        return $app['twig']->render( "admin-forum.html",array(
            'panelname' => "Forum",
            'form1' => $catForm->createView(),
            'form2' => $scatForm->createView(),
            'form3' => $scatForm2->createView(),
            )
        );
    }

    public function questionaireAction(Request $request, Application $app){

        $questionairesAValider = $app['dao.questionaire']->loadQuestionaireNonValid();

        $inuse = $app['dao.modelQuestionaire']->loadInUse();

        $allModels = $app['dao.modelQuestionaire']->loadAllModels();

        $model = new ModelQuestionaire();
        $model->setQuestions(new ArrayCollection());
        $model->setDate(new DateTime());
        $model->setInUse(false);
        $question1=new Question();
        $model->getQuestions()->add($question1);

        $form =  $app['form.factory']->create(new ModelQuestionaireType(), $model);

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isSubmitted()){
                foreach($model->getQuestions() as $question){
                    $question->setModel($model);
                }
                $app['dao.modelQuestionaire']->save($model);
            }
            return $app->redirect($request->getBasePath().'/admin/questionaire');
        }


        return $app['twig']->render( "admin-Questionaire.html",array(
            'panelname' => "Questionaire inscription",
            'form' => $form->createView(),
            'modelInUse' => $inuse,
            'allModels'=>$allModels,
            'nonValid'=>$questionairesAValider
            )
        );
    }

    public function chooseQuestionaireAction($idModel,Request $request, Application $app){
        $inuse = $app['dao.modelQuestionaire']->loadInUse();
        $inuse->setInUse(false);
        $newInUse = $app['dao.modelQuestionaire']->loadModelById($idModel);
        $newInUse->setInUse(true);
        $app['dao.modelQuestionaire']->save($inuse);
        $app['dao.modelQuestionaire']->save($newInUse);
        return $app->redirect($request->getBasePath().'/admin/questionaire');
    }

    public function validateQuestionaireAction($questionaireId ,Request $request, Application $app){
        $questionaire = $app['dao.questionaire']->loadQuestionaireById($questionaireId);
        return $app['twig']->render( "admin-validate-Questionaire.html",array(
            'panelname' => "Validation questionaire",
            'questionaire' => $questionaire
            )
        );
    }
    public function validateQuestionaireRedirectionAction($questionaireId, $choice ,Request $request, Application $app){
        $questionaire = $app['dao.questionaire']->loadQuestionaireById($questionaireId);
        $mp = new MessagePrive();
        $mp->setAuteur($app['security']->getToken()->getUser());
        $mp->setDestinataire($questionaire->getUser());
        $mp->setDate(new DateTime());
        $mp->setLu(false);
        if($choice == "validate"){
            $questionaire->setAccepted(true);
            $app['dao.questionaire']->save($questionaire);
            $mp->setTitre("Votre questionnaire au serveur ZrtCraft à été validé par la modération");
            $mp->setContenu("Bienvenu sur le serveur, Votre compte a été ou est sur le point d'etre whitelisté.");
        }else{
            $questionaire->getUser()->setQuestionaireZrtCraft(null);
            $app['dao.user']->save($questionaire->getUser());
            $app['dao.questionaire']->remove($questionaire);
            $mp->setTitre("Votre questionnaire au serveur ZrtCraft à été refusé par la modération");
            $mp->setContenu("Adressez vous a la modération pour plus d'éxplications");
        }
        $app['dao.messPrive']->save($mp);
        return $app->redirect($request->getBasePath().'/messagerie/message/'.$mp->getId());
    }
}
