<?php

namespace App\Form;

use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brand' , TextType::class,
            [
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('model' , TextType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('description', TextType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('color', TextType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('price' ,TextType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('photo' , FileType::class, array('data_class' => null))

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
