<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\ModelQuestionaire;

class ModelQuestionaireDAO extends DAO{
    public function save(ModelQuestionaire $model){
        $this->getEm()->persist($model);
        $this->getEm()->flush();
    }

    public function loadModelById($idmodel){
        $model= $this->getEm()->getRepository('Zrtcommunity\Domain\Model')->findOneBy(array('id' => $idmodel));

        if ($model === null){
            throw new \Exception("No model");
        }else{
            return $model;
        }
    }

}
