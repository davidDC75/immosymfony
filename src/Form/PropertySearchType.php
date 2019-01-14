<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\PropertySearch;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PropertySearchType extends AbstractType
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
            ->add('minSurface',IntegerType::class,[
                'required'=>false,
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'property.index.search.minSurface'
                ]
            ])
            ->add('maxPrice',IntegerType::class,[
                'required'=>false,
                'label'=>false,
                'attr'=>[
                    'placeholder'=>'property.index.search.maxPrice'
                ]
            ])
            ->add('options',EntityType::class,[
                'required'=>false,
                'label'=>false,
                'class'=>Option::class,
                'choice_label'=>'name',
                'multiple'=>'true'
            ])
            ->add('address',TextType::class,[
                'label' => false,
                'required' => false
            ])
            ->add('distance',ChoiceType::class,[
                'label' => false,
                'required' => false,
                'choices' => [
                    'property.index.search.distance.10km' => 10,
                    'property.index.search.distance.1000km' => 1000
                ],
                'data' => 10
            ])
            ->add('lat',HiddenType::class)
            ->add('lng',HiddenType::class);

            // ->add('submit',SubmitType::class,[
            //     'label'=>'submitLabel'
            // ]);
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
            'data_class' => PropertySearch::class,
            'translation_domain' => 'messages',
            'method'=>'get',
            'csrf_protection'=>false
        ]);
    }

    /**
     * getBlockPrefix
     *
     * @return string
     */
    public function getBlockPrefix()
    {
        return '';
    }
}
