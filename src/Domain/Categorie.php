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

    /**
     * @ManyToOne(targetEntity="SectionSite", inversedBy="categories")
     */
    protected $sectionSite;

    public function getId(){
  		return $this->id;
  	}

  	public function setId($id){
  		$this->id = $id;
  	}

  	public function getChilds(){
  		return $this->childs;
  	}

  	public function setChilds($childs){
  		$this->childs = $childs;
  	}

  	public function getSectionSite(){
  		return $this->sectionSite;
  	}

  	public function setSectionSite($sectionSite){
  		$this->sectionSite = $sectionSite;
  	}

    public function path(){
        return $this->getName();
    }

}
