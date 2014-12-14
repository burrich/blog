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
                'content' => 
                    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque congue, urna eget molestie tristique, eros urna sodales nibh, nec convallis justo est aliquet velit. Donec feugiat vitae felis lobortis tempus. 
                    In hac habitasse platea dictumst. Mauris dapibus id neque in ornare. Morbi in ornare quam. Nam lectus est, finibus vitae iaculis sit amet, elementum eu urna. Vivamus id fermentum ex. Nunc accumsan semper dolor a maximus. 
                    Proin ac cursus purus. Praesent leo arcu, porta eget facilisis ut, commodo id augue. Ut vel justo sit amet mauris sodales mollis vitae id nunc. In maximus facilisis pulvinar.'
            ),
            array(
                'title' => 'Titre 2',
                'content' => 
                    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse a lobortis orci, eu elementum purus. Nunc mattis rutrum ante. Donec eget laoreet quam. Maecenas egestas libero vel porttitor placerat. 
                    Vivamus bibendum fringilla lorem. Mauris tempus elit vitae sapien blandit finibus. Cras eget augue sagittis, tristique nisi et, fermentum tortor. Curabitur non convallis purus. Donec mollis lacus non elementum aliquam. 
                    Nullam consequat risus non purus varius sodales. Nulla in tellus nibh. Aliquam a enim eu libero tincidunt luctus quis vitae justo. Aenean felis elit, imperdiet accumsan mi quis, efficitur volutpat lorem. 
                    Praesent at neque cursus, vulputate leo a, molestie nisi.

                    Proin iaculis tellus vitae justo sagittis, malesuada rhoncus dui rutrum. Nam posuere tempor iaculis. Pellentesque vitae aliquet metus, nec rutrum leo. Mauris quis turpis egestas, hendrerit eros eu, fringilla mauris. 
                    Fusce ut scelerisque lacus. Duis feugiat, neque non aliquet rhoncus, erat tortor tempor purus, ut ultrices magna quam a orci. In tincidunt sodales fringilla. Nulla vel orci lobortis, viverra ligula vel, eleifend arcu. 
                    Nulla sodales rutrum mauris nec molestie. Duis eget varius enim.

                    Mauris pharetra ut justo at tempor. Sed eu augue libero. Nam elementum scelerisque mollis. Fusce at dignissim magna. Integer fringilla lectus a mattis euismod. Aenean dictum finibus quam, a tincidunt lacus tincidunt a. 
                    Suspendisse potenti. Nam pharetra odio id lacus efficitur sodales.'
            ),
            array(
                'title' => 'Titre 3',
                'content' => 
                    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vestibulum sit amet ipsum vulputate congue. Cras consectetur nisl ante, ac facilisis enim dapibus a. Cras iaculis malesuada scelerisque. 
                    Praesent eget est at dui fermentum feugiat non eget nisi. Vestibulum et feugiat est. Fusce lacinia turpis mollis maximus ultrices. In pretium volutpat mauris eu sollicitudin. Lorem ipsum dolor sit amet, 
                    consectetur adipiscing elit. Nunc tincidunt maximus consequat. Etiam sodales finibus odio, ac accumsan sapien commodo in. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.

                    Pellentesque auctor velit a tempor vulputate. Nulla facilisi. Vestibulum ullamcorper nulla ligula, vel condimentum lacus vulputate in. Aliquam accumsan lacus nec elit fermentum maximus. Donec ut felis tellus. 
                    Fusce et diam eu arcu volutpat lobortis ut quis mi. Suspendisse ornare enim in ex porta commodo. Etiam neque enim, commodo eu sagittis tempus, vestibulum eget neque. Nunc hendrerit ligula dui, eu venenatis lorem mollis eu. 
                    Morbi accumsan purus quis ligula commodo, nec dictum tellus laoreet. Suspendisse potenti. Donec eu neque mauris. In blandit odio ex, at dictum dui imperdiet at.'
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

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}
