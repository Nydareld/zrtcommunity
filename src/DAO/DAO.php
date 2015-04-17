<?php

namespace Pecheocoup\DAO;

use Doctrine\ORM\EntityManager;

abstract class DAO
{
    /**
     * Database connection
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * Constructor
     *
     * @param \Doctrine\ORM\EntityManager The entity manager
     */
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    /**
     * Grants access to the database connection object
     *
     * @return \Doctrine\ORM\EntityManager The entity manager
     */
    protected function getEm() {
        return $this->em;
    }


}
