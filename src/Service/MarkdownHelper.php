<?php
/**
 * Created by PhpStorm.
 * User: borya
 * Date: 31/01/19
 * Time: 12:02
 */

namespace App\Service;


use Michelf\MarkdownInterface;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class MarkdownHelper
{
    /**
     * @var AdapterInterface
     */
    private $cache;

    /**
     * @var MarkdownInterface
     */
    private $markdown;

    /**
     * @var Logger
     */
    private $logger;

    public function __construct(AdapterInterface $cache, MarkdownInterface $markdown, LoggerInterface $logger)
    {
        $this->cache = $cache;
        $this->markdown = $markdown;
        $this->logger = $logger;
    }

    public function parse(string $source): string
    {
        $item = $this->cache->getItem('markdown_'.md5($source));
        if (!$item->isHit()) {
            $item->set($this->markdown->transform($source));
            $this->cache->save($item);
        }
        if (stripos($source, 'bacon') !== false) {
            $this->logger->info('They are talking about bacon again!');
        }
        return $item->get();
    }
}