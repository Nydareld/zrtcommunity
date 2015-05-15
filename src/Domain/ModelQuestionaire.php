<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="modelquestionaire")
 **/
class ModelQuestionaire{

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
    private $inUse;

    /**
     * @OneToMany(targetEntity="Question", mappedBy="model",cascade={"persist"})
     */
    protected $questions;

    /**
     * @OneToMany(targetEntity="Questionaire", mappedBy="model")
     */
    protected $questionaires;

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

	public function isInUse(){
		return $this->inUse;
	}

	public function setInUse($inUse){
		$this->inUse = $inUse;
	}

    public function getQuestions(){
		return $this->questions;
	}

	public function setQuestions($questions){
		$this->questions = $questions;
	}
    
    public function getQuestionaires(){
		return $this->questionaires;
	}

	public function setQuestionaires($questionaires){
		$this->questionaires = $questionaires;
	}

}
