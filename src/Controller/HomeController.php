<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    private $repoArticle;
    private $repoCategory;

    public function __construct(ArticleRepository $repoArticle, CategoryRepository $repoCategory)
    {
        $this->repoArticle = $repoArticle;
        $this->repoCategory = $repoCategory;
    }
    /**
     * @Route("/", name="home")
     */
    public function index(): Response   //permet a Symfony de charger les donnees de ArticleRepository dans $repoArticle
    {                                                                   // c'est une injection de dépendance
        //$repo = $this->getDoctrine()->getRepository(Article::class),   // remplace cette ligne <-  
        $articles = $this->repoArticle->findAll();
        $categories = $this->repoCategory->findAll();

        return $this->render('home/index.html.twig',[
            "articles" => $articles,
            "categories" => $categories,
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(Article $article): Response
    {
        //$repo = $this->getDoctrine()->getRepository(Article::class);
        //$article = $this->repoArticle->find($id);

        if(!$article){
            return $this->redirectToRoute('home');
        }

        return $this->render('show/index.html.twig',[
            "article" => $article,
        ]);
    }

    /**
     * @Route("/showArticles/{id}", name="show_article")
     */
    public function showArticle(?Category $category): Response
    {
        if($category){
            $articles = $category->getArticles()->getValues();
        }else{
            $articles = null;
            return $this->redirectToRoute('home');
        }
        $categories = $this->repoCategory->findAll();
        return $this->render('home/index.html.twig',[
            'articles' => $articles,
            'categories' => $categories
        ]);
    }
}
