<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="topics")
 **/
class Topic{
    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    private $id;
    /**
     * @Column(type="string")
     * @var string
     */
    private $name;
    /**
     * @Column(type="string",nullable=true)
     * @var string
     */
    private $description;
    /**
     * @ManyToOne(targetEntity="User", inversedBy="topics")
     */
    private $creator;

    /**
     * @ManyToOne(targetEntity="SousCategorie", inversedBy="topics")
     */
    private $sousCategorie;

    /**
     * @OneToMany(targetEntity="MessageForum", mappedBy="topic", orphanRemoval=true)
     */
    protected $messages;

    /**
     * @Column(type="boolean")
     * @var boolean
     */
    private $close;

    public function getId(){
		return $this->id;
	}
	public function getName(){
		return $this->name;
	}
	public function setName($name){
		$this->name = $name;
	}
	public function getDescription(){
		return $this->description;
	}
	public function setDescription($description){
		$this->description = $description;
	}
	public function getCreator(){
		return $this->creator;
	}
    public function setCreator($creator){
		$this->creator = $creator;
	}
	public function getSousCategorie(){
		return $this->sousCategorie;
	}
	public function setSousCategorie($sousCategorie){
		$this->sousCategorie = $sousCategorie;
	}
    public function getMessages(){
        return $this->messages;
    }
    public function setMessages($messages){
		$this->messages = $messages;
	}
    public function nbMessages(){
        return count($this->getMessages());
    }
    public function setClose($close){
        $this->close = $close;
    }
    public function isClose(){
        return $this->close;
    }
    public function lastMessage(){
        global $app;
        $qb= $app['orm.em']->createQueryBuilder();
        $qb->select('m')
            ->from('Zrtcommunity\Domain\MessageForum','m')
            ->join('m.topic','t')
            ->where('t.id = '.$this->id)
            ->orderBy('m.date','desc');
        $query = $qb->getQuery();
        $single = $query->getResult();
        return $single[0];
    }
}
