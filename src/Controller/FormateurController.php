<?php

namespace App\Controller;

use App\Entity\Formateur;
use App\Form\FormateurType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormateurController extends AbstractController
{
    #[Route('/formateur', name: 'app_formateur')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $formateurs = $doctrine->getRepository(Formateur::class)->findBy([], ['nom' => 'ASC']);
        return $this->render('formateur/index.html.twig', [
            'formateurs' => $formateurs,
        ]);
    }

    //<---------- FONCTION AJOUTER ET EDITER UN FORMATEUR ---------->
    #[Route("/formateur/add", name:"add_formateur")]
    #[Route("/formateur/{id}/edit", name:"edit_formateur")]
    public function add(ManagerRegistry $doctrine, Formateur $formateur = null, Request $request): Response 
    {
        if(!$formateur) 
        {
            $formateur = new Formateur();
        }
        $form = $this->createForm(FormateurType::class, $formateur);
        $form->handleRequest($request);
        //<---------- SI LE FORMULAIRE EST SOUMIS ET VALIDE ---------->
        if($form->isSubmitted() && $form->isValid()) 
        {
            //  RECUPERE ET STOCKE LES DONNEES DU FORMULAIRE
            $formateur = $form->getData();
            $entityManager = $doctrine->getManager();
            //<---------- PREPARE ---------->
            $entityManager->persist($formateur);
            //<---------- EXECUTE ---------->
            $entityManager->flush();
            return $this->redirectToRoute('app_formateur');
        }

        //<---------- RENVOI L'AFFICHAGE DU FORMULAIRE ---------->
        return $this->render('formateur/add.html.twig', 
        [
            //<---------- CREATION DE LA VUE DU FORMULAIRE ---------->
            'formAddFormateur' =>$form->createView(),
            //<---------- ID POUR EDITER LE formateur ---------->
            'edit' => $formateur->getId()
        ]);
    }
    
    //<---------- FONCTION SUPPRIMER UN FORMATEUR ---------->
    #[Route("/formateur/{id}/delFormateur", name:"delFormateur_formateur")]
    public function delFormateur(ManagerRegistry $doctrine, Formateur $formateur)
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($formateur);
        $entityManager->flush();

        return $this->redirectToRoute('app_formateur');
    }

    //<---------- FONCTION AFFICHER FORMATEUR ---------->
    #[Route('/formateur/{id}', name: 'show_formateur')]
    public function show(Formateur $formateur): Response
    {       
        return $this->render('formateur/show.html.twig', [
           'formateur' => $formateur,
        ]);
    }
}
