<?php

namespace Zrtcommunity\Domain;

/**
 *
 **/
class SousCategorieContainer extends SousCategorie{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    protected $id;


    public function getId(){
        return $this->id;
    }
}
