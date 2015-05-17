<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\Regle;

class RegleDAO extends DAO{

    public function save(Regle $regle){
        $this->getEm()->persist($regle);
        $this->getEm()->flush();
    }
    public function remove(Regle $regle){
        $this->getEm()->remove($regle);
        $this->getEm()->flush();
    }
    public function loadRegleById($id){
        $regle= $this->getEm()->getRepository('Zrtcommunity\Domain\Regle')->findOneBy(array('id' => $id));

        if ($regle === null){
            throw new \Exception("No regle matching id " . $id);
        }else{
            return $regle;
        }
    }
}
