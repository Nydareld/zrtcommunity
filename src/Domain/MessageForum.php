<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="messageforum")
 **/
class MessageForum{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     **/
    private $id;

    /**
     * @Column(type="datetime")
     * @var datetime
     */
    private $date;

    /**
     * @Column(type="string")
     * @var string
     **/
    private $contenu;

    /**
     * @ManyToOne(targetEntity="Topic", inversedBy="messages")
     **/
    private $topic;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="messagesforum")
     **/
    private $auteur;



    public function getId(){
		return $this->id;
	}

	public function getDate(){
		return $this->date;
	}

	public function getContenu(){
		return $this->contenu;
	}

	public function setContenu($contenu){
		$this->contenu = $contenu;
	}

	public function getTopic(){
		return $this->topic;
	}

	public function getAuteur(){
		return $this->auteur;
	}

}
