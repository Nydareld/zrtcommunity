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

}
