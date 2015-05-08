<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="messageprive")
 **/
class MessagePrive{

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
     * @Column(type="string")
     * @var string
     */
    private $titre;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="messagesenvoi")
     */
    private $auteur;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="messagesrecu")
     */
    private $destinataire;


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

     public function getTitre(){
   		return $this->titre;
   	}

   	public function setTitre($titre){
   		$this->titre = $titre;
   	}

   	public function getAuteur(){
   		return $this->auteur;
   	}

   	public function setAuteur($auteur){
   		$this->auteur = $auteur;
   	}

   	public function getDestinataire(){
   		return $this->destinataire;
   	}

   	public function setDestinataire($destinataire){
   		$this->destinataire = $destinataire;
   	}


}
