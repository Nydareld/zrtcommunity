<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\VisitActionPath;

class VisitActionPathDAO extends DAO{
    public function save(VisitActionPath $visitActionPath){
        $this->getEm()->persist($mess);
        $this->getEm()->flush();
    }
}
