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
            ->add('next_recall', DateType::class, [
            ])
            ->add('last_date_injection', DateType::class, [
            ])
            ->add('vaccine_id', EntityType::class, [
                'class' => Vaccine::class,
                'query_builder' => function(EntityRepository $er): QueryBuilder{
                    return $er->createQueryBuilder('v')
                    ->orderBy('v.name', 'ASC');
                },
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'name',
                'choice_value' => 'id',
                'choice_name' => 'name',
                'label' => 'Vaccins',
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
