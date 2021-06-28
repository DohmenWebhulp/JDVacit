<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Service\SollicitatieService;
use App\Service\VacatureService;
use App\Service\UserService;


class ProfielWGController extends AbstractController
{

    private $ss;
    private $vs;
    private $us;

    public function __construct(SollicitatieService $ss, VacatureService $vs, UserService $us){

        $this->ss = $ss;
        $this->vs = $vs;
        $this->us = $us;
    }

    public function index(): Response
    {
        
    }

    public function ophalenProfiel(){//Mijn ProfielWG

        $data = $this->us->ophalenUser($user_id);
        dd($data);
    }

    public function bijwerkenProfiel(){//Mijn_ProfielWG

        $this->us->toevoegenUser();
    }

    public function importeerSpreadsheet(){

        //Commando
        $this->us->toevoegenUser();
    }

    //Homepage met ingelogde werkgever die vacatures kan toevoegen een andere webpagina dan de standaard homepage?

    /**
     * @Route("/profielWG", name="profielWG")
     */
    public function uploadVacature(){//Homepage

        $vaca = array(
            "titel" => "Frontend developer",
            "omschrijving" => "polkiu",
            "niveau" => "junior",
            "datum" => new \DateTime("2021-06-23 13:35:00"),
            "user_wg_id" => "1"
        );

        $data = $this->vs->toevoegenVacature($vaca);
        dd($data);
    }

    /**
     * @Route("/vacsol", name="vacsol")
     */
    public function uitnodigingVersturen(){//Mijn_Vacatures_Sollicitaties

        $soll_id = 1;
        $data = $this->ss->updateSollicitatie($soll_id);
        dd($data);
    }

    public function ophalenVacatures(){//Mijn_Vacatures

        $vac_id = 12;
        $data = $this->vs->ophalenVacature($vac_id);
        $data2 = $data->getUserWG()->getVacatures();
    }

    //Ophalen vacatures door werkgever gevolgd door ophalen sollicitaties horende bij die vacature?->FK relatie

}
