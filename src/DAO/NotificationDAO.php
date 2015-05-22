<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\Notification;

class NotificationDAO extends DAO{
    public function save(Notification $notif){
        $this->getEm()->persist($notif);
        $this->getEm()->flush();
    }

    public function remove(Notification $notif){
        $this->getEm()->remove($notif);
        $this->getEm()->flush();
    }

    public function loadNotifById($id){
        $news= $this->getEm()->getRepository('Zrtcommunity\Domain\Notification')->findOneBy(array('id' => $id));

        if ($news === null){
            return null;
        }else{
            return $news;
        }
    }
    public function existPathUser($path,$user){
        $notif= $this->getEm()->getRepository('Zrtcommunity\Domain\Notification')->findOneBy(array('path' => $path, 'user'=>$user));

        if ($notif === null){
            return false;
        }else{
            return true;
        }
    }

}
