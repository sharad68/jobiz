<?php

namespace App\Controller;

use App\Repository\JobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PageController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(JobRepository $jobRepository): Response
    {
        $jobs = $jobRepository->findBy([], ['createdat' => 'DESC'], 3);
    
        return $this->render('page/index.html.twig', [
            'jobs' => $jobs,
            'controller_name' => 'HomeController', 
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('page/about.html.twig', [
          
        ]);
    }

   

   

}
