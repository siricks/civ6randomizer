<?php

namespace App\Controller;

use App\Entity\Leader;
use App\Form\LeaderType;
use App\Repository\LeaderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/leader")
 */
class LeaderController extends AbstractController
{
    /**
     * @Route("/", name="leader_index", methods={"GET"})
     */
    public function index(LeaderRepository $leaderRepository): Response
    {
        return $this->render('leader/index.html.twig', [
            'leaders' => $leaderRepository->findBy([], ['country' => 'ASC']),
            'controller_name' => 'Все лидеры'
        ]);
    }

    /**
     * @Route("/get_random", name="leader_random", methods={"GET"})
     */
    public function random(LeaderRepository $leaderRepository): Response
    {
        $leaders = $leaderRepository->getFreeLeaders();
        shuffle($leaders);
        $random_leader = [current($leaders), next($leaders), next($leaders)];
        return $this->render('leader/random.html.twig', [
            'leaders' => $random_leader,
            'controller_name' => 'Случайный лидер'
        ]);
    }

    /**
     * @Route("/new", name="leader_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $leader = new Leader();
        $form = $this->createForm(LeaderType::class, $leader);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($leader);
            $entityManager->flush();

            return $this->redirectToRoute('leader_index');
        }

        return $this->render('leader/new.html.twig', [
            'leader' => $leader,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="leader_show", methods={"GET"})
     */
    public function show(Leader $leader): Response
    {
        return $this->render('leader/show.html.twig', [
            'leader' => $leader,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="leader_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Leader $leader): Response
    {
        $form = $this->createForm(LeaderType::class, $leader);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('leader_index', [
                'id' => $leader->getId(),
            ]);
        }

        return $this->render('leader/edit.html.twig', [
            'leader' => $leader,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="leader_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Leader $leader): Response
    {
        if ($this->isCsrfTokenValid('delete'.$leader->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($leader);
            $entityManager->flush();
        }

        return $this->redirectToRoute('leader_index');
    }


}
