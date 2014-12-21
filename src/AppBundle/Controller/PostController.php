<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use AppBundle\Entity\Post;
use AppBundle\Entity\Theme;
use AppBundle\Form\Type\AddCommentType;
use AppBundle\Form\Type\AddPostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;

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

        if ($type === 'like') {
            $posts = $this->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Post')
                ->getTopLikedPost();
        } else {
            $posts = $this->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Post')
                ->getTopDislikedPost();
        }


        $paginator  = $this->get('knp_paginator');
        $posts = $paginator->paginate(
            $posts,
            $request->query->get('page', 1),
            10
        );

        return [
            "posts" => $posts
        ];
    }

    /**
     * @Template()
     * @Route("/{id}/view")
     * @Method("GET")
     */
    public function getAction($id)
    {
        $form = $this->createForm(new AddCommentType());

        $post = $this->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Post')
                ->findOneById($id);

        $comments = $this->get('appbundle.service.post_service')->splitComment($post->getComments());

        return [
            "post" => $post,
            "comments" => $comments,
            "form" => $form->createView()
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
            if (isset($request->request->get('addPost')['images'])) {
                $links = $request->request->get('addPost')['images'];

                foreach ($links as $link) {
                    $image = new Image();
                    $image->setLongUrl($link['long_url']);
                    $image->setPost($post);

                    $em->persist($image);
                }
            }

            $themeName = $this->get('appbundle.service.post_service')->themeConvert($request->request->get('addPost')['theme']);

            $theme = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('AppBundle:Theme')
                    ->findByName($themeName);

            if (!$theme) {
                $theme = new Theme();
                $theme->setName($request->request->get('addPost')['theme']);
                $theme->setConvertedName($themeName);

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
