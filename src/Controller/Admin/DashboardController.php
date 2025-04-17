<?php

namespace App\Controller\Admin;

use App\Entity\Job;
use App\Entity\Company;
use App\Entity\Category;
use App\Entity\JobType;
use App\Entity\JobApplication;
use App\Entity\User;
use App\Entity\ContactMessege; 


use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // 1.1) If you have enabled the "pretty URLs" feature:
        // return $this->redirectToRoute('admin_user_index');
        //
        // 1.2) Same example but using the "ugly URLs" that were used in previous EasyAdmin versions:
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Jobiz');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::section('Job Management');
        yield MenuItem::linkToCrud('Jobs', 'fas fa-briefcase', Job::class);
        yield MenuItem::linkToCrud('Job Applications', 'fas fa-paper-plane', JobApplication::class);
        yield MenuItem::linkToCrud('Job Types', 'fas fa-tags', JobType::class);

        yield MenuItem::section('Company & Category');
        yield MenuItem::linkToCrud('Companies', 'fas fa-building', Company::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-list', Category::class);

        yield MenuItem::section('Users');
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);

        // In configureMenuItems():
        yield MenuItem::section('Contact');
        yield MenuItem::linkToCrud('Contact Messeges', 'fas fa-envelope', ContactMessege::class);

    }
}
