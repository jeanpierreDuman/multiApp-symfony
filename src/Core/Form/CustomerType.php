<?php

namespace App\Core\Form;

use App\Core\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fullNotRequired = $options['fullNotRequired'] === null ? true : false;

        $builder
            ->add('name', null,[
                'required' => $fullNotRequired,
                'attr' => [
                    'placeholder' => "Nom"
                ]
            ])
            ->add('street', null,[
                'required' => $fullNotRequired,
                'attr' => [
                    'placeholder' => "Rue/Avenue"
                ]
            ])
            ->add('zipCode', null,[
                'required' => $fullNotRequired,
                'attr' => [
                    'placeholder' => "Code postal"
                ]
            ])
            ->add('city', null,[
                'required' => $fullNotRequired,
                'attr' => [
                    'placeholder' => "Ville"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
            'fullNotRequired' => null
        ]);
    }
}
