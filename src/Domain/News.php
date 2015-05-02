<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="news")
 **/
class News{
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
     * @Column(type="datetime")
     * @var datetime
     */
    private $date;
    /**
     * @Column(type="string",length=10000)
     * @var string
     */
    private $contenu;
    /**
     * @ManyToOne(targetEntity="User", inversedBy="news")
     */
    private $creator;
    /**
     * @OneToMany(targetEntity="MessageNews", mappedBy="news")
     */
    protected $messages;

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

	public function getDate(){
		return $this->date;
	}

	public function setDate($date){
		$this->date = $date;
	}

	public function getContenu(){
		return $this->contenu;
	}

	public function setContenu($contenu){
		$this->contenu = $contenu;
	}

	public function getCreator(){
		return $this->creator;
	}

	public function setCreator($creator){
		$this->creator = $creator;
	}

	public function getMessages(){
		return $this->messages;
	}

	public function setMessages($messages){
		$this->messages = $messages;
	}
}
