<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\ModuleType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModuleController extends AbstractController
{
    #[Route('/module', name: 'app_module')]
    public function index(ManagerRegistry $doctrine): Response
    {
        
        $modules = $doctrine->getRepository(Module::class)->findBy([], ['titreMod' => 'ASC']);
        return $this->render('module/index.html.twig', [
            'modules' => $modules,        ]);
    }


        /**
     * @Route("/module/add", name="add_module")
     * @Route("/module/{id}/edit", name="edit_module")
     */
    public function add(ManagerRegistry $doctrine, Module $module = null, Request $request): Response
    {
        if(!$module) {
            $module = new Module();
        }

        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $module = $form->getData(); 
            $entityManager = $doctrine->getManager();
            //<---------- PREPARE ---------->
            $entityManager->persist($module);      
            //<---------- EXECUTE ---------->
            $entityManager->flush();

            $modCat= $module->getCategorie()->getId();
            return $this->redirectToRoute('show_categorie', ['id' => $modCat]);
        }
        //<---------- RENVOI L'AFFICHAGE DU FORMULAIRE ---------->
        return $this->render('module/add.html.twig',
        [
            //<---------- CREATION DE LA VUE DU FORMULAIRE ---------->
            'formAddModule' =>$form->createView(),
            //<---------- ID POUR EDITER LA MODULE ---------->
            'edit' => $module->getId()
        ]);
    }
}
