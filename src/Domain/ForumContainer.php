<?php

namespace Zrtcommunity\Domain;

/**
 * @MappedSuperclass
 **/
abstract class ForumContainer{
    /** @Column(type="string") */
    protected $name;
    /** @Column(type="integer") */
    protected $order;

    public function getName(){
		return $this->name;
	}

	public function setName($name){
		$this->name = $name;
	}

	public function getOrder(){
		return $this->order;
	}

	public function setOrder($order){
		$this->order = $order;
	}
}
