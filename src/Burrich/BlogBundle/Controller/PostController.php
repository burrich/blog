<?php

namespace Burrich\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Burrich\BlogBundle\Entity\Comment;
use Burrich\BlogBundle\Form\CommentType;

class PostController extends Controller
{
    /**
     * List all posts
     * 
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
     * Show a post with comments and comment add form
     * 
     * @Route("/{slug}", name="post_show")
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
        $commentForm = $this->createForm(new CommentType(), $comment);

        $commentForm->handleRequest($request);

        if ($commentForm->isValid()) {
            $comment->setPost($post);
            $comment->setAuthor($this->getUser());
            $em->persist($comment);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Commentaire ajouté !');

            return $this->redirect($this->generateUrl('post_show', array('slug' => $slug)) . '#comments');
        }

        return array(
            'post' => $post,
            'commentForm' => $commentForm->createView()
        );
    }
}