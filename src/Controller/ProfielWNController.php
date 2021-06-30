<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Route("/profielWN/sol/{user_id}", name="mijn_sols")
     */
    public function ophalenSollicitatie($user_id){//Mijn_Sollicitaties

        $solls = $this->ss->ophalenSollicitatiePerGebruiker($user_id);

        return($this->render('profiel_wn/mijn_sollicitaties.html.twig', ['data' => $solls]));
    }
    /**
     * @Route("/profielWN/prof", name="profielWN")
     */
    public function ophalenProfiel(){//Mijn ProfielWN

        $user = $this->getUser();

        return($this->render('profiel_wn/mijn_profielWN.html.twig', ['user' => $user]));
    }
    /**
     * @Route("/profielWN/profAnder/{user_id}", name="profielWNA")
     */
    public function ophalenAnderProfiel($user_id){

        $user = $this->us->ophalenUser($user_id);

        return($this->render('profiel_wn/mijn_profielWN.html.twig', ['user' => $user]));
    }

    public function bijwerkenProfiel(){//Mijn_ProfielWN

        $this->us->toevoegenUser();
        $this->ss->toevoegenSollicitatie();
    }
    /**
     * @Route("/registerlink", name="registerlink")
     */
    public function linkNaarRegistreren(){//Link naar Registratiepagina

        return($this->render('security/registratie.html.twig'));
    }

    /**
     * @Route("/register", name="register")
     */
    public function registreren(){//Registratiepagina

        $user = [
            'email' => $_POST['email'],
            'roles' => ["ROLE_CANDIDATE"],
            'password' => $_POST['password'],
            'record_type' => 'WN',
            'gebruikersnaam' => $_POST['gebruikersnaam'],
            'adres' => $_POST['adres'],
            'geboortedatum' => new \DateTime($_POST['geboortedatum']),
            'telefoonnummer' => $_POST['telefoonnummer'],
            'postcode' => $_POST['postcode'],
            'woonplaats' => $_POST['woonplaats']
        ];

        $userWN = $this->us->toevoegenUser($user);

        return($this->redirectToRoute('homepage'));
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

        $data = $this->ss->toevoegenSollicitatie($soll);

        return new JSONResponse(['success'=>'true']);

    }
    /**
     * @Route("/profielWN/verwsol/{soll_id}", name="verwsol")
     */
    public function verwijderSollicitatie($soll_id){//Mijn_Sollicitaties

        $data = $this->ss->verwijderSollicitatie($soll_id);
        
        return($this->redirectToRoute('mijn_sols'));
    }
}