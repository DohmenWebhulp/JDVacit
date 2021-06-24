<?php 

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\User;

class UserService{

    private $uRep;
    
    public function __construct(EntityManagerInterface $em){
        $this->uRep = $em->getRepository(User::class);
    }

    public function toevoegenUser(){
        
    }
}