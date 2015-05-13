<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="notification")
 **/
class Notification{
    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    private $id;
    /**
     * @Column(type="string")
     */
    private $message;
    /**
     * @Column(type="string", length=255, nullable=true)
     */
    private $path;
    /**
     * @ManyToOne(targetEntity="User", inversedBy="notif")
     */
    private $user;

    public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}
    
    public function getMessage(){
		return $this->message;
	}

	public function setMessage($message){
		$this->message = $message;
	}

	public function getPath(){
		return $this->path;
	}

	public function setPath($path){
		$this->path = $path;
	}

    public function getUser(){
		return $this->user;
	}

	public function setUser($user){
		$this->user = $user;
	}
}
