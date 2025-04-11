<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Category;
use App\Entity\Job;
use App\Entity\JobType;
use App\Entity\User;
use App\Entity\JobApplication;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // --- Create Categories ---
        $devCategory = new Category();
        $devCategory->setName('Web Development');
        $manager->persist($devCategory);

        $dataCategory = new Category();
        $dataCategory->setName('Data Science');
        $manager->persist($dataCategory);

        // --- Create Job Types ---
        $fullTime = new JobType();
        $fullTime->setName('Full-time');
        $manager->persist($fullTime);

        $internship = new JobType();
        $internship->setName('Internship');
        $manager->persist($internship);

        // --- Create Company ---
        $company = new Company();
        $company->setName('Techify Inc.')
                ->setDescription('A leading software development firm.')
                ->setAddress('123 Developer St')
                ->setCity('Montpellier')
                ->setCountry('France');
        $manager->persist($company);

        // --- Create a User ---
        $user = new User();
        $user->setUsername('alice_doe');
        $user->setEmail('user@example.com');
        $user->setFirstName('Alice');
        $user->setLastName('Doe');
        $user->setPassword($this->hasher->hashPassword($user, 'password'));
        $manager->persist($user);

        // --- Create a Job ---
        $job = new Job();
        $job->setTitle('Symfony Developer')
            ->setDescription('Build modern PHP applications using Symfony.')
            ->setCity('Paris')
            ->setCountry('France')
            ->setRemoteallowed(true)
            ->setSalaryrange(45000)
            ->setCreatedat(new \DateTimeImmutable())
            ->setCompany($company)
            ->setCategory($devCategory)
            ->addJobType($fullTime)
            ->addJobType($internship);
        $manager->persist($job);

        // --- Create a Job Application ---
        $application = new JobApplication();
        $application->setCoverLetter('I am passionate about Symfony and have 3 years of experience.')
                    ->setCreatedAt(new \DateTimeImmutable())
                    ->setUser($user)
                    ->setJob($job);
        $manager->persist($application);

        // --- Finalize ---
        $manager->flush();
    }
}
