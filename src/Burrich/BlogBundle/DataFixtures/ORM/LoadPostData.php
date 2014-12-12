<?php

// src/Burrich/BlogBundle/DataFixtures/ORM/LoadPostData.php

namespace Burich\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Burrich\BlogBundle\Entity\Post;

class LoadPostData implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $postsList = array(
            array(
                'title' => 'Titre 1',
                'content' => 'Contenu 1'
            ),
            array(
                'title' => 'Titre 2',
                'content' => 'Contenu 2'
            ),
            array(
                'title' => 'Titre 3',
                'content' => 'Contenu 3'
            )
        );

        foreach ($postsList as $postArray) {
            $post = new Post();
            $post->setTitle($postArray['title']);
            $post->setContent($postArray['content']);
            $post->setAuthor($manager->getRepository('Application\Sonata\UserBundle\Entity\User')->findOneByUsername('nico'));

            $manager->persist($post);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
