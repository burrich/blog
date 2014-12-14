<?php

// src/Burrich/BlogBundle/DataFixtures/ORM/LoadCommentData.php

namespace Burich\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Burrich\BlogBundle\Entity\Comment;

class LoadCommentData implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $commentsList = array(
            array(
                'content' => 
                    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer quam turpis, elementum eget lacinia non, finibus eget metus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Cras quis elementum erat, non 
                    lobortis diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris viverra feugiat dolor eget feugiat. Fusce est erat, ultrices sit amet odio et, volutpat viverra ligula. Nam nec 
                    mi nec lacus venenatis iaculis.',
                'post' => $manager->getRepository('BurrichBlogBundle:Post')->findOneByTitle('Titre 1')
            ),
            array(
                'content' => 
                    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer quam turpis, elementum eget lacinia non, finibus eget metus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Cras quis elementum erat, non 
                    lobortis diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris viverra feugiat dolor eget feugiat. Fusce est erat, ultrices sit amet odio et, volutpat viverra ligula. Nam nec 
                    mi nec lacus venenatis iaculis.',
                'post' => $manager->getRepository('BurrichBlogBundle:Post')->findOneByTitle('Titre 1')
            ),
            array(
                'content' => 
                    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer quam turpis, elementum eget lacinia non, finibus eget metus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Cras quis elementum erat, non 
                    lobortis diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris viverra feugiat dolor eget feugiat. Fusce est erat, ultrices sit amet odio et, volutpat viverra ligula. Nam nec 
                    mi nec lacus venenatis iaculis.',
                'post' => $manager->getRepository('BurrichBlogBundle:Post')->findOneByTitle('Titre 2')
            ),
        );

        foreach ($commentsList as $commentArray) {
            $comment = new Comment();
            $comment->setContent($commentArray['content']);
            $comment->setPost($commentArray['post']);
            $comment->setAuthor($manager->getRepository('Application\Sonata\UserBundle\Entity\User')->findOneByUsername('user'));

            $manager->persist($comment);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3;
    }
}
