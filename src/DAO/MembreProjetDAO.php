<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\MembreProjet;

class MembreProjetDAO extends DAO{
    public function save(MembreProjet $region){
        $this->getEm()->persist($region);
        $this->getEm()->flush();
    }
}
