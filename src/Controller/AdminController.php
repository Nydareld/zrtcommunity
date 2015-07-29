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
use Zrtcommunity\Domain\Regle;
use Zrtcommunity\Form\Type\CategorieType;
use Zrtcommunity\Form\Type\SousCategorieType;
use Zrtcommunity\Form\Type\SousCatType;
use Zrtcommunity\Form\Type\ModelQuestionaireType;
use Zrtcommunity\Form\Type\RegleType;
use Zrtcommunity\Form\Type\ModRoleType;
use Zrtcommunity\Domain\MessagePrive;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationProviderManager;

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

        $user = $app['security']->getToken()->getUser();
        $section = $app['dao.section']->loadByName("zrtcraft");

        if( !$section->getAdmins()->contains($user) && ! $section->getModos()->contains($user) ){
            throw new \Exception("Cette section est réservé a la modération zrtcraft");
        }

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

    public function forumAction($sectionId,Request $request, Application $app){
        $section = $app['dao.section']->loadByName($sectionId);

        $arbo = $app['dao.categorie']->loadAllCategorieBySection($section);

        $cat = new Categorie;
        $scat = new SousCategorie;
        $scat2 = new SousCategorie;

        $catForm = $app['form.factory']->create(new CategorieType, $cat);
        $scatForm = $app['form.factory']->create(new SousCategorieType, $scat, array('attr'=> array('section' => $sectionId)) );
        $scatForm2 = $app['form.factory']->create(new SousCatType, $scat2, array('attr'=> array('section' => $sectionId)) );

        $catForm->handleRequest($request);
        $scatForm->handleRequest($request);
        $scatForm2->handleRequest($request);

        if($catForm->isSubmitted()&& $catForm->isValid()){

            if( ! $section->getAdmins()->contains($app['security']->getToken()->getUser()) ){
                throw new \Exception("La modification de l'arboressence du forum est réservé aux admins");
            }

            $cat->setSectionSite($section);
            $app['dao.categorie']->save($cat);
            return $app->redirect($request->getBasePath().'/admin/'.$section->getName().'/forum');
        }

        if($scatForm->isSubmitted()&& $scatForm->isValid()){

            if( ! $section->getAdmins()->contains($app['security']->getToken()->getUser()) ){
                throw new \Exception("La modification de l'arboressence du forum est réservé aux admins");
            }

            $scat->setParentSousCategorie($app['dao.scat']->loadSousCategorieById($scatForm["parent"]->getData()));
            $scat->setAdmin($app['dao.scat']->loadSousCategorieById($scatForm["parent"]->getData())->getAdmin());
            $app['dao.scat']->save($scat);
            return $app->redirect($request->getBasePath().'/admin/'.$section->getName().'/forum');
        }

        if($scatForm2->isSubmitted()&& $scatForm2->isValid()){

            if( ! $section->getAdmins()->contains($app['security']->getToken()->getUser()) ){
                throw new \Exception("La modification de l'arboressence du forum est réservé aux admins");
            }

            $scat2->setParentCategorie($app['dao.categorie']->loadCategorieById($scatForm2["parent"]->getData()));
            $scat2->setAdmin($app['dao.categorie']->loadCategorieById($scatForm2["parent"]->getData())->getAdmin());
            $app['dao.scat']->save($scat2);
            return $app->redirect($request->getBasePath().'/admin/'.$section->getName().'/forum');
        }

        return $app['twig']->render( "admin-forum.html",array(
            'panelname' => "Forum",
            'form1' => $catForm->createView(),
            'form2' => $scatForm->createView(),
            'form3' => $scatForm2->createView(),
            'arbo' => $arbo,
            'adminSection' => $section->getAdmins()->contains($app['security']->getToken()->getUser()),
            )
        );
    }

    public function questionaireAction(Request $request, Application $app){

        $user = $app['security']->getToken()->getUser();
        $section = $app['dao.section']->loadByName("zrtcraft");

        if( !$section->getAdmins()->contains($user) && ! $section->getModos()->contains($user) ){
            throw new \Exception("Cette section est réservé a la modération zrtcraft");
        }

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

        $user = $app['security']->getToken()->getUser();
        $section = $app['dao.section']->loadByName("zrtcraft");

        if( !$section->getAdmins()->contains($user) && ! $section->getModos()->contains($user) ){
            throw new \Exception("Cette section est réservé a la modération zrtcraft");
        }

        $inuse = $app['dao.modelQuestionaire']->loadInUse();
        $inuse->setInUse(false);
        $newInUse = $app['dao.modelQuestionaire']->loadModelById($idModel);
        $newInUse->setInUse(true);
        $app['dao.modelQuestionaire']->save($inuse);
        $app['dao.modelQuestionaire']->save($newInUse);
        return $app->redirect($request->getBasePath().'/admin/questionaire');
    }

    public function validateQuestionaireRedirectionAction($questionaireId, $choice ,Request $request, Application $app){

        $user = $app['security']->getToken()->getUser();
        $section = $app['dao.section']->loadByName("zrtcraft");

        if( !$section->getAdmins()->contains($user) && ! $section->getModos()->contains($user) ){
            throw new \Exception("Cette section est réservé a la modération zrtcraft");
        }

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
            $mp->setContenu(
"
<h3>Tu es bien white-listé.</h3>
<p>
Tu peux dès à présent te connecter sur le serveur (en 1.8.3).
IP serveur : 176.31.170.123:25565
</p>
<p>
N'hésite pas à venir sur le TeamSpeak et à demander de l'aide aux autres joueurs.
Et n'oublie pas de lire les règles si ce n'est pas déjà fait.
</p>
<p>
Bon jeu
</p>
<p>
Pour rappel :
A ton arrivée, tu devras trouver ta parcelle par toi même ou en demandant à un modérateur/helper.
Une fois ta parcelle trouvé, un modérateur t’attribuera cette parcelle pour que tu puisses construire ta maison.
Après avoir construit ta maison, tu devras la faire valider par un modérateur pour créer ou avoir accès aux projets.
Tu peux ramasser librement des ressources sur la map Ferme.
</p>
<p>
N'oublie pas de rejoindre :
<ul>
<li>
La page <a href=\"https://www.facebook.com/ZrTCraft\">Facebook</a>
</li>

<li>
Notre <a href=\"https://twitter.com/ZrtCraft\">Twitter</a>
</li>

<li>
La communauté <a href=\" https://plus.google.com/+ZrtCraft/\">Google+</a>
</li>

<li>
Notre chaîne <a href=\"https://www.youtube.com/c/ZrtCraft\">Youtube</a>
</li>

</ul>
</p>
"
);
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

    public function delCatAction($idCat,Request $request, Application $app){

        $cat=$app['dao.categorie']->loadCategorieById($idCat);

        if( ! $cat->getSectionSite()->getAdmins()->contains($app['security']->getToken()->getUser()) ){
            throw new \Exception("La modification de l'arboressence du forum est réservé aux admins");
        }

        $app['dao.categorie']->remove($cat);
        return $app->redirect($request->getBasePath().'/admin/'.$cat->getSectionSite()->getName().'/forum');

    }

    public function delScatAction($idSCat,Request $request, Application $app){

        $cat=$app['dao.scat']->loadSousCategorieById($idSCat);

        if( ! $cat->getSectionSite()->getAdmins()->contains($app['security']->getToken()->getUser()) ){
            throw new \Exception("La modification de l'arboressence du forum est réservé aux admins");
        }

        $app['dao.scat']->remove($cat);
        return $app->redirect($request->getBasePath().'/admin/'.$cat->getSectionSite()->getName().'/forum');

    }

    public function reglementAction(Request $request, Application $app){
        $reglement = $app['dao.regle']->loadRegleById(1);
        return $app['twig']->render( "admin-reglement.html",array(
            'panelname' => "Reglement",
            'reglement' => $reglement
            )
        );
    }

    public function reglementAddAction($regleId, Request $request, Application $app){

        $user = $app['security']->getToken()->getUser();
        $section = $app['dao.section']->loadByName("zrtcraft");

        if( !$section->getAdmins()->contains($user) && ! $section->getModos()->contains($user) ){
            throw new \Exception("Cette section est réservé a la modération zrtcraft");
        }

        $parent = $app['dao.regle']->loadRegleById($regleId);
        $regle = new Regle();
        $regle->setParent($parent);
        $form = $app['form.factory']->create(new RegleType, $regle);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
            $app['dao.regle']->save($regle);
            return $app->redirect($request->getBasePath().'/admin/reglement');
        }

        return $app['twig']->render( "admin-reglement-add.html",array(
            'panelname' => "Reglement",
            'form' => $form->createView()
            )
        );
    }

    public function reglementDelAction($regleId, Request $request, Application $app){

        $user = $app['security']->getToken()->getUser();
        $section = $app['dao.section']->loadByName("zrtcraft");

        if( !$section->getAdmins()->contains($user) && ! $section->getModos()->contains($user) ){
            throw new \Exception("Cette section est réservé a la modération zrtcraft");
        }

        $regle=$app['dao.regle']->loadRegleById($regleId);
        $app['dao.regle']->remove($regle);
        return $app->redirect($request->getBasePath().'/admin/reglement');
    }

    public function reglementModifyAction($regleId, Request $request, Application $app){

        $user = $app['security']->getToken()->getUser();
        $section = $app['dao.section']->loadByName("zrtcraft");

        if( !$section->getAdmins()->contains($user) && ! $section->getModos()->contains($user) ){
            throw new \Exception("Cette section est réservé a la modération zrtcraft");
        }

        $regle = $app['dao.regle']->loadRegleById($regleId);
        $form = $app['form.factory']->create(new RegleType, $regle);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
            $app['dao.regle']->save($regle);
            return $app->redirect($request->getBasePath().'/admin/reglement');
        }

        return $app['twig']->render( "admin-reglement-add.html",array(
            'panelname' => "Reglement",
            'form' => $form->createView()
            )
        );
    }
    public function userListAction(Request $request, Application $app){
        $users = $app['orm.em']->getRepository('Zrtcommunity\Domain\User')->findall();

        return $app['twig']->render( "admin-users-list.html",array(
            'panelname' => "Liste des membres",
            'users' => $users,
            ));
    }
    public function userModAction($userid, Request $request, Application $app){
        $user = $app['dao.user']->find($userid);
        $questionaire = $user->getQuestionaireZrtCraft();
        $ancienRole = $user->getRole();

        $form = $app['form.factory']->create(new ModRoleType, $user);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){

            $current = $app['security']->getToken()->getUser();

            $section = $app['dao.section']->find($form["sectionSite"]->getData());

            $roleSection = $form["RolesectionSite"]->getData();

            switch($roleSection) {
                case 1:
                    $modos = $section->getModos();
                    $admins = $section->getAdmins();
                    if( !( $app['security']->isGranted('ROLE_ADMIN') || $admins->contains($current) ) ){
                        throw new \Exception("Seuls les admins globaux ou de section peuvent attribuer le role d'admin de section");
                    }
                    if( !( $user->getRole() == 'ROLE_ADMIN' ) ){
                        $user->setRole('ROLE_MODO');
                    }
                    if( !($admins->contains($user) )){
                        $admins->add($user);
                    }
                    if( ($modos->contains($user) )){
                        $modos->removeElement($user);
                    }
                    $app['dao.section']->save($section);
                    break;

                case 2:
                    $modos = $section->getModos();
                    $admins = $section->getAdmins();
                    if( !( $app['security']->isGranted('ROLE_ADMIN') || $admins->contains($current) ) ){
                        throw new \Exception("Seuls les admins globaux ou de section peuvent attribuer le role de modo de section");
                    }
                    if( !( $user->getRole() == 'ROLE_ADMIN' ) ){
                        $user->setRole('ROLE_MODO');
                    }
                    if( !($modos->contains($user) )){
                        $modos->add($user);
                    }
                    if( ($admins->contains($user) )){
                        $admins->removeElement($user);
                    }
                    $app['dao.section']->save($section);
                    break;

                case 0:
                    break;

                default:
                    break;
            }

            if(
                $ancienRole != $user->getRole() &&
                $user->getRole() == 'ROLE_ADMIN' &&
                !$app['security']->isGranted('ROLE_ADMIN')
            ){
                throw new \Exception("Seuls les admins globaux peuvent attribuer le role d'admin global");
            }

            if(
                $ancienRole != $user->getRole() &&
                $ancienRole == 'ROLE_MODO' &&
                !$app['security']->isGranted('ROLE_ADMIN')
            ){
                throw new \Exception("Seuls les admins globaux peuvent réduire le role d'un modo");
            }

            $app['dao.user']->save($user);

            return $app->redirect($request->getBasePath().'/admin/users/'.$user->getId());
        }

        return $app['twig']->render( "admin-users-mod.html",array(
            'panelname' => $user->getUsername(),
            'user' => $user,
            'form' => $form->createView(),
            'questionaire' => $questionaire
        ));
    }

    public function staffAction($sectionId, Request $request, Application $app){

        $section = $app['dao.section']->loadByName($sectionId);

        return $app['twig']->render( "admin-staff-list.html",array(
            'panelname' => "Staff ".$section->getName(),
            'section' => $section,
            ));
    }

    public function staffUserAction($userid, $sectionId, Request $request, Application $app){
        $user = $app['dao.user']->find($userid);
        $section = $app['dao.section']->loadByName($sectionId);

        $modos = $section->getModos();
        $admins = $section->getAdmins();

        $modo = false;
        $admin = false;

        if( ($modos->contains($user) )){
            $modo=true;
        }
        if( ($admins->contains($user) )){
            $admin=true;
        }

        return $app['twig']->render( "admin-staff-membre.html",array(
            'panelname' => "Staff ".$section->getName(),
            'user' => $user,
            'section' => $section,
            'modo'=>$modo,
            'admin'=>$admin
            ));
    }

    public function staffUserDelAction($userid, $sectionId,Request $request, Application $app){
        $current = $app['security']->getToken()->getUser();

        if( !( $app['security']->isGranted('ROLE_ADMIN') || $admins->contains($current) ) ){
            throw new \Exception("Seuls les admins globaux ou de section peuvent supprimer un membre du staff d'une section");
        }

        $user = $app['dao.user']->find($userid);
        $section = $app['dao.section']->loadByName($sectionId);

        $modos = $section->getModos();
        $admins = $section->getAdmins();

        if( ($admins->contains($user) )){
            $admins->removeElement($user);
        }
        if( ($modos->contains($user) )){
            $modos->removeElement($user);
        }
        $app['dao.section']->save($section);

        return $app->redirect($request->getBasePath()."/admin/".$section->getName()."/staff");

    }

    public function staffUserModAction($userid, $sectionId,Request $request, Application $app){
        $current = $app['security']->getToken()->getUser();

        if( !( $app['security']->isGranted('ROLE_ADMIN') || $admins->contains($current) ) ){
            throw new \Exception("Seuls les admins globaux ou de section peuvent supprimer un membre du staff d'une section");
        }

        $user = $app['dao.user']->find($userid);
        $section = $app['dao.section']->loadByName($sectionId);

        $modos = $section->getModos();
        $admins = $section->getAdmins();

        if( ($admins->contains($user) )){
            $modos->add($user);
            $admins->removeElement($user);
        }elseif( ($modos->contains($user) )){
            $modos->removeElement($user);
            $admins->add($user);
        }
        $app['dao.section']->save($section);

        return $app->redirect($request->getBasePath()."/admin/".$section->getName()."/staff/".$user->getId());

    }

}
