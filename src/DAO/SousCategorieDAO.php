<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\SousCategorie;

class SousCategorieDAO extends DAO{

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

}
