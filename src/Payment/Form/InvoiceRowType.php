<?php

namespace App\Payment\Form;

use App\Payment\Entity\InvoiceRow;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceRowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity', null, [

            ])
            ->add('description', null, [

            ])
            ->add('unitPrice', null, [
    
            ])
            ->add('amountPrice', null, [
                'attr' => [
                    'readonly' => true
                ],
                'empty_data' => 0
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InvoiceRow::class,
        ]);
    }
}
