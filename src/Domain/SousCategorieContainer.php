<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="souscategoriecontainer")
 **/
class SousCategorieContainer extends SousCategorie{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     **/
    protected $id;

    /**
     * @OneToMany(targetEntity="SousCategorie", mappedBy="parentSousCategorie")
     **/
    protected $childs;

    public function getId(){
		return $this->id;
	}

	public function getChilds(){
		return $this->childs;
	}

	public function setChilds($childs){
		$this->childs = $childs;
	}
}
