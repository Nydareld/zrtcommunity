<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\Question;

class QuestionDAO extends DAO{
    public function save(Question $que){
        $this->getEm()->persist($que);
        $this->getEm()->flush();
    }
}
