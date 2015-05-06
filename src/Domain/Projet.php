<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="projet")
 **/
class Projet{

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
     * @Column(type="string",length=10000)
     * @var string
     */
    private $description;

    /**
     * @Column(type="datetime")
     * @var datetime
     */
    private $date;

    /**
     * @Column(type="boolean")
     * @var boolean
     */
    private $accepted;

    /**
     * @Column(type="boolean")
     * @var boolean
     */
    private $finished;

    /**
     * @Column(type="integer",nullable=true)
     * @var int
     */
    private $localisationX;

    /**
     * @Column(type="integer",nullable=true)
     * @var int
     */
    private $localisationY;

    /**
     * @ManyToOne(targetEntity="Region", inversedBy="projets")
     */
    private $region;

    /**
     * @OneToMany(targetEntity="MembreProjet", mappedBy="projet")
     */
    private $membresProjets;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="projets")
     */
    private $createur;

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

    public function getDate(){
		return $this->date;
	}

	public function setDate($date){
		$this->date = $date;
	}

	public function isAccepted(){
		return $this->accepted;
	}

	public function setAccepted($accepted){
		$this->accepted = $accepted;
	}

	public function isFinished(){
		return $this->finished;
	}

	public function setFinished($finished){
		$this->finished = $finished;
	}

	public function getLocalisationX(){
		return $this->localisationX;
	}

	public function setLocalisationX($localisationX){
		$this->localisationX = $localisationX;
	}

	public function getLocalisationY(){
		return $this->localisationY;
	}

	public function setLocalisationY($localisationY){
		$this->localisationY = $localisationY;
	}

	public function getRegion(){
		return $this->region;
	}

	public function setRegion($region){
		$this->region = $region;
	}

	public function getMembresProjets(){
		return $this->membresProjets;
	}

	public function setMembresProjets($membresProjets){
		$this->membresProjets = $membresProjets;
	}

    public function getCreateur(){
		return $this->createur;
	}

	public function setCreateur($createur){
		$this->createur = $createur;
	}

}
