<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="categories")
 **/
class Categorie extends ForumContainer{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     **/
    private $id;

    /**
     * @OneToMany(targetEntity="SousCategorie", mappedBy="parent")
     **/
    private $childs;

    public function getId(){
		return $this->id;
	}

    public function getChilds(){
		return $this->childs;
	}
}
