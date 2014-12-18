<?php

namespace Burrich\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Burrich\BlogBundle\Entity\Comment;
use Burrich\BlogBundle\Form\CommentType;

class BlogController extends Controller // TODO refactoriser en plusieurs controleurs
{
    /**
     * @Route("/{page}", name="blog_index", defaults={"page": 1}, requirements={"page": "\d+"})
     * @Template()
     */
    public function indexAction($page)
    {
        $postsPerPage = $this->container->getParameter('posts_per_page');

        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('BurrichBlogBundle:Post')->getPosts($page, $postsPerPage);

        $nbPages = ceil(count($posts) / $postsPerPage);

        if ($page < 1 || $page > $nbPages) {
            throw $this->createNotFoundException("La page demandée n'existe pas.");
        }

        return array(
            'posts'       => $posts,
            'nbPages'     => $nbPages,
            'currentPage' => $page
        );    
    }

    /**
     * @Route("/{slug}", name="blog_post")
     * @Template()
     */
    public function showAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('BurrichBlogBundle:Post')->getPost($slug);

        if (!$post) {
            throw $this->createNotFoundException("La page demandée n'existe pas.");
        }

        $comment = new Comment();
        $form = $this->createForm(new CommentType(), $comment);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $comment->setPost($post);
            $comment->setAuthor($this->getUser());
            $em->persist($comment);
            $em->flush();

            return $this->redirect($this->generateUrl('blog_post', array('slug' => $slug)) . '#comments');
        }

        return array(
            'post' => $post,
            'form' => $form->createView()
        );
    }

    // public function deleteCommentAction($id, $slug, Request $request)
    // {
    //     $em = $this->getDoctrine()->getManager();
    //     $comment = $em->getRepository('BurrichBlogBundle:Comment')->find($id);

    //     if (!$comment) {
    //         throw $this->createNotFoundException("Le commentaire n'existe pas.");
    //     }

    //     $form = $this->createFormBuilder()->getForm();
    //     $form->handleRequest($request);

    //     if ($form->isValid()) {
    //         $em->remove($comment);

    //         return $this->redirect($this->generateUrl('blog_post', array('slug' => $slug)) . '#comments');
    //     }
    // }
}
