<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\News;

class NewsDAO extends DAO{
    public function save(News $news){
        $this->getEm()->persist($news);
        $this->getEm()->flush();
    }

}
