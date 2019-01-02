<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('floor')
            ->add('price',MoneyType::class, [
                'currency'=>'EUR',
                'scale'=>0
            ])
            ->add('heat',ChoiceType::class,[
                'choices' => $this->getHeatChoices(),
                'choice_translation_domain' => 'forms'
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

    private function getHeatChoices()
    {
        return [
            "heattype.electric" => 0,
            "heattype.gas" => 1,
            "heattype.fireplace" => 2
        ];
    }
}
