<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="membreProjet")
 **/
class MembreProjet{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @Column(type="boolean")
     * @var boolean
     */
    private $owner;

    /**
     * @Column(type="string")
     * @var string
     */
    private $alias;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="membreProjet")
     */
    private $user;

    /**
     * @ManyToOne(targetEntity="Projet", inversedBy="membresProjets")
     */
    private $projet;

    public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getAlias(){
		return $this->alias;
	}

	public function setAlias($alias){
		$this->alias = $alias;
	}

	public function isOwner(){
		return $this->role;
	}

	public function setOwner($owner){
		$this->owner = $owner;
	}

	public function getUser(){
		return $this->user;
	}

	public function setUser($user){
		$this->user = $user;
	}

	public function getProjet(){
		return $this->projet;
	}

	public function setProjet($projet){
		$this->projet = $projet;
	}

}
