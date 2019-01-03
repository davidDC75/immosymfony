<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class PropertyType extends AbstractType
{
    /**
     * buildForm
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface',IntegerType::class,[])
            ->add('rooms',IntegerType::class,[])
            ->add('bedrooms',IntegerType::class,[])
            ->add('floor',IntegerType::class,[])
            ->add('price',MoneyType::class, [
                'currency'=>'EUR',
                'scale'=>0,
                'grouping'=>true
            ])
            ->add('heat',ChoiceType::class,[
                'choices' => array_flip(Property::HEAT),
                'choice_translation_domain' => 'forms'
            ])
            ->add('city')
            ->add('address')
            ->add('postal_code')
            ->add('sold',CheckboxType::class,[
                'help'=>'sold.help',
                'required'=>false
            ])
            // ->add('created_at')
        ;
    }

    /**
     * configureOptions
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'translation_domain' => 'forms'
        ]);
    }

}
