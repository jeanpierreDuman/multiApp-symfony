<?php

namespace App\Payment\Form;

use App\Payment\Entity\Invoice;
use App\Payment\Entity\InvoiceRow;
use App\Payment\Form\InvoiceRowType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Core\Entity\Customer;

class InvoiceType extends AbstractType
{
    private $options;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->options = $options;

        $builder
            ->add('customer', EntityType::class, [
                'class' => Customer::class,
                'query_builder' => function (EntityRepository $er) {

                    if($this->options['userId'] === null) {
                        throw new \Exception("userId cannot be null");
                    }

                    $query = $er->createQueryBuilder('c')
                        ->where('c.user = :user')
                        ->setParameter('user', $this->options['userId'])
                    ;
                    return $query;
                }
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('amountHt', null, [
                'attr' => [
                    'class' => 'form-control',
                    'readonly' => true,
                ]
            ])
            ->add('subTva', null, [
                'attr' => [
                    'class' => 'form-control',
                    'readonly' => true,
                ]
            ])
            ->add('amountTtc', null, [
                'attr' => [
                    'class' => 'form-control',
                    'readonly' => true,
                ]
            ])
            ->add('tva', ChoiceType::class, [
                'choices' => [
                    '20 %' => 20,
                    '10 %' => 10,
                    '8.5 %' => 8.5,
                    '5.5 %' => 5.5,
                    '2.1 %' => 2.1
                ]
            ])
            ->add('note', null, [
                'required' => false
            ])
            ->add('isTransform')
            ->add('rows', CollectionType::class, [
                'entry_type' => InvoiceRowType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
            'userId' => null
        ]);
    }
}
