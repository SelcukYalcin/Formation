<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $sessions = $doctrine->getRepository(Session::class)->findBy([], ['intitule' => 'ASC']);
        return $this->render('session/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }


    /**
     * @Route("/session/add", name="add_session")
     * @Route("/session/{id}/edit", name="edit_session")
     */
    public function add(ManagerRegistry $doctrine, Session $session = null, Request $request): Response
    {
        if (!$session) {
            $session = new Session();
        }

        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $session = $form->getData();
            $entityManager = $doctrine->getManager();
            //<---------- PREPARE ---------->
            $entityManager->persist($session);
            //<---------- EXECUTE ---------->
            $entityManager->flush();
            return $this->redirectToRoute('app_session');
        }
        //<---------- RENVOI L'AFFICHAGE DU FORMULAIRE ---------->
        return $this->render(
            'session/add.html.twig',
            [
                //<---------- CREATION DE LA VUE DU FORMULAIRE ---------->
                'formAddSession' => $form->createView(),
                //<---------- ID POUR EDITER LA SESSION ---------->
                'edit' => $session->getId()
            ]
        );
    }

    //<---------- FONCTION AFFICHER SESSION ---------->
    #[Route("/session/{id}", name: "show_session")]

    public function show(Session $session, SessionRepository $sr): Response
    {
        $nonInscrits = $sr->findNonInscrits($session->getId());
        // $nonProgrammers = $sr->findNonProgrammers($session->getId());
        return $this->render('session/show.html.twig', [
            'session' => $session,
            'nonInscrits' => $nonInscrits,
            //    'nonProgrammers' => $nonProgrammers
        ]);
    }
}
