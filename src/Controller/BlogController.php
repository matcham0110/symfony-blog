<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\Common\Persistence\ObjectManager;

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
     * @Route("/blog/{id}/edit", name="edit")
     */
    public function form(Article $article = null, Request $request, ObjectManager $manager) {

        if (!$article)
            $article = new Article();

        $form = $this->createFormBuilder($article)
                     ->add('title', TextType::class)
                     ->add('content', TextareaType::class)
                     ->add('image', TextType::class)
                     ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$article->getId())
                $article->setCreateAt(new \Datetime());
            $manager->persist($article);
            $manager->flush();
            return $this->redirectToRoute('show', ['id' => $article->getId()]);
        }

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
