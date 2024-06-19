<?php

namespace App\Form;

use App\Entity\animals;
use App\Entity\Vaccinated;
use App\Entity\Vaccine;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EditVaccineDateAnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('last_date_injection', DateType::class, [
                'label' => 'Date de la dernière injection',
                'required' => false,
                'attr' => ['class' => 'block w-full px-2 py-2 rounded-lg bg-white shadow-lg text-gray-700 
                focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vaccinated::class,
        ]);
    }
}
