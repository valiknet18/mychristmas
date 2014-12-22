<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * @Route("/theme")
 */
class ThemeController extends Controller
{
    /**
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/getPopularAction")
     */
    public function getPopularAction()
    {
        $themes = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('AppBundle:Theme')
                    ->getTopPopularTheme();

        return $this->render(
            "AppBundle:Theme:getPopular.html.twig",
            [
                "themes" => $themes
            ]
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{slug}/view")
     * @Template()
     */
    public function getAction($slug, Request $request)
    {
        $theme = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('AppBundle:Theme')
                    ->findBySlug($slug)[0];

        if (!$theme) {
            throw new HttpException(404);
        }

        $posts = $theme->getPosts();

        $paginator  = $this->get('knp_paginator');
        $posts = $paginator->paginate(
            $posts,
            $request->query->get('page', 1),
            10
        );

        return [
            "theme" => $theme,
            "posts" => $posts
        ];
    }
}
