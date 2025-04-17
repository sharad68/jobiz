<?php

namespace App\Form;

use App\Entity\ContactMessege;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ContactMessegeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // 'email' field, use EmailType to ensure validation for email format
            ->add('email', EmailType::class, [
                'label' => 'Your Email Address',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Enter your email'],
            ])
            
            // 'subject' field, use TextType
            ->add('subject', TextType::class, [
                'label' => 'Subject',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Subject of your message'],
            ])
            
            // 'messege' field, use TextareaType for a multiline text area
            ->add('messege', TextareaType::class, [
                'label' => 'Message',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Write your message here'],
            ])
            
            // 'createdat' field, use DateType if you want to handle a date (can be hidden or auto-generated in your form)
            ->add('createdat', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date of Submission',
                'attr' => ['class' => 'form-control'],
                'required' => false,  // optional, adjust if needed
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactMessege::class,
        ]);
    }
}
