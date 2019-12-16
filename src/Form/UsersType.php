<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2019-04-02
 * Time: 21:13
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Wpisz login',
                    'autocomplete' => 'off'
                ],
                'label' => 'Login'
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Wpisz hasło'
                    ],
                    'label' => 'Hasło'
                ],
                'second_options' => [
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Powtórz hasło'
                    ],
                    'label' => 'Powtórz hasło'
                ]

            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Wpisz email',
                    'autocomplete' => 'off'
                ],
                'label' => 'E-mail'
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ],
                'label' => 'Zarejestruj się'
            ])
            ;
    }
}