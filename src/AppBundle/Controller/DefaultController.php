<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Template ()
     * @Route("/")
     * @Method({"GET"})
     */
    public function indexAction(Request $request)
    {
        $posts = $this->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Post')
                ->findBy([], ["createdAt" => "DESC"]);

        $paginator  = $this->get('knp_paginator');
        $posts = $paginator->paginate(
            $posts,
            $request->query->get('page', 1),
            5
        );

        return [
            'posts' => $posts
        ];
    }
}
