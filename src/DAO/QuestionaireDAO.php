<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\Questionaire;

class QuestionaireDAO extends DAO{
    public function save(Questionaire $que){
        $this->getEm()->persist($que);
        $this->getEm()->flush();
    }
}
