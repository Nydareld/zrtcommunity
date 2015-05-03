<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="visitactionpath")
 **/
class VisitActionPath{

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
     * @ManyToOne(targetEntity="visit", inversedBy="actionPaths")
     */
    private $visit;

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

	public function getVisit(){
		return $this->visit;
	}

	public function setVisit($visit){
		$this->visit = $visit;
	}
}
