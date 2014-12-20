<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Form\Type\AddPostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/post")
 */
class PostController extends Controller
{
    /**
     * @Route("/top/{type}", defaults= {"type" = "like"}, requirements={"type" = "like|dislike"})
     * @Method({"GET"})
     * @Template()
     */
    public function topAction($type, Request $request)
    {
        $posts = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Post')
            ->findAll();

        $paginator  = $this->get('knp_paginator');
        $posts = $paginator->paginate(
            $posts,
            $request->query->get('page', 1),
            10
        );

        return [
            "posts" => $posts,
            "type" => $type
        ];
    }

    /**
     * @Template()
     * @Route("/{id}/view")
     * @Method("GET")
     */
    public function getAction($id)
    {
        $post = $this->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Post')
                ->findOneById($id);

        return [
            "post" => $post
        ];
    }

    /**
     * @Route("/create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $post = new Post();

        $form = $this->createForm(new AddPostType(), $post);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('app_default_index');
        }

        return [
            'form' => $form->createView()
        ];
    }
}
