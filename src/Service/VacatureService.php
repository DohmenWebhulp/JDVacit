<?php 

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Vacature;

class VacatureService{

    private $vacRep;
    
    public function __construct(EntityManagerInterface $em){
        $this->vacRep = $em->getRepository(Vacature::class);
    }

    public function ophalenVacature($vac_id = NULL){

        if(!is_null($vac_id)){
            $vacs = $this->vacRep->ophalenVacature($vac_id);
        }else{
            $vacs = $this->vacRep->ophalenVacatures();
        }

        return($vacs);
    }

    public function selecteerNieuwsteVijfVacatures(){
        
        $vacss = [];
        $vacs = $this->vacRep->sorteerVacatures();
        for($i = 0; $i < 5; $i++){
            $vacss[] = $vacs[$i];
        }
        
        return($vacss);
    }

    public function toevoegenVacature($vaca){

        //check of de vacature al bestaat voor bedrijf EN titel

        $vacs = $this->ophalenVacature();
        foreach($vacs as $vac){
            if($vac->getTitel() == $vaca["titel"]){
                return(false);
            }
        }

        //saveFunctie in repository

        $new_vac = $this->vacRep->opslaanVacature($vaca);

        return($new_vac);
    }
}