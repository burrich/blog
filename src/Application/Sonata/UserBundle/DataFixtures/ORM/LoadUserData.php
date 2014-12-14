<?php

// src/Application/Sonata/UserBundle/DataFixtures/ORM/LoadUserData.php

namespace Application\Sonata\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Doctrine\Common\Persistence\ObjectManager;
use Application\Sonata\UserBundle\Entity\User;

class LoadUserData extends ContainerAware implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $encoderFactory = $this->container->get('security.encoder_factory');

        $usersList = array(
            array(
                'username' => 'admin',
                'password' => 'admin',
                'email' => 'admin@gmail.com',
                'role' => 'ROLE_SUPER_ADMIN',
            ),
            array(
                'username' => 'nico',
                'password' => 'nico',
                'email' => 'nico@gmail.com',
                'role' => 'ROLE_ADMIN',
            ),
            array(
                'username' => 'user',
                'password' => 'user',
                'email' => 'user@gmail.com'
            )
        );

        foreach ($usersList as $userArray) {
            $user = new User();
            $encoder = $encoderFactory->getEncoder($user);
            $user->setUsername($userArray['username']);
            $user->setPassword($encoder->encodePassword($userArray['password'], $user->getSalt()));
            $user->setEmail($userArray['email']);
            $user->setEnabled(true);

            if (array_key_exists('role', $userArray)) {
                $user->addRole($userArray['role']);
            }

            $manager->persist($user);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
