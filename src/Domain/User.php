<?php

namespace Zrtcommunity\Domain;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Entity @Table(name="users")
 * @UniqueEntity("name")
 * @UniqueEntity("email")
 **/
class User implements UserInterface
{
    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @Column(type="string")
     * @var string
     */
    private $username;

    /**
     * @Column(type="string")
     * @var string
     */
    private $password;

    /**
     * @Column(type="string")
     * @var string
     */
    private $salt;

    /**
     * @Column(type="string")
     * @var string
     */
    private $role;

    /**
     * @Column(type="string")
     * @var string
     */
    private $email;

    /**
     * @OneToMany(targetEntity="Topic", mappedBy="creator")
     */
    private $topics;

    /**
     * @OneToMany(targetEntity="MessageForum", mappedBy="auteur")
     */
    private $messagesforum;

    /**
     * @OneToMany(targetEntity="News", mappedBy="creator")
     */
    private $news;

    /**
     * @OneToMany(targetEntity="MessageNews", mappedBy="auteur")
     */
    private $messagesnews;

    /**
     * @OneToMany(targetEntity="Visit", mappedBy="visitor")
     */
    private $visits;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @inheritDoc
     */
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * @inheritDoc
     */
    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array($this->getRole());
    }

    public function getVisits() {
        return $this->visits;
    }

    public function setVisits($visits) {
        $this->visits = $visits;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials() {
        // Nothing to do here
    }

    public function getMessagesForum()
    {
        return $this->messagesforum;
    }
}
