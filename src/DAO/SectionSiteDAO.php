<?php

namespace Zrtcommunity\DAO;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Zrtcommunity\Domain\User;

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
}
