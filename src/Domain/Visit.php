<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="visit")
 **/
class Visit{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @Column(type="string")
     * @var string
     */
    private $ip;

    /**
     * @Column(type="string", nullable=true)
     * @var string
     */
    private $navigator;

    /**
     * @Column(type="date")
     * @var date
     */
    private $date;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="visits")
     */
    private $visitor;

    /**
     * @OneToMany(targetEntity="VisitActionPath", mappedBy="visit")
     */
    private $actionPaths;

    public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getIp(){
		return $this->ip;
	}

	public function setIp($ip){
		$this->ip = $ip;
	}

	public function getDate(){
		return $this->date;
	}

	public function setDate($date){
		$this->date = $date;
	}

	public function getVisitor(){
		return $this->visitor;
	}

	public function setVisitor($visitor){
		$this->visitor = $visitor;
	}

	public function getActionPaths(){
		return $this->actionPaths;
	}

	public function setActionPaths($actionPaths){
		$this->actionPaths = $actionPaths;
	}

    public function getNavigator(){
        return $this->navigator;
    }

    public function setNavigator($navigator){
        $this->navigator = $navigator;
    }
}
