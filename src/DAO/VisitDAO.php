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

    public function findAll(){
        return $this->getEm()->getRepository('Zrtcommunity\Domain\Visit')->findAll();
    }

    public function findUserVisitByDay($day){
        $qb= $this->getEm()->createQueryBuilder();

        $qb->select('v')
            ->from('Zrtcommunity\Domain\Visit','v')
            ->where('v.date = :date')
            ->andWhere('v.visitor IS NOT NULL')
            ->setParameter('date', $day->format('Y-m-d'));

        $query = $qb->getQuery();
        return count($query->getResult());
    }

    public function findGuestVisitByDay($day){
        $qb= $this->getEm()->createQueryBuilder();

        $qb->select('v')
            ->from('Zrtcommunity\Domain\Visit','v')
            ->where('v.date = :date')
            ->andWhere('v.visitor IS NULL')
            ->setParameter('date', $day->format('Y-m-d'));

        $query = $qb->getQuery();
        return count($query->getResult());
    }

    public function findVisitByNavigator(){
        $qb= $this->getEm()->createQueryBuilder();

        $qb->select('v.navigator, count(v.navigator) nb')
            ->from('Zrtcommunity\Domain\Visit','v')
            ->groupBy('v.navigator');
        return $query = $qb->getQuery()->getResult();
    }


}
