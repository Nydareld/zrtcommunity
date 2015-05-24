<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\News;

class NewsDAO extends DAO{
    public function save(News $news){
        $this->getEm()->persist($news);
        $this->getEm()->flush();
    }

    public function loadAllNews(){
        $news= $this->getEm()->getRepository('Zrtcommunity\Domain\News')->findAll();
        if ($news === null){
            throw new \Exception("No news");
        }else{
            return $news;
        }
    }

    public function loadAllNewsBySection($section){
        $news= $this->getEm()->getRepository('Zrtcommunity\Domain\News')->findBy(array('sectionSite' => $section));

        if ($news === null){
            throw new \Exception("No News matching name " . $name);
        }else{
            return $section;
        }
    }

    public function loadNewsById($id){
        $news= $this->getEm()->getRepository('Zrtcommunity\Domain\News')->findOneBy(array('id' => $id));

        if ($news === null){
            throw new \Exception("No news matching id " . $id);
        }else{
            return $news;
        }
    }

}
