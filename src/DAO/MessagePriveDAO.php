<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\MessagePrive;
use Zrtcommunity\Domain\User;

class MessagePriveDAO extends DAO{
    public function save(MessagePrive $mess){
        $this->getEm()->persist($mess);
        $this->getEm()->flush();
    }
    public function loadMessageById($id){
        $mess= $this->getEm()->getRepository('Zrtcommunity\Domain\MessagePrive')->findOneBy(array('id' => $id));

        if ($mess === null){
            throw new \Exception("No Message matching id " . $id);
        }else{
            return $mess;
        }
    }
    public function loadMessageByAuteur(User $auteur){
        $mess= $this->getEm()->getRepository('Zrtcommunity\Domain\MessagePrive')->findBy(array('auteur' => $auteur),array('date'=>'desc'));
        if ($mess === null){
            throw new \Exception("No Message matching id " . $id);
        }else{
            return $mess;
        }
    }

    public function loadMessageByDestinataire(User $dest){
        $mess= $this->getEm()->getRepository('Zrtcommunity\Domain\MessagePrive')->findBy(array('destinataire' => $dest),array('date'=>'desc'));
        if ($mess === null){
            throw new \Exception("No Message matching id " . $id);
        }else{
            return $mess;
        }
    }
    public function countNonLuByDestinataire(User $dest){
        $mess= $this->getEm()->getRepository('Zrtcommunity\Domain\MessagePrive')->findBy(array('destinataire' => $dest,'lu'=>false),array('date'=>'desc'));
        if ($mess === null){
            throw new \Exception("No Message matching id " . $id);
        }else{
            return count($mess);
        }
    }
}
