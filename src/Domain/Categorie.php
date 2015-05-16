<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="categories")
 **/
class Categorie extends ForumContainer{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @OneToMany(targetEntity="SousCategorie", mappedBy="parentCategorie", orphanRemoval=true)
     */
    private $childs;

    public function getId(){
		return $this->id;
	}

    public function getChilds(){
		return $this->childs;
	}
}
