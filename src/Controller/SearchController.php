<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\JobRepository;

class SearchController extends AbstractController
{
    public function index(Request $request, JobRepository $jobRepository): Response
{
    $query = $request->query->get('query', '');
    $results = [];

    if ($query) {
        $results = $jobRepository->createQueryBuilder('j')
            ->leftJoin('j.company', 'c') // Join with the Company entity
            ->where('j.title LIKE :q OR c.name LIKE :q OR j.location LIKE :q') // Assuming 'name' is the field in Company
            ->setParameter('q', '%' . $query . '%')
            ->getQuery()
            ->getResult();
    }

    return $this->render('search/results.html.twig', [
        'query' => $query,
        'results' => $results,
    ]);
}
}