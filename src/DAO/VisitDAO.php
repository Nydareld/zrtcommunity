<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\Visit;

class VisitDAO extends DAO{
    public function save(Visit $visit){
        $this->getEm()->persist($visit);
        $this->getEm()->flush();
    }
}
