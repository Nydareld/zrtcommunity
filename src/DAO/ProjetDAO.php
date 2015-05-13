<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\Projet;

class ProjetDAO extends DAO{
    public function save(Projet $projet){
        $this->getEm()->persist($projet);
        $this->getEm()->flush();
    }
    public function loadAllProjet(){
        $projets= $this->getEm()->getRepository('Zrtcommunity\Domain\Projet')->findAll();
        if ($projets === null){
            throw new \Exception("No projects");
        }else{
            return $projets;
        }
    }
    public function loadProjetById($projetId){
        $projet= $this->getEm()->getRepository('Zrtcommunity\Domain\Projet')->findOneBy(array('id' => $projetId));

        if ($projet === null){
            throw new \Exception("No topic matching id " . $id);
        }else{
            return $projet;
        }
    }
    public function loadProjetNonValid(){
        $projets= $this->getEm()->getRepository('Zrtcommunity\Domain\Projet')->findBy(array('accepted' => false));
        if ($projets === null){
            throw new \Exception("No procjecs");
        }else{
            return $projets;
        }
    }
}
