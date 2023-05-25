<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ArticleController extends AbstractController
{

    #[Route('/article', name: 'article_controller')]
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }
    

    #[Route('/article/new', name: 'article_new')]
        public function new(Request $request,EntityManagerInterface $entityManager) {
            $article = new Article();
            $form = $this->createForm(ArticleType::class,$article);
            $form->handleRequest($request);
           
            if($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $entityManager->persist($article);
            $entityManager->flush();
           
            return $this->redirectToRoute('home');
            }
            return $this->render('article/new.html.twig',['form' => $form->createView()]);
            }

            #[Route('/article/{id}', name: 'article_show')]
            public function show($id,EntityManagerInterface $entityManager) {
                $article = $entityManager->getRepository(Article::class)->find($id);
                return $this->render('article/show.html.twig', array('article' => $article));
                 }

            #[Route('/article/edit/{id}', name: 'article_edit')]
            public function edit(Request $request, $id,EntityManagerInterface $entityManager){
                    $article = new Article();
                    $article = $entityManager->getRepository(Article::class)->find($id);
                    $form = $this->createForm(ArticleType::class,$article);
                    $form->handleRequest($request);
                    if($form->isSubmitted() && $form->isValid()) {
                    $entityManager->flush();
                    return $this->redirectToRoute('home');
                    }
                    return $this->render('article/edit.html.twig', ['form' => $form->createView()]);
                    }
                    
            #[Route('/article/delete/{id}', name: 'article_delete')]
            public function delete(Request $request, $id,EntityManagerInterface $entityManager) {
                        $article = $entityManager->getRepository(Article::class)->find($id);                       
                        $entityManager->remove($article);
                        $entityManager->flush();
                        return $this->redirectToRoute('home');
                        }
                       
                   
                

}
