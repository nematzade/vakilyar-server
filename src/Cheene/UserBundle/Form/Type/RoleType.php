<?php

namespace Cheene\UserBundle\Form\Type;

use Cheene\UserBundle\Entity\Role;
use libphonenumber\PhoneNumberFormat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class RoleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'label'=>'label.title', 
                'translation_domain' => 'labels'
                )
            )
            ->add('role', 'text', array(
                'label' => 'label.roles.role',
                'translation_domain' => 'labels', 
                // 'read_only' => true, 
                'required' => true
                )
            )
            ->add('visible', 'checkbox', array(
                'label' => 'label.visible', 
                'translation_domain' => 'labels'
                )
            )
            ->add('actionGroups', null, array(
                'label' => 'label.action_groups',
                'translation_domain' => 'labels',
                'property' => 'title',
                'expanded' => true,
                'multiple' => true)
            )
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cheene\UserBundle\Entity\Role'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Role';
    }
}
