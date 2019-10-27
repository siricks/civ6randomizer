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
        if($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('leader_index');
        }

        $leaders = $leaderRepository->findAll();
        shuffle($leaders);
        $two = array_slice($leaders, 0, 2);
        return $this->render('main_page/index.html.twig', [
            'leaders' => $two,
        ]);
    }
}
