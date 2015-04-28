<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="souscategoriefinale")
 **/
class SousCategorieFinal extends SousCategorie{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     **/
    protected $id;

    public function getId(){
        return $this->id;
    }

}
