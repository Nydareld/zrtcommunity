<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="region")
 **/
class Region{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @Column(type="string")
     * @var string
     */
    private $name;

    /**
     * @Column(type="string")
     * @var string
     */
    private $descriptionRapide;

    /**
     * @Column(type="string",length=10000)
     * @var string
     */
    private $description;

    /**
     * @OneToMany(targetEntity="Projet", mappedBy="region")
     */
    private $projets;

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

	public function getDescription(){
		return $this->description;
	}

	public function setDescription($description){
		$this->description = $description;
	}

    public function getDescriptionRapide(){
        return $this->descriptionRapide;
    }

    public function setDescriptionRapide($descriptionRapide){
        $this->descriptionRapide = $descriptionRapide;
    }

	public function getProjets(){
		return $this->projets;
	}

	public function setProjets($projets){
		$this->projets = $projets;
	}
}
