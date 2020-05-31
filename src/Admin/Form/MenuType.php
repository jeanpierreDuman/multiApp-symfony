<?php

namespace App\Admin\Form;

use App\Admin\Entity\Menu;
use App\Admin\Entity\Society;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('structure')
            ->add('name')
            ->add('society', EntityType::class, [
                'class' => Society::class,
                'choice_label' => 'name',
                'mapped' => false,
                'multiple' => true
            ])
            ->add('route')
            ->add('enable')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
