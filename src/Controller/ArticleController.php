<?php

namespace App\Controller;


use App\Entity\Article;
use App\Service\MarkdownHelper;
use App\Service\SlackClient;
use Doctrine\Common\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(ObjectManager $em)
    {
        $repository = $em->getRepository(Article::class);
        $articles = $repository->findAllPublishedOrderedByNewest();
        return $this->render('article/homepage.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show(Article $article, SlackClient $slack)
    {
        if ($article->getSlug() === 'khaaaaaan') {
            $slack->sendMessage('Kahn', 'Ah, Kirk, my old friend...');
        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart(Article $article, LoggerInterface $logger, ObjectManager $em)
    {

        $article->incrementHeartCount();
        $em->flush();
        $logger->info('Article is being hearted!');

        return $this->json(['hearts' => $article->getHeartCount()]);
    }
}

