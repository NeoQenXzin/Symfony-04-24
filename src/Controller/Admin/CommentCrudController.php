<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use Symfony\Component\HttpFoundation\File\UploadedFile;

// Faire import all class
class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }
    // public function configureCrud(Crud $crud): Crud
    // {
    //     return $crud
    //         ->setEntityLabelInSingular('Conference Comment')
    //         ->setEntityLabelInPlural('Conference Comments')
    //         ->setSearchFields(['author', 'text', 'email'])
    //         ->setDefaultSort(['createdAt' => 'DESC']);
    // }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('conference');
        yield TextField::new('author');
        yield EmailField::new('email');
        yield TextareaField::new('text')
            ->hideOnIndex();
        // yield TextField::new('photoFilename')
        yield ImageField::new('photoFilename')
            ->setBasePath('/uploads/photos')
            ->setUploadDir('public/uploads/photos')
            ->setUploadedFileNamePattern(fn (UploadedFile $photo) => Comment::setFilename($photo))
            // ->setUploadedFileNamePattern(fn (UploadedFile $photo) => bin2hex(random_bytes(6)) . '.' . $photo->guessExtension())
            // ->setLabel('Photo')
            // ->onlyOnIndex();
            ->setLabel('Photo');
        yield ChoiceField::new('state');
        $createdAt = DateTimeField::new('createdAt')
            ->hideOnForm();

        if (Crud::PAGE_EDIT === $pageName) {
            yield $createdAt->setFormTypeOption('disabled', true);
        } else {
            yield $createdAt;
        }
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Conference Comment')
            ->setEntityLabelInPlural('Conference Comments')
            ->setSearchFields(['author', 'text', 'email'])
            ->setDefaultSort(['createdAt' => 'DESC']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('conference'));
    }
}
