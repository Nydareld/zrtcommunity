<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="question")
 **/
class Question{

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
     * @ManyToOne(targetEntity="ModelQuestionaire", inversedBy="questions")
     */
    private $model;

    /**
     * @OneToMany(targetEntity="Reponse", mappedBy="question")
     */
    private $reponses;

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

    public function getModel(){
		return $this->model;
	}

	public function setModel($model){
		$this->model = $model;
	}
    public function getReponses(){
		return $this->reponses;
	}

	public function setReponses($reponses){
		$this->reponses = $reponses;
	}

}
