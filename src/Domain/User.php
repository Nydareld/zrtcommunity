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

    /**
     * @OneToMany(targetEntity="MembreProjet", mappedBy="user")
     */
    private $membreProjet;

    /**
     * @OneToMany(targetEntity="Projet", mappedBy="createur")
     */
    private $projets;

    /**
     * @OneToMany(targetEntity="MessagePrive", mappedBy="auteur")
     */
    private $messagesenvoi;

    /**
     * @OneToMany(targetEntity="MessagePrive", mappedBy="destinataire")
     */
    private $messagesrecu;

    /**
     * @Assert\File(maxSize="1000000")
     */
    private $avatar;

    /**
     * @Column(type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @Column(type="string",length=1000, nullable=true)
     * @var string
     */
    private $sign;

    /**
     * @Column(type="string",length=10000, nullable=true)
     * @var string
     */
    private $biographie;

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
    public function getRoleHumain(){
        $zbra=array(
            'ROLE_ADMIN'=>'Administrateur',
            'ROLE_MODO'=>'Modérateur',
            'ROLE_TARD'=>'Tard',
            'ROLE_USER'=>'Péon');
        return $zbra[$this->role];
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

    public function getMembreProjet(){
          return $this->membreProjet;
      }

	public function setMembreProjet($membreProjet){
		$this->membreProjet = $membreProjet;
	}

      public function getMessagesenvoi(){
		return $this->messagesenvoi;
	}

	public function setMessagesenvoi($messagesenvoi){
		$this->messagesenvoi = $messagesenvoi;
	}

	public function getMessagesrecu(){
		return $this->messagesrecu;
	}

	public function setMessagesrecu($messagesrecu){
		$this->messagesrecu = $messagesrecu;
	}

    public function getAvatar(){
		return $this->avatar;
	}

	public function setAvatar($avatar){
		$this->avatar = $avatar;
	}

	public function getPath(){
		return $this->path;
	}

	public function setPath($path){
		$this->path = $path;
	}

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.'/../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return '/img/UserAvatar';
    }

    public function upload(){
        if(null === $this->avatar){
            return;
        }
        $extension = $this->avatar->guessExtension();
        $fileName = $this->id.'.'.$extension;
        $this->avatar->move($this->getUploadRootDir(), $fileName);
        $this->path = $fileName;
        $this->avatar = null;
    }

    public function getSign(){
		return $this->sign;
	}

	public function setSign($sign){
		$this->sign = $sign;
	}

    public function getBiographie(){
		return $this->biographie;
	}

	public function setBiographie($biographie){
		$this->biographie = $biographie;
	}

}
