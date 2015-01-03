<?php

namespace Application\Sonata\UserBundle\Block;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\BaseBlockService;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;



class ProfilBlockService extends BaseBlockService
{

	/**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        return $this->renderPrivateResponse($blockContext->getTemplate(), array(
            'block'   => $blockContext->getBlock(),
            'context' => $blockContext
        ));
    }

	public function setDefaultSettings(OptionsResolverInterface $resolver)
	{
	    $resolver->setDefaults(array(
	        'url'      => false,
	        'title'    => 'Mon titre',
	        'template' => 'ApplicationSonataUserBundle:Block:profil.html.twig',
	    ));
	}

	/**
	 * {@inheritdoc}
	 */
	public function buildEditForm(FormMapper $form, BlockInterface $block)
	{
	    // no options available
	}

	/**
	 * {@inheritdoc}
	 */
	public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
	{
	}
}

