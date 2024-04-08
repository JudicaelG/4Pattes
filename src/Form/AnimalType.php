<?php

namespace App\Form;

use App\Entity\Animals;
use App\Entity\Breed;
use App\Entity\User;
use App\Entity\Vaccinated;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('birthday', null, [
                'widget' => 'single_text',
            ])
            ->add('breed_id', EntityType::class, [
                'class' => Breed::class,
                'choice_label' => 'name',
            ])
            ->add('save', SubmitType::class, ['label' => 'Add animal'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animals::class,
        ]);
    }
}
