<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="regle")
 **/
class Regle{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @Column(type="string")
     * @var string
     */
    private $intitule;

    /**
     * @Column(type="string",length=5000)
     * @var string
     */
    private $message;

    /**
     * @ManyToOne(targetEntity="Regle", inversedBy="childs")
     */
    private $parent;

    /**
     * @OneToMany(targetEntity="Regle", mappedBy="parent", orphanRemoval=true)
     **/
    private $childs;

    public function getId(){
  		return $this->id;
  	}

  	public function setId($id){
  		$this->id = $id;
  	}

  	public function getIntitule(){
  		return $this->intitule;
  	}

  	public function setIntitule($intitule){
  		$this->intitule = $intitule;
  	}

  	public function getMessage(){
  		return $this->message;
  	}

  	public function setMessage($message){
  		$this->message = $message;
  	}

  	public function getParent(){
  		return $this->parent;
  	}

  	public function setParent($parent){
  		$this->parent = $parent;
  	}

  	public function getChilds(){
  		return $this->childs;
  	}

  	public function setChilds($childs){
  		$this->childs = $childs;
  	}

}
