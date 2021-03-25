<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

abstract class AppManager {

    protected $entityManager;

    abstract protected function fetch();
    abstract protected function persist();

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
}