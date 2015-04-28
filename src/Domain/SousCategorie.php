<?php

namespace Zrtcommunity\Domain;

/**
 * @MappedSuperclass
 **/
abstract class SousCategorie extends ForumContainer{

    /**
     * @Column(type="string")
     **/
    protected $description;
    /**
     * @ManyToOne(targetEntity="Categorie", inversedBy="childs")
     **/
    protected $parentCategorie;
    /**
     * @ManyToOne(targetEntity="SousCategorieContainer", inversedBy="childs")
     **/
    protected $parentSousCategorie;

    public function getDescription(){
		return $this->description;
	}

	public function setDescription($description){
		$this->description = $description;
	}

	public function getParentCategorie(){
		return $this->parentCategorie;
	}

	public function setParentCategorie($parentCategorie){
        $this->setParentSousCategorie(null);
		$this->parentCategorie = $parentCategorie;
	}

	public function getParentSousCategorie(){
		return $this->parentSousCategorie;
	}

	public function setParentSousCategorie($parentSousCategorie){
        $this->setParentCategorie(null);
		$this->parentSousCategorie = $parentSousCategorie;
	}
}
