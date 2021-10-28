<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),  //pour que l'id ne s'affiche pour la création d'un article
            TextField::new('title'),
            TextEditorField::new('content'),
            ImageField::new('image')->setUploadDir("public/assets/blog/images") //indique le chemin des images
                                    ->setBasePath("assets/blog/images") // pour afficher les images dans le dashboard
                                    ->setRequired(false), //pour ne pas à avoir à rechoisir une image quand on Edit
            AssociationField::new('author'),
            AssociationField::new('category'),

        ];
    }
    
}
