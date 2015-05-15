<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\Questionaire;

class QuestionaireDAO extends DAO{
    public function save(Questionaire $que){
        $this->getEm()->persist($que);
        $this->getEm()->flush();
    }
    public function loadQuestionaireNonValid(){
        $questionaires= $this->getEm()->getRepository('Zrtcommunity\Domain\Questionaire')->findBy(array('accepted' => false));
        if ($questionaires === null){
            throw new \Exception("No procjecs");
        }else{
            return $questionaires;
        }
    }
}
