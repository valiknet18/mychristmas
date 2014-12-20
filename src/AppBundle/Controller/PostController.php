<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Entity\Theme;
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

        $comments = $this->get('appbundle.service.post_service')->splitComment($post->getComments());

        return [
            "post" => $post,
            "comments" => $comments
        ];
    }

    /**
     * @Route("/create")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $post = new Post();

        $form = $this->createForm(new AddPostType(), $post);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get('appbundle.service.post_service')->shortcutLiks($em, $post, $this, $request->request->get('addPost')['images']);

            $themeName = $request->request->get('addPost')['theme'];

            $theme = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('AppBundle:Theme')
                    ->findByName($themeName);

            if (!$theme) {
                $theme = new Theme();
                $theme->setName($themeName);

                $em->persist($theme);

                $post->setTheme($theme);
            } else {
                $post->setTheme($theme);
            }

            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('app_default_index');
        }

        return [
            'form' => $form->createView()
        ];
    }
}
