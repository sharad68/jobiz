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
public function show(Request $request, int $id, JobRepository $jobRepository, EntityManagerInterface $em): Response
{
    $job = $jobRepository->find($id);

    if (!$job) {
        throw $this->createNotFoundException('Job not found');
    }

    $form = null;
    if ($this->getUser()) {
        $application = new JobApplication();
        $application->setUser($this->getUser());
        $application->setJob($job);

        $form = $this->createForm(JobApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $application->setCreatedat(new \DateTimeImmutable());
            $em->persist($application);
            $em->flush();

            $this->addFlash('success', 'Application submitted successfully!');
            return $this->redirectToRoute('app_job_show', ['id' => $job->getId()]);
        }
    }

    return $this->render('job/show.html.twig', [
        'job' => $job,
        'form' => $form ? $form->createView() : null,
    ]);
}
}