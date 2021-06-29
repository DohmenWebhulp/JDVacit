<?php 

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\User;

class UserService{

    private $uRep;
    
    public function __construct(EntityManagerInterface $em){
        $this->uRep = $em->getRepository(User::class);
    }

    public function toevoegenUser($user){

        $new_user = $this->uRep->opslaanUser($user);
        
        return($new_user);
    }

    public function ophalenUser($user_id){

        $user = $this->uRep->ophalenUser($user_id);

        return($user);
    }
}