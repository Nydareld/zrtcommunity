<?php

namespace Zrtcommunity\Domain;

/**
 * @Entity @Table(name="questionaire")
 **/
class Questionaire{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @Column(type="datetime")
     * @var datetime
     */
    private $date;

    /**
     * @Column(type="boolean")
     * @var boolean
     */
    private $accepted;

    /**
     * @OneToMany(targetEntity="Reponse", mappedBy="questionaire",cascade={"persist"})
     */
    protected $reponses;

    /**
     * @OneToOne(targetEntity="User", mappedBy="questionaireZrtCraft")
     */
    protected $user;



}
