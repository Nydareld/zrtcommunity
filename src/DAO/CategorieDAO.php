<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\Categorie;

class CategorieDAO extends DAO{

    public function loadCategorieByName($name){
        $categorie= $this->getEm()->getRepository('Zrtcommunity\Domain\Categorie')->findOneBy(array('name' => $name));

        if ($categorie === null){
            throw new \Exception("No Categorie matching name " . $id);
        }else{
            return $categorie;
        }
    }
    public function loadAllCategories(){
        $categories= $this->getEm()->getRepository('Zrtcommunity\Domain\Categorie')->findAll();
        if ($categories === null){
            throw new \Exception("No Categories");
        }else{
            return $categories;
        }
    }

}
