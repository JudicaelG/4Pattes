<?php

namespace App\Form;

use App\Entity\Veterinary;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VeterinaryModifyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du vétérinaire'
            ])
            ->add('adress', TextType::class, [
                'label' => 'Adresse du vétérinaire'
            ])
            ->add('postalCode', IntegerType::class, [
                'label' => 'Code postal du vétérinaire'
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville du vétérinaire'
            ])
            ->add('phone', TelType::class, [
                'label' => 'Téléphone du vétérinaire'
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Veterinary::class,
        ]);
    }
}
