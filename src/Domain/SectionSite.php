<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="sectionsite")
 **/
class SectionSite{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     *@Column(type="string")
     */
    protected $name;

    /**
     *@Column(type="string")
     */
    protected $pathIcone;

    /**
     * @OneToMany(targetEntity="Categorie", mappedBy="sectionSite", orphanRemoval=true)
     */
    private $categories;

    public function getId(){
  		return $this->id;
  	}

  	public function setId($id){
  		$this->id = $id;
  	}

  	public function getName(){
  		return $this->name;
  	}

  	public function setName($name){
  		$this->name = $name;
  	}

  	public function getPathIcone(){
  		return $this->pathIcone;
  	}

  	public function setPathIcone($pathIcone){
  		$this->pathIcone = $pathIcone;
  	}

  	public function getCategories(){
  		return $this->categories;
  	}

  	public function setCategories($categories){
  		$this->categories = $categories;
  	}

}
