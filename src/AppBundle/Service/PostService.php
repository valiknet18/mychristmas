<?php
namespace AppBundle\Service;

use AppBundle\Entity\Image;
use AppBundle\Entity\Post;
use Doctrine\ORM\EntityManager;

class PostService
{
    public function shortcutLiks(EntityManager $em, Post $post, $container, $links)
    {
        foreach ($links as $link) {
            $image = new Image();

//            $linkManager   = $container->get('mremi_url_shortener.link_manager');
//            $chainProvider = $container->get('mremi_url_shortener.chain_provider');
//
//            $linker = $linkManager->create();
//            $linker->setLongUrl($link['long_url']);
//
//            $url = $chainProvider->getProvider('google')->shorten($linker);

            $image->setLongUrl($link['long_url']);
//            $image->setShortUrl($url);

            $image->setPost($post);

            $em->persist($image);
        }
    }
} 