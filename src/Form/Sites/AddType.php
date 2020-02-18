<?php
/**
 * Created by PhpStorm.
 * User: Yellowspl
 * Date: 2/18/2020
 * Time: 10:54 AM
 */

namespace App\Form\Sites;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class AddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'link',
                    'style' => 'min-width: 400px;',
                    'autocomplete' => 'off'
                ],
                'label' => false
            ])
            ->add('urlType', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-left: 15px;'
                ],
                'choices' => [
                    'Polityka' => 'politic',
                    'Sklep' => 'shop',
                    'Blog' => 'blog',
                    'Rozrywkowy' => 'entertaining',
                    'Inne' => 'other'
                ],
                'label' => false
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary',
                    'style' => 'margin-left: 15px;'
                ],
                'label' => 'Sprawdż'
            ]);
    }
}