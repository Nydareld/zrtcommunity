<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\Projet;

class ProjetDAO extends DAO{
    public function save(Projet $projet){
        $this->getEm()->persist($projet);
        $this->getEm()->flush();
    }
}
