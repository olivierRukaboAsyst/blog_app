<?php

namespace App\Controller;

use App\Services\CategoriesServices;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Extra\Intl\IntlExtension;

class BlogController extends AbstractController
{
    // private $twig;
    public function __construct(CategoriesServices $categoriesServices){
        $categoriesServices->updateSession();
        // $this->twig = $twig;
        // $this->twig->addExtension(new IntlExtension());
    }

    #[Route('/', name: 'app_index')]
    public function hello(ArticleRepository $repoArticle,
                            CategoryRepository $categoryRepository): Response
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

        $date_heure = new \DateTime;

        // Categories
        $categories = $categoryRepository->findAll();
  
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles,
            'lastArticle' => $lastArticle,
            'avantLastArticle' => $beforeLastRecordId,
            'thirdAvantLastArticle' => $beforeBeforeLastRecordId,
            'fourth' => $fourth,
            'date_heure' => $date_heure,
            'categories' => $categories
        ]);
    }
    // #[Route(null, name: 'app_index')]
    // public function base(): Response
    // {

    //     $date_heure = new \DateTime;

    //     return $this->render('base.html.twig', [
    //         'controller_name' => 'BlogController',
    //         'date_heure' => $date_heure
    //     ]);
    // }
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