<?php

namespace Burrich\BlogBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PostAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', 'text', array('label' => 'Title'))
            ->add('content')
            ->add('publishedDate')
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('author')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('content')
            ->add('comments', null, array('template' => 'BurrichBlogBundle:Admin:list_comments.html.twig'))
            ->add('author')
            ->add('publishedDate')
        ;
    }

    public function prePersist($post)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $currentUser = $container->get('security.context')->getToken()->getUser();

        $post->setAuthor($currentUser);
    }
}
