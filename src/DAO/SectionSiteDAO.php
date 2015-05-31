<?php

namespace Zrtcommunity\DAO;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Zrtcommunity\Domain\User;
use Zrtcommunity\Domain\SectionSite;

class SectionSiteDAO extends DAO{

    public function find($id){

        $section = $this->getEm()->find("Zrtcommunity\Domain\SectionSite", (int)$id);

        if ($section === null){
            throw new \Exception("No user matching id " . $id);
        }else{
            return $section;
        }
    }

    public function loadByName($name){
        $section = $this->getEm()->getRepository('Zrtcommunity\Domain\SectionSite')->findOneBy(array('name' => $name));

        if ($section === null){
            return null;
        }else{
            return $section;
        }
    }

    public function loadAllSections(){
        $sections= $this->getEm()->getRepository('Zrtcommunity\Domain\SectionSite')->findAll();
        if ($sections === null){
            throw new \Exception("No Categories");
        }else{
            return $sections;
        }
    }
    public function findAllNamesAsArray(){
        $names = array();

        $cats= $this->loadAllSections();

        if ($cats === null){
            throw new \Exception("No sections");
        }

        foreach($cats as $cat){
            $names[$cat->getId()] = $cat->getName();
        }

        return $names;
    }
    public function save(SectionSite $section){
        $this->getEm()->persist($section);
        $this->getEm()->flush();
    }

}
