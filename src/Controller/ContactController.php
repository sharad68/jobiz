<?php
namespace App\Controller;

use App\Entity\ContactMessege;
use App\Form\ContactMessegeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function submitForm(Request $request, EntityManagerInterface $em): Response
    {
        $contactMessege = new ContactMessege();
        $form = $this->createForm(ContactMessegeType::class, $contactMessege);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle the form data, e.g., save to the database
            $em->persist($contactMessege);
            $em->flush();

            // Flash message for success
            $this->addFlash('success', 'Your message has been sent successfully!');

            // Reset the form after successful submission
            $form = $this->createForm(ContactMessegeType::class, new ContactMessege());

            // Optionally, redirect to the same page or another
            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
