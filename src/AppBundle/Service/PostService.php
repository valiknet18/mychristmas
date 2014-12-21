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
            $stringTheme = $this->mbUcfirst(strtolower(trim($stringTheme)));
        }

        return implode('', $arrayStringTheme);
    }

    public function mbUcfirst($string)
    {
        return mb_strtoupper(mb_substr($string, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($string, 1, mb_strlen($string), 'UTF-8');
    }
} 