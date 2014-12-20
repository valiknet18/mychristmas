<?php
namespace AppBundle\Service;

use AppBundle\Entity\Image;
use AppBundle\Entity\Post;
use Doctrine\ORM\EntityManager;

class PostService
{
    public function splitComment($comments)
    {
        $likedComments = [];
        $dislikedComments = [];

        foreach ($comments as $comment) {
            if ($comment->getType()) {
                $likedComments[] = $comment;
            } else {
                $dislikedComments[] = $comment;
            }
        }

        return [
            $likedComments,
            $dislikedComments
        ];
    }

    public function themeConvert($theme)
    {
        $arrayStringTheme = explode(' ', $theme);

        foreach ($arrayStringTheme as &$stringTheme) {
            $stringTheme = ucfirst(trim($stringTheme));
        }

        return implode('', $arrayStringTheme);
    }
} 