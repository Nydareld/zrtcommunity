<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\MessageNews;

class MessageNewsDAO extends DAO{
    public function save(MessageNews $mess){
        $this->getEm()->persist($mess);
        $this->getEm()->flush();
    }
    public function loadMessageById($id){
        $mess= $this->getEm()->getRepository('Zrtcommunity\Domain\MessageNews')->findOneBy(array('id' => $id));

        if ($mess === null){
            throw new \Exception("No news message matching id " . $id);
        }else{
            return $mess;
        }
    }
}
