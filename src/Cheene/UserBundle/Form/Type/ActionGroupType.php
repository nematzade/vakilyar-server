<?php

namespace Cheene\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ActionGroupType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', 'text', array('label'=>'label.code', 'translation_domain' => 'labels'))
            ->add('title', 'text', array('label'=>'label.title', 'translation_domain' => 'labels'))
            ->add('visible', 'checkbox', array('label'=>'label.visible', 'translation_domain' => 'labels'))
            ->add('actions', null, array(
                    'label' => 'label.actions',
                    'translation_domain' => 'labels',
                    'property' => 'title',
                    'multiple' => true,
                    'expanded' => true
                )
            )
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cheene\UserBundle\Entity\ActionGroup'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cheene_userbundle_actiongroup';
    }
}
