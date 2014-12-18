<?php

namespace Burrich\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class BlogController extends Controller
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
            'posts' => $posts,
            'nbPages' => $nbPages,
            'currentPage' => $page
        );    
    }

    /**
     * @Route("/{slug}", name="blog_post")
     * @Template()
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('BurrichBlogBundle:Post')->getPost($slug);

        if (!$post) {
            throw $this->createNotFoundException("La page demandée n'existe pas.");
        }

        return array(
            'post' => $post
        );
    }
}
