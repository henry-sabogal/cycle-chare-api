<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\AppManager;
use Symfony\Component\HttpFoundation\Request;

class UserManager extends AppManager{

    private $userRepository;
    private $email;
    private $name;
    private $surname;
    private $id_gmail;
    private $displayName;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $userRepository){
        
        parent::__construct($entityManager);
        $this->userRepository = $userRepository;
    }

    public function fetch(): User{
        $user = $this->findUser();

        if(!$user){
            $user = $this->persist();
        }

        return $user;
    }

    public function persist(): User{
        $user = new User();
        $user->setEmail($this->email);
        $user->setName($this->name);
        $user->setSurname($this->surname);
        $user->setIdGmail($this->id_gmail);
        $user->setDisplayName($this->displayName);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function setData($content): User{
        $this->email = $content->{'email'} != NULL? $content->{'email'}: '';
        $this->name = $content->{'name'} != NULL? $content->{'name'}: '';
        $this->surname = $content->{'surname'} != NULL? $content->{'surname'}: '';
        $this->id_gmail = $content->{'id_gmail'} != NULL? $content->{'id_gmail'}: '';
        $this->displayName = $content->{'displayName'} != NULL? $content->{'displayName'}: '';

        return $this->fetch();
    }

    private function findUser(){
        return $this->userRepository->findByIdGmail($this->id_gmail);
    }

}