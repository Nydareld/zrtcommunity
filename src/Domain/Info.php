<?php

namespace Zrtcommunity\Domain;

class Info{
    private $nbuser;
    private $nbtopic;
    private $nbmess;

    function __construct(){
        global $app;

        $this->nbuser = count($app['orm.em']->getRepository("Zrtcommunity\Domain\User")->findall());
        $this->nbmess =0;
        $this->nbtopic =0;
    }
    public function getNbuser(){return $this->nbuser;}
    public function getNbtopic(){return $this->nbtopic;}
    public function getNbmess(){return $this->nbmess;}

}
