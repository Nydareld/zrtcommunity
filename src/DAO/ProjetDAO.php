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
}
