<?php

namespace App\Form;

use App\Entity\Animals;
use App\Entity\Breed;
use App\Entity\Vaccinated;
use App\Entity\Vaccine;
use App\Entity\Veterinary;
use App\Enum\Sexe;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalCatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {   
        $builder
            ->add('name', TextType::class, ['label'=>'Nom'])
            ->add('birthday', DateType::class, [
                'label' => 'Anniversaire'
            ])
            ->add('breed_id', EntityType::class, [
                'class' => Breed::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('b')
                        ->where('b.type=\'cat\'')
                        ->orderBy('b.name', 'ASC');                        
                },
                'choice_label' => 'name',
                'label' => 'Race',
                'attr' => ['class' => 'mt-1 w-full']
            ])
            ->add('weight', null, ['label' => 'Poids'])
            ->add('sexe', ChoiceType::class, [
                'label' => 'Sexe',
                'choices' => [
                    'Male' => 'Male',
                    'Femelle' => 'Femelle'
                ]
            ])
            ->add('sterilized', ChoiceType::class, [
                'required' => true,
                'label' => 'Sterelisé',
                'choices' => [
                    'Oui' => true,
                    'Non' => false
                ]
            ])
            ->add('profilePhoto', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Photo de profil',
                'constraints' => new File([
                    'maxSize' => '9M',
                    'mimeTypes' => ['image/png', 'image/jpeg'],
                    'mimeTypesMessage' => 'Vous ne pouvez upload que des images de type jpg ou png',
                ]),
            ])
            ->add('vaccinateds', CollectionType::class,[
                'entry_type' => EditVaccineDateAnimalType::class
            ])
            ->add('save', SubmitType::class, ['label' => 'Ajouter'])
        ;

        if($options['veterinary'] == null){
            $builder
            ->add('add_veterinary', VeterinaryType::class,[
                'mapped' => false,
                'label' => 'Ajouter un vétérinaire'
            ]);
        }else{
            $builder
            ->add('veterinary', EntityType::class, [
                'class' => Veterinary::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('v')
                        ->orderBy('v.name', 'ASC');   
                },
                'choice_label' => 'name',
                'label' => 'Ajouter un vétérinaire',
                
            ]);
        }

        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animals::class,
            'veterinary' => Veterinary::class,
        ]);
    }
}
