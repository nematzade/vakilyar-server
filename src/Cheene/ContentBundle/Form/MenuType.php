<?php

namespace Cheene\ContentBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',null,array(
                'label' => 'عنوان'
            ))
            ->add('weight',null,array(
                'label' => 'وزن'
            ))
            ->add('menuOrder',null,array(
                'label' => 'اولویت چینش'
            ))
            ->add('link',null,array(
                'label' => 'لینک منو'
            ))
            ->add('parent',EntityType::class,array(
                'class' => 'Cheene\ContentBundle\Entity\Menu',
                'choice_label' => 'title',
                'label' => 'منوی بالادستی',
                'required' => false
            ))
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cheene\ContentBundle\Entity\Menu'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'cheene_contentbundle_menu';
    }


}
