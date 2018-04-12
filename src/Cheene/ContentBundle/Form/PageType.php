<?php

namespace Cheene\ContentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',null,array(
                'label' => 'عنوان صفحه'
            ))
            ->add('content',TextareaType::class ,array(
                'label' => 'محتوا'
            ))
            ->add('pageImage', 'vich_image', array(
                'label' => 'عکس تیتر صفحه',
                'required' => false,
                'allow_delete' => true, // not mandatory, default is true
                'download_link' => false, // not mandatory, default is true
                'attr' => array(
                    'placeholder' => '',
                ),
            ))
            ->add('draft',null,array(
                'label' => 'پیش‌نویس؟'
            ))
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cheene\ContentBundle\Entity\Page'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'cheene_contentbundle_page';
    }


}
