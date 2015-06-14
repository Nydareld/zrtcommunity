<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\Region;

class RegionDAO extends DAO{
    public function save(Region $region){
        $this->getEm()->persist($region);
        $this->getEm()->flush();
    }
    public function findAllNamesAsArray(){
        $names = array();

        $regions= $this->getEm()->getRepository('Zrtcommunity\Domain\Region')->findAll();

        if ($regions === null){
            throw new \Exception("No Regions");
        }

        foreach($regions as $region){
            $names[$region->getId()] = $region->getName()." - ".$region->getDescriptionRapide();
        }

        return $names;
    }
    public function loadRegionById($id){
        $news= $this->getEm()->getRepository('Zrtcommunity\Domain\Region')->findOneBy(array('id' => $id));

        if ($news === null){
            throw new \Exception("No region matching id " . $id);
        }else{
            return $news;
        }
    }
    public function loadAllRegion(){
        $regions= $this->getEm()->getRepository('Zrtcommunity\Domain\Region')->findAll();
        if ($regions=== null){
            throw new \Exception("No Regions");
        }else{
            return $regions;
        }
    }
}
