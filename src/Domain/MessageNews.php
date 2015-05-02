<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="messagenews")
 **/
class MessageNews{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @Column(type="datetime")
     * @var datetime
     */
    private $date;

    /**
     * @Column(type="string",length=5000)
     * @var string
     */
    private $contenu;

    /**
     * @ManyToOne(targetEntity="News", inversedBy="messages")
     */
    private $news;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="messagesnews")
     */
    private $auteur;

    public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
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

	public function getNews(){
		return $this->news;
	}

	public function setNews($news){
		$this->news = $news;
	}

	public function getAuteur(){
		return $this->auteur;
	}

	public function setAuteur($auteur){
		$this->auteur = $auteur;
	}
}
