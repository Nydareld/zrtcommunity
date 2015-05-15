<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\ModelQuestionaire;

class ModelQuestionaireDAO extends DAO{
    public function save(ModelQuestionaire $model){
        $this->getEm()->persist($model);
        $this->getEm()->flush();
    }

    public function loadModelById($idmodel){
        $model= $this->getEm()->getRepository('Zrtcommunity\Domain\ModelQuestionaire')->findOneBy(array('id' => $idmodel));

        if ($model === null){
            throw new \Exception("No model");
        }else{
            return $model;
        }
    }

    public function loadInUse(){
        $model= $this->getEm()->getRepository('Zrtcommunity\Domain\ModelQuestionaire')->findOneBy(array('inUse' => true));

        if ($model === null){
            throw new \Exception("No model");
        }else{
            return $model;
        }
    }

}
