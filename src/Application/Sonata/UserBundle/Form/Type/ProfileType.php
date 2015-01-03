<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Application\Sonata\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

use Sonata\UserBundle\Model\UserInterface;
use Sonata\UserBundle\Form\Type\ProfileType as BaseType;

class ProfileType extends BaseType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender', 'sonata_user_gender', array(
                'label'    => 'Sexe',
                'required' => true,
                'translation_domain' => 'SonataUserBundle',
                'choices' => array(
                    UserInterface::GENDER_FEMALE => 'gender_female',
                    UserInterface::GENDER_MALE   => 'gender_male',
                )
            ))
            ->add('lastname', null, array(
                'label'    => 'form.label_lastname',
                'required' => false
            ))
            ->add('firstname', null, array(
                'label'    => 'form.label_firstname',
                'required' => false
            ))
            ->add('dateOfBirth', 'birthday', array(
                'label'    => 'form.label_date_of_birth',
                'required' => false,
                'widget'   => 'single_text'
            ))
        ;
    }

   
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'application_sonata_user_profile';
    }
}
