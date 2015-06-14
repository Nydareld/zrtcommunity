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
     * @ManyToOne(targetEntity="SousCategorie", inversedBy="childs")
     */
    protected $parentSousCategorie;

    /**
     * @OneToMany(targetEntity="Topic", mappedBy="sousCategorie", orphanRemoval=true)
     */
    protected $topics;

    /**
     * @OneToMany(targetEntity="SousCategorie", mappedBy="parentSousCategorie", orphanRemoval=true)
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
        $this->parentSousCategorie=null;
		$this->parentCategorie = $parentCategorie;
	}

	public function getParentSousCategorie(){
		return $this->parentSousCategorie;
	}

	public function setParentSousCategorie($parentSousCategorie){
        $this->parentCategorie=null;
		$this->parentSousCategorie = $parentSousCategorie;
	}

    public function getTopics(){
        return $this->topics;
    }
    public function setTopics($topics){
        $this->topics = $topics;
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
        if(isset($single[0])){
            return $single[0];
        }
        else{
            return null;
        }
    }

    public function path(){
        if($this->parentCategorie!=null){
            return $this->parentCategorie->path().'->'.$this->name;
        }else{
            return $this->parentSousCategorie->path().'->'.$this->name;
        }
    }
    public function getSectionSite(){
        if($this->parentCategorie!=null){
            return $this->parentCategorie->getSectionSite();
        }else{
            return $this->parentSousCategorie->getSectionSite();
        }
    }

}
