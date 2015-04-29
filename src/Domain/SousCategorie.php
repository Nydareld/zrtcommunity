<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="souscategorie")
 **/
class SousCategorie extends ForumContainer{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    protected $id;

    /**
     * @Column(type="string")
     */
    protected $description;

    /**
     * @ManyToOne(targetEntity="Categorie", inversedBy="childs")
     */
    protected $parentCategorie;

    /**
     * @ManyToOne(targetEntity="SousCategorie", inversedBy="childs",cascade={"persist",})
     */
    protected $parentSousCategorie;

    /**
     * @OneToMany(targetEntity="Topic", mappedBy="sousCategorie",cascade={"persist",})
     */
    protected $topics;

    /**
     * @OneToMany(targetEntity="SousCategorie", mappedBy="parentSousCategorie")
     **/
    protected $childs;

    public function getDescription(){
		return $this->description;
	}

	public function setDescription($description){
		$this->description = $description;
	}

	public function getParentCategorie(){
		return $this->parentCategorie;
	}

	public function setParentCategorie($parentCategorie){
        $this->setParentSousCategorie(null);
		$this->parentCategorie = $parentCategorie;
	}

	public function getParentSousCategorie(){
		return $this->parentSousCategorie;
	}

	public function setParentSousCategorie($parentSousCategorie){
        $this->setParentCategorie(null);
		$this->parentSousCategorie = $parentSousCategorie;
	}

    public function getTopics(){
        return $this->topics;
    }

    public function getId(){
        return $this->id;
    }

    public function getChilds(){
        return $this->childs;
    }

    public function setChilds($childs){
        $this->childs = $childs;
    }

    public function nbMessages(){
        $nb=0;
        foreach($this->topics as $topic){
            $nb += count($topic->getMessages());
        }
        foreach($this->childs as $child){
            $nb += $child->nbMessages();
        }
        return $nb;
    }

    public function nbTopics(){
        $nb=0;
        $nb+=count($this->topics);
        foreach($this->childs as $child){
            $nb += $child->nbTopics();
        }
        return $nb;
    }

    public function lastMessage(){
        global $app;
        $qb= $app['orm.em']->createQueryBuilder();
        $qb->select('m')
            ->from('Zrtcommunity\Domain\MessageForum','m')
            ->join('m.topic','t')
            ->where('t.sousCategorie = '.$this->id)
            ->orderBy('m.date','desc');
        $query = $qb->getQuery();
        $single = $query->getResult();
        return $single[0];
    }

}
