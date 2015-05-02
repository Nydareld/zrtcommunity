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

}
