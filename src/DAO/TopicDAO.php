<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\Topic;

class TopicDAO extends DAO{

    public function loadTopicById($id){
        $topic= $this->getEm()->getRepository('Zrtcommunity\Domain\Topic')->findOneBy(array('id' => $id));

        if ($topic === null){
            throw new \Exception("No topic matching id " . $id);
        }else{
            return $topic;
        }
    }

}
