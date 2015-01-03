<?php

namespace Burrich\BlogBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

class PostAdmin extends Admin
{
    protected $datagridValues = array(
        '_page' => 1,            // display the first page (default = 1)
        '_sort_order' => 'DESC', // reverse order (default = 'ASC')
        '_sort_by' => 'publishedDate'  // name of the ordered field                   
    );

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', 'text', array('label' => 'Titre', 'required' => true))
            ->add('content', 'sonata_formatter_type', array(
                'label' => 'Contenu',
                'required' => true,
                'event_dispatcher' => $formMapper->getFormBuilder()->getEventDispatcher(),
                'format_field'   => 'contentFormatter',
                'source_field'   => 'rawContent',
                'source_field_options'      => array(
                    'attr' => array('class' => 'span10', 'rows' => 20)
                ),
                'listener'       => true,
                'target_field'   => 'content',
                'ckeditor_context'     => 'default'
            ))
            ->setHelps(array(
               'content' => $this->trans('Le contenu ne doit pas être vide.')
            ))
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('title')
                ->assertNotBlank()
            ->end()
            ->with('content')
                ->assertNotBlank()
            ->end()
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title', null, array('label' => 'Titre'));
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title', null, array('label' => 'Titre'))
            ->add('content', null, array('label' => 'Contenu'))
            ->add('comments', null, array(
                'template' => 'BurrichBlogBundle:Admin:list_comments.html.twig',
                'label' => 'Commentaires'
            ))
            ->add('author.username', null, array('label' => 'Auteur'))
            ->add('publishedDate', null, array('label' => 'Date de publication'))
        ;
    }

    public function prePersist($post)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $currentUser = $container->get('security.context')->getToken()->getUser();

        $post->setAuthor($currentUser);
    }
}
