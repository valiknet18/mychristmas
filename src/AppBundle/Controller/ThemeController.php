<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
     * @return object|void
     *
     * @Route("/{slug}/view")
     * @Template()
     */
    public function getAction($slug)
    {
        $theme = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('AppBundle:Theme')
                    ->findBySlug($slug);

        return [
            "theme" => $theme
        ];
    }
}
