<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="categories")
 **/
class Categorie{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     **/
    private $id;

    /**
     * @Column(type="string")
     * @var string
     **/
    private $name;

    /**
     * @Column(type="string")
     * @var string
     **/
    private $description;

    /**
     * @Column(type="integer")
     * @var int
     **/
    private $order;

    /**
     * @ManyToOne(targetEntity="Categorie", inversedBy="childs")
     **/
    private $parent;

    public function getId(){
		return $this->id;
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

	public function getOrder(){
		return $this->order;
	}

	public function setOrder($order){
		$this->order = $order;
	}

	public function getParent(){
		return $this->parent;
	}

	public function setParent($parent){
		$this->parent = $parent;
	}
}
