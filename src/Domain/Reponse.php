<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="reponse")
 **/
class Reponse{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @Column(type="string",length=1000)
     * @var string
     */
    private $reponse;

    /**
     * @ManyToOne(targetEntity="Questionaire", inversedBy="reponses")
     */
    private $questionaire;

    /**
     * @ManyToOne(targetEntity="Question", inversedBy="reponses")
     */
    private $question;
    
    public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getReponse(){
		return $this->reponse;
	}

	public function setReponse($reponse){
		$this->reponse = $reponse;
	}

	public function getQuestionaire(){
		return $this->questionaire;
	}

	public function setQuestionaire($questionaire){
		$this->questionaire = $questionaire;
	}

	public function getQuestion(){
		return $this->question;
	}

	public function setQuestion($question){
		$this->question = $question;
	}


}
