<?php

namespace Zrtcommunity\Domain;

/**
 * @MappedSuperclass
 **/
abstract class ForumContainer{
    /** @Column(type="string") */
    protected $name;
    /** @Column(type="integer", nullable=true) */
    protected $ordre;

    public function getName(){
		return $this->name;
	}

	public function setName($name){
		$this->name = $name;
	}

	public function getOrdre(){
		return $this->order;
	}

	public function setOrdre($order){
		$this->order = $order;
	}
}
