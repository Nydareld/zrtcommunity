<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\SousCategorie;

class SousCategorieDAO extends DAO{

    public function save(SousCategorie $scat){
        $this->getEm()->persist($scat);
        $this->getEm()->flush();
    }

    public function remove(SousCategorie $scat){
        $this->getEm()->remove($scat);
        $this->getEm()->flush();
    }


    public function loadSousCategorieByName($name){
        $scat= $this->getEm()->getRepository('Zrtcommunity\Domain\SousCategorie')->findOneBy(array('name' => $name));

        if ($scat === null){
            throw new \Exception("No Categorie matching name " . $name);
        }else{
            return $scat;
        }
    }

    public function loadSousCategorieById($id){
        $scat= $this->getEm()->getRepository('Zrtcommunity\Domain\SousCategorie')->findOneBy(array('id' => $id));

        if ($scat === null){
            throw new \Exception("No Categorie matching id " . $id);
        }else{
            return $scat;
        }
    }



    public function findAllNamesAsArray(){
        $names = array();

        $scats= $this->getEm()->getRepository('Zrtcommunity\Domain\SousCategorie')->findAll();

        if ($scats === null){
            throw new \Exception("No Regions");
        }

        foreach($scats as $scats){
            $names[$scats->getId()] = $scats->path();
        }

        return $names;
    }

    public function findAllNamesAsArrayBySection($section){
        $names = array();

        $scats= $this->getEm()->getRepository('Zrtcommunity\Domain\SousCategorie')->findAll();

        if ($scats === null){
            throw new \Exception("No Regions");
        }

        foreach($scats as $scat){
            if($scat->getSectionSite()->getName()==$section){
                $names[$scat->getId()] = $scat->path();
            }
        }

        return $names;
    }

}
