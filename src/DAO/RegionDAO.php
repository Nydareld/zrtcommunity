<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\Region;

class RegionDAO extends DAO{
    public function save(Region $region){
        $this->getEm()->persist($region);
        $this->getEm()->flush();
    }
}
