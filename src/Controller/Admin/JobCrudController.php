<?php

// src/Controller/Admin/JobCrudController.php

namespace App\Controller\Admin;

use App\Entity\Job;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class JobCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Job::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextEditorField::new('description')->setSortable(false),
            TextField::new('city'),
            TextField::new('country'),
            BooleanField::new('remoteAllowed'),
            IntegerField::new('salaryRange'),
            DateTimeField::new('createdAt'),
            AssociationField::new('company')->autocomplete(),
            AssociationField::new('category')->autocomplete(),
            AssociationField::new('jobTypes')->setFormTypeOption('by_reference', false),
        ];
        
    }
}
