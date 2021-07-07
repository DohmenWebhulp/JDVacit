<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use App\Service\VacatureService;
use App\Service\UserService;

class HomepageController extends AbstractController
{

    private $vs;
    private $us;

    public function __construct(VacatureService $vs, UserService $us){
        $this->vs = $vs;
        $this->us = $us;
    }
    
    public function index(): Response
    {
    
    }
    /**
     * @Route("/", name="homepage")
     */
    public function ophalenVacatures(){//Homepage

        $user = $this->ophalenUser();
        $data = $this->vs->selecteerNieuwsteVijfVacatures();

        return($this->render('homepage/index.html.twig', ['data' => $data, 'user' => $user]));
    }

    /**
     * @Route("/detailpage/{id}", name="detailpage")
     */
    public function ophalenVacatureOpID($id){//Detailpage

        $user = $this->ophalenUser();
        $vac_id = $id;
        $data = $this->vs->ophalenVacature($vac_id);
        dd($data);
        $data2 = $data->getUserWG()->getVacatures();

        return($this->render('homepage/detailpage.html.twig', ['data' => $data, 'user' => $user, 'data2' => $data2]));
    }

    public function ophalenUser(){

        $user = $this->getUser();

        return($user);
    }
}
