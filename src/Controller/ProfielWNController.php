<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Service\SollicitatieService;
use App\Service\UserService;

class ProfielWNController extends AbstractController
{

    private $ss;
    private $us;

    public function __construct(SollicitatieService $ss, UserService $us){

        $this->ss = $ss;
        $this->us = $us;
    }

    public function index(): Response
    {
        
    }
    /**
     * @Route("/profielWN/sol", name="sol")
     */
    public function ophalenSollicitatie(){//Mijn_Sollicitaties

        $user_wn_id = 1;
        $sols = $this->ss->ophalenSollicitatiePerGebruiker($user_wn_id);
        dd($sols);
    }
    /**
     * @Route("/profielWN/prof", name="profiel")
     */
    public function ophalenProfiel(){//Mijn ProfielWN

        $user_id = 1;
        $data = $this->us->ophalenUser($user_id);
        dd($data);
    }

    public function bijwerkenProfiel(){//Mijn_ProfielWN

        $this->us->toevoegenUser();
        $this->ss->toevoegenSollicitatie();
    }

    public function registreren(){//Registratiepagina

        $this->us->toevoegenUser();
    }
    /**
     * @Route("/detailpage/sollDirect", name="sollDirect")
     */
    public function solliciteerDirect(){//Detailpage

        $soll = array(
            "cv" => "Cv 3",
            "motivatie" => "Motivatie 3",
            "uitnodiging" => false,
            "datum" => new \DateTime("2021-06-24 09:30:00"),
            "user_wn_id" => "1",
            "vacature_id" => "3"
        );

        $data = $this->ss->toevoegenSollicitatie($soll);
        dd($data);
    }
    /**
     * @Route("/detailpage/verwsol", name="verwsol")
     */
    public function verwijderSollicitatie(){//Detailpage

        $soll_id = 4;
        $data = $this->ss->verwijderSollicitatie($soll_id);
        dd($data);
    }
}

//Routing lukt niet.
//