<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Leader;
use App\Form\GameType;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Game statistic controller
 *
 * @Route("/games")
 */
class GameController extends AbstractController
{
    /**
     * Main page
     * @Route("/", name="game_index", methods={"GET"})
     *
     * @param GameRepository $gameRepository
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function index(GameRepository $gameRepository, TranslatorInterface $translator, Request $request): Response
    {
        $locale = $request->getLocale();

        $request->setLocale('ru');

        return $this->render('game/index.html.twig', [
            'games' => $gameRepository->findBy([], ['id' => 'DESC']),
            'controller_name' => $translator->trans('All games'),
        ]);
    }

    /**
     * Create new game
     * @Route("/new", name="game_new", methods={"GET","POST"})
     *
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($game);
            $entityManager->flush();

            return $this->redirectToRoute('game_index');
        }

        return $this->render('game/new.html.twig', [
            'game' => $game,
            'form' => $form->createView(),
        ]);
    }


    /**
     * Create new game by leaders id
     * @Route("/new/{leader_id}", name="game_new_wf", methods={"GET"})
     *
     * @param $leader_id
     * @return Response
     * @throws \Exception
     */
    public function newWithOutForm(int $leader_id): Response
    {
        $game = new Game();
        $em = $this->getDoctrine()->getManager();
        $leader = $em->getRepository(Leader::class)->find($leader_id);
        if(!$leader) {
            throw $this->createNotFoundException(
                'Leader not find in database!'
            );
        }
        $game->setLeader($leader);
        $game->setGameDate(new \DateTime());

        $em->persist($game);
        $em->flush();

        return $this->redirectToRoute('game_index');
    }

    /**
     * Show single game
     * @Route("/{id}", name="game_show", methods={"GET"})
     *
     * @param Game $game
     * @return Response
     */
    public function show(Game $game): Response
    {
        return $this->render('game/show.html.twig', [
            'game' => $game,
        ]);
    }

    /**
     * Edit single game
     * @Route("/{id}/edit", name="game_edit", methods={"GET","POST"})
     *
     * @param Request $request
     * @param Game $game
     * @return Response
     */
    public function edit(Request $request, Game $game): Response
    {
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('game_index', [
                'id' => $game->getId(),
            ]);
        }

        return $this->render('game/edit.html.twig', [
            'game' => $game,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Delete game
     * @Route("/{id}", name="game_delete", methods={"DELETE"})
     * @param Request $request
     * @param Game $game
     * @return Response
     */
    public function delete(Request $request, Game $game): Response
    {
        if ($this->isCsrfTokenValid('delete'.$game->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($game);
            $entityManager->flush();
        }

        return $this->redirectToRoute('game_index');
    }
}
