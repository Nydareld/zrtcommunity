<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="topics")
 **/
class Topic{
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
    private $description;
    /**
     * @ManyToOne(targetEntity="User", inversedBy="topics")
     */
    private $creator;

    /**
     * @ManyToOne(targetEntity="SousCategorie", inversedBy="topics")
     */
    private $sousCategorie;

    /**
     * @OneToMany(targetEntity="MessageForum", mappedBy="topic")
     */
    protected $messages;

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
	public function getCreator(){
		return $this->creator;
	}
	public function getCategorie(){
		return $this->categorie;
	}
	public function setCategorie($categorie){
		$this->categorie = $categorie;
	}
    public function getMessages(){
        return $this->messages;
    }
}
