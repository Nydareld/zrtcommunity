<?php

namespace Pecheocoup\DAO;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Pecheocoup\Domain\User;

class UserDAO extends DAO implements UserProviderInterface{

    public function find($id){

        $user = $this->getEm()->find("Pecheocoup\Domain\User", (int)$id);

        if ($user === null){
            throw new \Exception("No user matching id " . $id);
        }else{
            return $user;
        }
    }

    public function loadUserByUsername($username){
        $user = $this->getEm()->getRepository('Pecheocoup\Domain\User')->findOneBy(array('username' => $username));

        if ($user === null){
            throw new \Exception("No user matching id " . $id);
        }else{
            return $user;
        }
    }

    public function supportsClass($class){
        return 'Pecheocoup\Domain\User' === $class;
    }

    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }
        return $this->loadUserByUsername($user->getUsername());
    }

}
