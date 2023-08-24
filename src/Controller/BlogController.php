<?php

namespace App\Controller;

use App\Services\CategoriesServices;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    public function __construct(CategoriesServices $categoriesServices){
        $categoriesServices->updateSession();
    }

    #[Route('/', name: 'app_index')]
    public function hello(ArticleRepository $repoArticle): Response
    {
        $articles = $repoArticle->findAll();
        $lastArticle = $repoArticle->findOneBy([], ['id' => 'DESC']);
        
        $avantLastArticle = $repoArticle->findOneBy([], ['id' => 'DESC'], 1, 1)->getId();
        $beforeLastRecordId = $repoArticle->findOneBy(['id' => $avantLastArticle - 1]);

        $thirdAvantLastArticle = $repoArticle->findOneBy([], ['id' => 'DESC'], 1, 1)->getId();
        $beforeBeforeLastRecordId = $repoArticle->findOneBy(['id' => $thirdAvantLastArticle - 2]);
        // ss
        $art = $repoArticle->findOneBy([], ['id' => 'DESC'], 1, 1)->getId();
        $fourth = $repoArticle->findOneBy(['id' => $art - 3]);

        $arts = $repoArticle->findOneBy([], ['id' => 'DESC'], 1, 1)->getId();
        $fiveth = $repoArticle->findOneBy(['id' => $arts - 5]);
        
        $artss = $repoArticle->findOneBy([], ['id' => 'DESC'], 1, 1)->getId();
        $sixth = $repoArticle->findOneBy(['id' => $artss - 6]);

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles,
            'lastArticle' => $lastArticle,
            'avantLastArticle' => $beforeLastRecordId,
            'thirdAvantLastArticle' => $beforeBeforeLastRecordId,
            'fourth' => $fourth,
            'fiveth' => $fiveth,
            'sixth' => $sixth
        ]);
    }
    #[Route('/article/{slug}', name: 'app_single_article')]
    public function single(ArticleRepository $repoArticle, string $slug): Response
    {
        $article = $repoArticle->findOneBySlug($slug);
        return $this->render('blog/single.html.twig', [
            'controller_name' => 'BlogController',
            'article' => $article,
        ]);
    }

    #[Route('/article_by_category/{slug}', name: 'app_article_by_category')]
    public function article_by_category(CategoryRepository $repoCat, string $slug): Response
    {
        $category = $repoCat->findOneBySlug($slug);

        $articles = [];
        if($category){
            $articles = $category->getArticles()->getValues();
        }
        return $this->render('blog/article_by_category.html.twig', [
            'controller_name' => 'BlogController',
            'category' => $category,
            'articles' => $articles,
        ]);
    }

}