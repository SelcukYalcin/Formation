<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Form\StagiaireType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StagiaireController extends AbstractController
{
    #[Route('/stagiaire', name: 'app_stagiaire')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $stagiaires = $doctrine->getRepository(Stagiaire::class)->findBy([], ['nom' => 'ASC']);
        return $this->render('stagiaire/index.html.twig', [
            'stagiaires' => $stagiaires,
                ]);
    }

    //<---------- FONCTION AJOUTER ET EDITER UN STAGIAIRE ---------->
     /**
     * @Route("/stagiaire/add", name="add_stagiaire")
     * @Route("/stagiaire/{id}/edit", name="edit_stagiaire")
     */
    public function add(ManagerRegistry $doctrine, Stagiaire $stagiaire = null, Request $request): Response 
    {
        if(!$stagiaire) 
        {
            $stagiaire = new Stagiaire();
        }
        $form = $this->createForm(StagiaireType::class, $stagiaire);
        $form->handleRequest($request);
        //<---------- SI LE FORMULAIRE EST SOUMIS ET VALIDE ---------->
        if($form->isSubmitted() && $form->isValid()) 
        {
            //  RECUPERE ET STOCKE LES DONNEES DU FORMULAIRE
            $stagiaire = $form->getData();
            $entityManager = $doctrine->getManager();
            //<---------- PREPARE ---------->
            $entityManager->persist($stagiaire);
            //<---------- EXECUTE ---------->
            $entityManager->flush();
            return $this->redirectToRoute('app_stagiaire');
        }

        //<---------- RENVOI L'AFFICHAGE DU FORMULAIRE ---------->
        return $this->render('stagiaire/add.html.twig', 
        [
            //<---------- CREATION DE LA VUE DU FORMULAIRE ---------->
            'formAddStagiaire' =>$form->createView(),
            //<---------- ID POUR EDITER LE STAGIAIRE ---------->
            'edit' => $stagiaire->getId()
        ]);
    }

    #[Route("/stagiaire/{id}/delStagiaire", name:"delStagiaire_stagiaire")]

    //<---------- FONCTION SUPPRIMER UN STAGIAIRE ---------->
    public function delStagiaire(ManagerRegistry $doctrine, Stagiaire $stagiaire)
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($stagiaire);
        $entityManager->flush();

        return $this->redirectToRoute('app_stagiaire');
    }
    //<---------- FONCTION AFFICHER STAGIAIRE ---------->
    #[Route('/stagiaire/{id}', name: 'show_stagiaire')]
    public function show(Stagiaire $stagiaire): Response
    {       
        return $this->render('stagiaire/show.html.twig', [
           'stagiaire' => $stagiaire,
        ]);
    }
}
