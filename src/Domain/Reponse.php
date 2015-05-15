<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="reponse")
 **/
class Reponse{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @Column(type="string",length=1000)
     * @var string
     */
    private $reponse;

    /**
     * @ManyToOne(targetEntity="Questionaire", inversedBy="reponses")
     */
    private $questionaire;

}
