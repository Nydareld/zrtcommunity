<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="sectionsite")
 **/
class SectionSite{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     *@Column(type="string")
     */
    protected $name;

    /**
     *@Column(type="string")
     */
    protected $pathIcone;

    /**
     * @OneToMany(targetEntity="Categorie", mappedBy="sectionSite", orphanRemoval=true)
     */
    private $categories;

    /**
     * @OneToMany(targetEntity="News", mappedBy="sectionSite", orphanRemoval=true)
     */
    private $news;

    public function getNews(){
		return $this->news;
	}

	public function setNews($news){
		$this->news = $news;
	}
    
    public function getId(){
  		return $this->id;
  	}

  	public function setId($id){
  		$this->id = $id;
  	}

  	public function getName(){
  		return $this->name;
  	}

  	public function setName($name){
  		$this->name = $name;
  	}

  	public function getPathIcone(){
  		return $this->pathIcone;
  	}

  	public function setPathIcone($pathIcone){
  		$this->pathIcone = $pathIcone;
  	}

  	public function getCategories(){
  		return $this->categories;
  	}

  	public function setCategories($categories){
  		$this->categories = $categories;
  	}

}
