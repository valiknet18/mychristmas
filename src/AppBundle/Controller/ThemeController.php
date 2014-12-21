<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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

        $this->render(
            "AppBundle:Theme:getPopular.html.twig",
            [
                "themes" => $themes
            ]
        );
    }
}
