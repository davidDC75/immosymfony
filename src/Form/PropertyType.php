<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // Ici pour changer les labels simplement sans la translation
            // ->add('title',null,['label'=>'Titre'])
            // ->add('description')
            // ->add('surface')
            // ->add('rooms',null,['label'=>'Pièces'])
            // ->add('bedrooms',null,['label'=>'Chambres'])
            // ->add('floor',null,['label'=>'Etage'])
            // ->add('price',null,['label'=>'Prix'])
            // ->add('heat',null,['label'=>'Type Chauffage'])
            // ->add('city',null,['label'=>'Ville'])
            // ->add('address',null,['label'=>'Adresse'])
            // ->add('postal_code',null,['label'=>'Code Postal'])
            // ->add('sold',null,['label'=>'Vendu'])
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('floor')
            ->add('price')
            ->add('heat',ChoiceType::class,[
                'choices' => array_flip(Property::HEAT)
            ])
            ->add('city')
            ->add('address')
            ->add('postal_code')
            ->add('sold')
            // ->add('created_at')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'translation_domain' => 'forms'
        ]);
    }
}
