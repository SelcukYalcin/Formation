<?php

namespace App\Controller;

use App\Repository\SessionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(SessionRepository $sr): Response
    {
        $pastSessions = $sr->displayPastSessions();
        $currentSessions = $sr->displayCurrentSessions();
        $upcomingSessions = $sr->displayUpcomingSessions();

        return $this->render('home/index.html.twig', 
        [
            'pastSessions' => $pastSessions,
            'currentSessions' => $currentSessions,
            'upcomingSessions' => $upcomingSessions
        ]);
    }
}
