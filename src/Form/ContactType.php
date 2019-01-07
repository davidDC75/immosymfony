<?php

namespace App\Form;

use App\Entity\Contact;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
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
            ->add('firstname', TextType::class, [
                'required'=> true,
                'label'=>'contact.firstname',
            ])
            ->add('lastname', TextType::class, [
                'required'=> true,
                'label'=>'contact.lastname',
            ])
            ->add('phone', TextType::class, [
                'required'=> true,
                'label'=>'contact.phone',
            ])
            ->add('email', EmailType::class, [
                'required'=> true,
                'label'=>'contact.email',
            ])
            ->add('message', TextareaType::class, [
                'required'=> true,
                'label'=>'contact.message',
            ]);
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
            'data_class' => Contact::class,
            'translation_domain' => 'forms',
        ]);
    }

}
