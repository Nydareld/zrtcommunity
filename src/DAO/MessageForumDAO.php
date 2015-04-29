<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\MessageForum;

class MessageForumDAO extends DAO{
    public function save(MessageForum $mess){
        $this->getEm()->persist($mess);
        $this->getEm()->flush();
    }
}
