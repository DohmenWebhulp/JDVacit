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
     * @Route("/profielWN/sol", name="mijn_sol")
     */
    public function ophalenSollicitatie(){//Mijn_Sollicitaties

        $user = $this->getUser();

        //$solls = $this->ss->ophalenSollicitatiePerGebruiker($uid);
        $solls = $user->getSollicitaties();

        return($this->render('profiel_wn/mijn_sollicitaties.html.twig', ['data' => $solls]));
    }
    /**
     * @Route("/profielWN/prof", name="profielWN")
     */
    public function ophalenProfiel(){//Mijn ProfielWN

        $user = $this->getUser();

        return($this->render('profiel_wn/mijn_profielWN.html.twig', ['user' => $user]));
    }

    public function bijwerkenProfiel(){//Mijn_ProfielWN

        $this->us->toevoegenUser();
        $this->ss->toevoegenSollicitatie();
    }

    public function registreren(){//Registratiepagina

        $this->us->toevoegenUser();
    }
    /**
     * @Route("/sollDirect", name="sollDirect")
     */
    public function solliciteerDirect(){//Detailpage

        $user = $this->getUser();
        $uid = $user->getId();

        $cv = isset($_POST['cv']) ? $_POST['cv'] : "Cv Goed test";
        $motivatie = isset($_POST['motivatie']) ? $_POST['motivatie'] : "Motivatie Goed test";
        $vacature = isset($_POST['vacature_id']) ? $_POST['vacature_id'] : 3;

        $soll = array(
            "cv" => $cv,
            "motivatie" => $motivatie,
            "uitnodiging" => false,
            "datum" => new \DateTime(date('Y/m/d h:i:s a', time())),
            "user_wn_id" => $uid,
            "vacature_id" => $vacature
        );

        dd($soll);

        $data = $this->ss->toevoegenSollicitatie($soll);

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