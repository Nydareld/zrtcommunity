<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="questionaire")
 **/
class Questionaire{

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
     * @Column(type="boolean")
     * @var boolean
     */
    private $accepted;

    /**
     * @OneToMany(targetEntity="Reponse", mappedBy="questionaire",cascade={"persist"})
     */
    protected $reponses;

    /**
     * @OneToOne(targetEntity="User", mappedBy="questionaireZrtCraft")
     */
    protected $user;

    /**
     * @ManyToOne(targetEntity="ModelQuestionaire", inversedBy="questionaires")
     */
    private $model;

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

	public function getAccepted(){
		return $this->accepted;
	}

	public function setAccepted($accepted){
		$this->accepted = $accepted;
	}

	public function getReponses(){
		return $this->reponses;
	}

	public function setReponses($reponses){
		$this->reponses = $reponses;
	}

	public function getUser(){
		return $this->user;
	}

	public function setUser($user){
		$this->user = $user;
	}

    public function getModel(){
		return $this->model;
	}

	public function setModel($model){
		$this->model = $model;
	}

}
