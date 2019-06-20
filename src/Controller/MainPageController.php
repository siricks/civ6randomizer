<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LeaderRepository;

class MainPageController extends AbstractController
{
    /**
     * @Route("/", name="main_page")
     */
    public function index(LeaderRepository $leaderRepository)
    {
        $leaders = $leaderRepository->findAll();
        shuffle($leaders);
        $random_leader = array_shift($leaders);
        return $this->render('main_page/index.html.twig', [
            'controller_name' => 'MainPageController',
            'random_leader' => $random_leader,
        ]);
    }
}
