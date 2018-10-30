<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Entity\Article;
use App\Repository\ArticleRepository;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo)
    {    
        $articles = $repo->findAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    }

    /** 
    * @Route("/", name="home")
    */
    public function home() {
        return $this->render('blog/home.html.twig', [
            'user' => 'Mathieu'
        ]);
    }
    /**
     * @Route("/blog/new", name="create")
     */
    public function create() {
        $article = new Article();
        $form = $this->createFormBuilder($article)
                     ->add('title', TextType::class, [
                         'attr' => [
                             'placeholder' => "Titre de l'article"
                         ]
                     ])
                     ->add('content', TextareaType::class, [
                        'attr' => [
                            'placeholder' => "Contenu de l'article"
                        ]
                    ])
                     ->add('image', TextType::class, [
                        'attr' => [
                            'placeholder' => "Adresse de l'image"
                        ]
                    ])
                     ->getForm();

        return $this->render('blog/create.html.twig', [
            'formArticle' => $form->createView()
        ]);
    }
    /**
     * @Route("/blog/{id}", name="show")
     */
    public function show(Article $article) {
        return $this->render('blog/show.html.twig', [
            'article' => $article
        ]);
    }
}
