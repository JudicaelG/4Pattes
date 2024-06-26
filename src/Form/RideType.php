<?php

namespace App\Form;

use App\Entity\Participant;
use App\Entity\Ride;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('location', null, [
                'label' => 'Ville'
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'block w-full px-2 py-2 rounded-lg bg-white shadow-lg text-gray-700 
                    focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none']
            ])
            ->add('save', SubmitType::class, ['label' => 'Créer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ride::class,
        ]);
    }
}
