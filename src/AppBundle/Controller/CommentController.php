<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Form\Type\AddCommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/comment")
 */
class CommentController extends Controller
{
    /**
     * @Route("{id}/create", name="comment_add")
     * @Method({"POST"})
     */
    public function createAction($id, Request $request)
    {
        $em = $this->getDoctrine()
                ->getManager();

        $comment = new Comment();

        $form = $this->createForm(new AddCommentType(), $comment);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $post = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('AppBundle:Post')
                    ->findById($id);

            if ($post) {
                return JsonResponse::create(null, 404);
            }

            $comment->setPost($post);

            $em->persist($comment);
            $em->flush();

            return JsonResponse::create(null, 200);
        }

        return JsonResponse::create(null, 500);
    }
} 