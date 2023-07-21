<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Services\UploadFile;
use App\Services\CategoriesServices;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/account')]
class ArticleController extends AbstractController
{
    private $uploadFile;
    private $em;
    public function __construct(CategoriesServices $categoriesServices, UploadFile $uploadFile,
    EntityManagerInterface $em){
        $categoriesServices->updateSession();
        $this->uploadFile = $uploadFile;
        $this->em = $em;
    }
    #[Route('/', name: 'app_dashboard', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
        ]);
    }
    #[Route('/articles', name: 'app_article_index', methods: ['GET'])]
    public function articles(ArticleRepository $articleRepository): Response
    {
        $user = $this->getUser();
        if(!$user){
            // Error
        }
        return $this->render('article/articles.html.twig', [
            $articles = $articleRepository->findByAuthor($user),
            'articles' => $articles
        ]);
    }

    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setCreatedAt(new \DateTimeImmutable());

            $file = $form["imageFile"]->getData();
            
            $file_url = $this->uploadFile->saveFile($file);

            $article->setImageUrl($file_url);
            $article->setAuthor($this->getUser());
            
            $this->em->persist($article);
            $this->em->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('blog/single.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUpdatedAt(new \DateTimeImmutable());

            $file = $form["imageFile"]->getData();
            if ($file) {
                $file_url = $this->uploadFile->updateFile($file, $article->getImageUrl());
                $article->setImageUrl($file_url);
            }

            $this->em->persist($article);
            $this->em->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $imageUrl = $article->getImageUrl();
            $articleRepository->remove($article, true);
            $this->uploadFile->removeFile($imageUrl);
        }

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }
}