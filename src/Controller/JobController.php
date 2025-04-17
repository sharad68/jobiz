<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Job;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\JobApplication;
use App\Form\JobApplicationType;

use App\Repository\JobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class JobController extends AbstractController
{
    #[Route('/job/list', name: 'app_job_list')]
    public function list(JobRepository $jobRepository): Response
    {
        $jobs = $jobRepository->findAll();
        return $this->render('job/list.html.twig', [
            'jobs' => $jobs,
        ]);
}

    #[Route('/job/{id}', name: 'app_job_show')]
public function show(int $id, JobRepository $jobRepository): Response
{
    $job = $jobRepository->find($id);

    if (!$job) {
        throw $this->createNotFoundException('Job not found');
    }

    return $this->render('job/show.html.twig', [
        'job' => $job,
    ]);


}

#[Route('/job/{id}/apply', name: 'job_apply')]
public function apply(
    Request $request,
    Job $job,
    EntityManagerInterface $em
): Response {
    $this->denyAccessUnlessGranted('ROLE_USER');

    $application = new JobApplication();
    $application->setUser($this->getUser());
    $application->setJob($job);

    $form = $this->createForm(JobApplicationType::class, $application);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($application);
        $em->flush();

        $this->addFlash('success', 'Application submitted successfully!');
        return $this->redirectToRoute('app_home');
    }

    return $this->render('job/apply.html.twig', [
        'form' => $form->createView(),
        'job' => $job,
    ]);
}

}