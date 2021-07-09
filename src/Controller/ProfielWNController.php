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
    public function ophalenProfiel(){//Mijn_ProfielWN

        $user = $this->getUser();

        return($this->render('profiel_wn/mijn_profielWN.html.twig', ['user' => $user]));
    }
    /**
     * @Route("/profielWN/profAnder/{user_id}", name="profielWNA")
     */
    public function ophalenAnderProfiel($user_id){//Mijn_ProfielWN

        $user = $this->us->ophalenUser($user_id);

        return($this->render('profiel_wn/mijn_profielWN.html.twig', ['user' => $user]));
    }

    /**
     * @Route("/bijwerkenWN", name="bijwerkenWN")
     */
    public function bijwerkenProfiel(){//Mijn_ProfielWN

        $user = $this->userToDatabase($_POST);
        $currentUser = $this->getUser();
        $id = ["id" => $currentUser->getId()];
        $userWN = array_merge($id, $user);

        $user2 = $this->us->toevoegenUser($userWN);

        $solls = $currentUser->getSollicitaties();
        $soll_id = $this->sollicitatieToDatabase($solls);

        $solli = $this->ss->updateMotivatie($soll_id, $_POST['motivatie']);

        return($this->redirectToRoute('profielWN'));
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

        $user = $this->userToDatabase($_POST);

        $userWN = $this->us->toevoegenUser($user);

        return($this->redirectToRoute('app_login'));
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

    private function userToDatabase($array){

        $user = [
            'email' => $array['email'],
            'roles' => ["ROLE_CANDIDATE"],
            'password' => $array['password'],
            'record_type' => 'WN',
            'gebruikersnaam' => $array['gebruikersnaam'],
            'adres' => $array['adres'],
            'geboortedatum' => new \DateTime($array['geboortedatum']),
            'telefoonnummer' => $array['telefoonnummer'],
            'postcode' => $array['postcode'],
            'woonplaats' => $array['woonplaats']
        ];

        return($user);
    }

    private function sollicitatieToDatabase($solls){

        foreach($solls as $soll){

            $soll_id = $soll->getId();
            break;
        }

        return($soll_id);
    }
}