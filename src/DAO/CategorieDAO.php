<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\Categorie;

class CategorieDAO extends DAO{

    public function loadCategorieByName($name){
        $categorie= $this->getEm()->getRepository('Zrtcommunity\Domain\Categorie')->findOneBy(array('name' => $name));

        if ($categorie === null){
            throw new \Exception("No Categorie matching name " . $name);
        }else{
            return $categorie;
        }
    }
    public function loadCategorieById($id){
        $categorie= $this->getEm()->getRepository('Zrtcommunity\Domain\Categorie')->findOneBy(array('id' => $id));

        if ($categorie === null){
            throw new \Exception("No Categorie matching id " . $id);
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
    public function save(categorie $cat){
        $this->getEm()->persist($cat);
        $this->getEm()->flush();
    }

    public function findAllNamesAsArray(){
        $names = array();

        $cats= $this->getEm()->getRepository('Zrtcommunity\Domain\Categorie')->findAll();

        if ($cats === null){
            throw new \Exception("No Regions");
        }

        foreach($cats as $cat){
            $names[$cat->getId()] = $cat->getName();
        }

        return $names;
    }

}
