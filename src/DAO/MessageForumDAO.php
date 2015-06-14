<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\MessageForum;

class MessageForumDAO extends DAO{
    public function save(MessageForum $mess){
        $this->getEm()->persist($mess);
        $this->getEm()->flush();
    }
    public function loadMessageById($id){
        $mess= $this->getEm()->getRepository('Zrtcommunity\Domain\MessageForum')->findOneBy(array('id' => $id));

        if ($mess === null){
            throw new \Exception("No topic matching id " . $id);
        }else{
            return $mess;
        }
    }
}
