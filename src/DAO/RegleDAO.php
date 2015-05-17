
<?php

namespace Zrtcommunity\DAO;

use Zrtcommunity\Domain\Categorie;

class CategorieDAO extends DAO{

    public function save(Categorie $cat){
        $this->getEm()->persist($cat);
        $this->getEm()->flush();
    }
    public function remove(Categorie $cat){
        $this->getEm()->remove($cat);
        $this->getEm()->flush();
    }
}
