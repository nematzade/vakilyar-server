<?php

namespace Cheene\ContentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SliderType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('weight')
            ->add('header')
            ->add('text')
            ->add('link')
            ->add('active')
            ->add('sliderImage', 'vich_image', array(
                'label' => 'اسلایدر عکس',
                'required' => false,
                'allow_delete' => true, // not mandatory, default is true
                'download_link' => false, // not mandatory, default is true
                'attr' => array(
                    'placeholder' => '',
                ),
            ))
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cheene\ContentBundle\Entity\Slider'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'cheene_contentbundle_slider';
    }


}
