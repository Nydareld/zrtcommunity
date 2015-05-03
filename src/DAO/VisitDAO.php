<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\Visit;

class VisitDAO extends DAO{

    public function save(Visit $visit){
        $this->getEm()->persist($visit);
        $this->getEm()->flush();
    }

    public function loadCurrentVisit( $ip, $date){
        $visit = $this->getEm()->getRepository('Zrtcommunity\Domain\Visit')
            ->findOneBy(array(
                'ip'=>$ip,
                'date'=>$date,
            ));
        if ($visit === null){
            return null;
        }else{
            return $visit;
        }
    }

}
