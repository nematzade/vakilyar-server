<?php

namespace Cheene\UserBundle\Form\Type;

use libphonenumber\PhoneNumberFormat;
use Cheene\UserBundle\Entity\Constants\UserConstants;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $builder->getData();

        $builder
            ->add('firstname', 'text', array(
                    'label' => 'label.users.firstname',
                    'translation_domain' => 'labels'
                )
            )
            ->add('lastname', 'text', array(
                    'label' => 'label.users.lastname',
                    'translation_domain' => 'labels'
                )
            )
            ->add('username', 'text', array(
                    'label' => 'label.users.username',
                    'translation_domain' => 'labels',
                    // 'disabled' => true
                )
            )
            ->add('plainPassword', 'repeated', array(
                'translation_domain' => 'labels',
                'type' => 'password',
                'first_options' => array('label' => 'label.auth.password', 'attr' => array(
                    'class' => 'form-control',
                    'value'
                )),
                'second_options' => array('label' => 'label.auth.password_confirmed', 'attr' => array(
                    'class' => 'form-control',
                )),
                'invalid_message' => 'label.auth.password_mismatch',
                'required' => false
            ))
            ->add('birthday', 'datetime', array(
                    'widget' => 'single_text',
                    'choice_translation_domain' => false,
                    'label' => 'label.users.birthday',
                    'translation_domain' => 'labels',
                    'attr' => array(
                        'class' => 'birthday_alt'
                    )
                )
            )
            ->add('jalaliBirthday', 'text', array(
                    'attr' => array(
                        'id' => 'birthday_alt'
                    )
                )
            )
            ->add('nationalCode', 'text', array(
                    'label' => 'label.users.national_code',
                    'translation_domain' => 'labels'
                )
            )

            ->add('email', 'email', array(
                    'label' => 'label.email',
                    'translation_domain' => 'labels',
                    'required' => false
                )
            )
            ->add('cellphone', 'tel', array(
                    'label' => 'label.cellphone',
                    'translation_domain' => 'labels',
                    'default_region' => 'IR',
                    'format' => PhoneNumberFormat::NATIONAL,
                    'attr' => array(
                        'style' => 'direction: ltr; text-align:right',
                    ),
                )
            )
            ->add('sex', 'choice', array(
                'choices' => UserConstants::$user_sexes,
                'label' => 'label.sex',
                'translation_domain' => 'labels',
            ))
            ->add('locale', 'choice', array(
                'choices' => UserConstants::$user_locales,
                'label' => 'label.locale',
                'translation_domain' => 'labels',
            ))
            ->add('status', 'choice', array(
                'choices' => UserConstants::$user_statuses,
                'label' => 'label.users.status',
                'translation_domain' => 'labels'
            ))
            ->add('comment', 'textarea', array(
                    'label' => 'label.comment',
                    'translation_domain' => 'labels',
                    'required' => false
                )
            )
            ->add('global', 'checkbox', array(
                    'label' => 'label.global',
                    'translation_domain' => 'labels',
                    'required' => false
                )
            )

            ->add('profileImage', 'vich_image', array(
                'label' => 'label.profile.photo',
                'translation_domain' => 'labels',
                'required' => false,
                'allow_delete' => true, // not mandatory, default is true
                'download_link' => false, // not mandatory, default is true
                'attr' => array(
                    'placeholder' => '',
                ),
            ))
            ->add('visible', 'checkbox', array(
                    'label' => 'label.visible',
                    'translation_domain' => 'labels',
                    'required' => false
                )
            )
            ->add('deleted', 'checkbox', array(
                    'label' => 'label.users.deleted',
                    'translation_domain' => 'labels',
                    'required' => false
                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cheene\UserBundle\Entity\User'
        ));
    }
}
