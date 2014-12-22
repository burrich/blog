<?php

namespace Burrich\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Burrich\BlogBundle\Entity\Comment;
use Burrich\BlogBundle\Form\CommentType;

class CommentController extends Controller
{
    /**
     * Edit a comment
     * 
     * @Route("/edit/comment/{id}", name="comment_edit")
     * @Template()
     */
    public function editAction(Comment $comment, Request $request)
    {
        $editCommentForm = $this->createForm(new CommentType(), $comment);

        $editCommentForm->handleRequest($request);

        if ($editCommentForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Commentaire edité !');
            $slug = $comment->getPost()->getSlug();

            return $this->redirect($this->generateUrl('post_show', array('slug' => $slug)) . '#comments');
        }

        return array(
            'comment' => $comment,
            'editCommentForm' => $editCommentForm->createView()
        );
    }

    /**
     * Delete a comment
     * 
     * @Route("/delete/comment/{id}", name="comment_delete")
     * @Template()
     */
    public function deleteAction(Comment $comment, Request $request)
    {
        $deleteCommentForm = $this->createFormBuilder()->getForm();
        
        $deleteCommentForm->handleRequest($request);

        if ($deleteCommentForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Commentaire supprimé !');
            $slug = $comment->getPost()->getSlug();

            return $this->redirect($this->generateUrl('post_show', array('slug' => $slug)) . '#comments');
        }

        return array(
            'comment' => $comment,
            'deleteCommentForm' => $deleteCommentForm->createView()
        );
    }
}