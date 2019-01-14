<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

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
            ->add('title',TextType::class,['label'=>'property.title'])
            ->add('description',TextareaType::class,['label'=>'property.description'])
            ->add('surface',IntegerType::class,['label'=>'property.surface'])
            ->add('rooms',IntegerType::class,['label'=>'property.rooms'])
            ->add('bedrooms',IntegerType::class,['label'=>'property.bedrooms'])
            ->add('floor',IntegerType::class,['label'=>'property.floor'])
            ->add('price',MoneyType::class, [
                'label'=>'property.price',
                'currency'=>'EUR',
                'scale'=>0,
                'grouping'=>true
            ])
            ->add('heat',ChoiceType::class,[
                'label'=>'property.heat',
                'choices' => array_flip(Property::HEAT),
                'choice_translation_domain' => 'forms'
            ])
            ->add('options',EntityType::class,[
                'label'=>'property.options',
                'class'=>Option::class,
                'choice_label'=>'name',
                'multiple'=>true,
                'required'=>false
            ])
            ->add('pictureFiles',FileType::class,[
                'label'=>'property.image',
                'required'=>false,
                'multiple'=>true
            ])
            ->add('city',TextType::class,['label'=>'property.city'])
            ->add('address',TextType::class,['label'=>'property.address'])
            ->add('postal_code',IntegerType::class,['label'=>'property.postalCode'])
            ->add('lat',HiddenType::class,['label'=>'property.latitude'])
            ->add('lng',HiddenType::class,['label'=>'property.longitude'])
            ->add('sold',CheckboxType::class,[
                'label'=>'property.sold',
                'help'=>'property.sold.help',
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
