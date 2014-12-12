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

        $admin = new User();
        $encoder = $encoderFactory->getEncoder($admin);
        $admin->setUsername('admin');
        $admin->setPassword($encoder->encodePassword('admin', $admin->getSalt()));
        $admin->setEmail('admin@gmail.com');
        $admin->addRole('ROLE_SUPER_ADMIN');
        $admin->setEnabled(true);

        $nico = new User();
        $encoder = $encoderFactory->getEncoder($nico);
        $nico->setUsername('nico');
        $nico->setPassword($encoder->encodePassword('nico', $nico->getSalt()));
        $nico->setEmail('nico@gmail.com');
        $nico->addRole('ROLE_ADMIN');
        $nico->setEnabled(true);

        $user = new User();
        $encoder = $encoderFactory->getEncoder($user);
        $user->setUsername('user');
        $user->setPassword($encoder->encodePassword('user', $user->getSalt()));
        $user->setEmail('user@gmail.com');
        $user->setEnabled(true);

        $manager->persist($admin);
        $manager->persist($nico);
        $manager->persist($user);
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
