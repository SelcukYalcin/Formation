<?php

namespace App\Controller;

use App\Entity\Module;
use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Form\SessionType;
use App\Entity\Programmer;
use App\Repository\SessionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $sessions = $doctrine->getRepository(Session::class)->findBy([], ['intitule' => 'ASC']);
        return $this->render(
            'session/index.html.twig',
            ['sessions' => $sessions,]
        );
    }

    //<---------- FONCTION AJOUTER ET EDITER UNE SESSION ---------->
    #[Route("/session/add", name: "add_session")]
    #[Route("/session/{id}/edit", name: "edit_session")]
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

    //<---------- FONCTION SUPPRIMER UNE SESSION ---------->
    #[Route("/session/{id}/delSession", name: "delSession_session")]
    public function delSession(ManagerRegistry $doctrine, Session $session)
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($session);
        $entityManager->flush();
        return $this->redirectToRoute('app_session');
    }



    /**
     * @Route("/session/addStagiaire/{idSe}/{idSt}", name="add_stagiaire_session", requirements={"idSe"="\d+", "idSt"="\d+"})
     * @ParamConverter("session", options={"mapping": {"idSe": "id"}})
     * @ParamConverter("stagiaire", options={"mapping": {"idSt": "id"}})
     */
    public function addStagiaire(ManagerRegistry $doctrine, Session $session, Stagiaire $stagiaire)
    {

        $entitytManager = $doctrine->getManager();
        $session->addInscrit($stagiaire);
        $entitytManager->persist($session);
        $entitytManager->flush();

        return $this->redirectToRoute('show_session', ['id' => $session->getId()]);
    }

    /**
     * @Route("/session/removeStagiaire/{idSe}/{idSt}", name="remove_stagiaire_session", requirements={"idSe"="\d+", "idSt"="\d+"})
     * @ParamConverter("session", options={"mapping": {"idSe": "id"}})
     * @ParamConverter("stagiaire", options={"mapping": {"idSt": "id"}})
     */
    public function removeStagiaire(ManagerRegistry $doctrine, Session $session, Stagiaire $stagiaire)
    {
        // $session = $doctrine->getRepository(Session::class)->find($request->attributes->get('idSe'));
        $entitytManager = $doctrine->getManager();
        $session->removeInscrit($stagiaire);
        $entitytManager->persist($session);
        $entitytManager->flush();

        return $this->redirectToRoute('show_session', ['id' => $session->getId()]);
    }

    /**
     * @Route("/session/addProgrammer/{idSe}/{idMod}", name="add_programmer_session", requirements={"idSe"="\d+", "idMod"="\d+"})
     * @ParamConverter("session", options={"mapping": {"idSe": "id"}})
     * @ParamConverter("module", options={"mapping": {"idMod": "id"}})
     */
    public function addProgrammer(ManagerRegistry $doctrine, Request $request, Session $session, Module $module)
    {
        $entityManager = $doctrine->getManager();
        $prog = new Programmer();
        $duree = $request->request->get('duree');
        $prog->setProgses($session);
        $prog->setProgMod($module);
        
        $prog->setDuree($duree);
        $entityManager->persist($prog);
        $entityManager->flush();

        return $this->redirectToRoute('show_session', ['id' => $session->getId()]);
    }

    /**
     * @Route("/session/removeProgrammer/{idSe}/{idPr}", name="remove_programmer_session", requirements={"idSe"="\d+", "idPr"="\d+"})
     * @ParamConverter("session", options={"mapping": {"idSe": "id"}})
     * @ParamConverter("programmer", options={"mapping": {"idPr": "id"}})
     */
    public function removeProgrammer(ManagerRegistry $doctrine, Session $session, Programmer $programmer)
    {
        $session->removeProgrammer($programmer);
        $entityManager = $doctrine->getManager();
        $entityManager->persist($session);
        $entityManager->flush();

        return $this->redirectToRoute('show_session', ['id' => $session->getId()]);
    }

    //<---------- FONCTION AFFICHER SESSION ---------->
    #[Route("/session/{id}", name: "show_session")]
    public function show(Session $session, SessionRepository $sr): Response
    {
        $session_id = $session->getId();
        $nonInscrits = $sr->findNonInscrits($session_id);
        $nonProgramme = $sr->findNonProgrammers($session_id);
        return $this->render(
            'session/show.html.twig',
            [
                'session' => $session,
                'nonInscrits' => $nonInscrits,
                'nonProgrammers' => $nonProgramme
            ]
        );
    }
}
