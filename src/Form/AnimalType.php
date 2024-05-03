<?php

namespace App\Form;

use App\Entity\Animals;
use App\Entity\Breed;
use App\Entity\Vaccinated;
use App\Entity\Vaccine;
use App\Repository\VaccineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {   
        /*$entityMananger = $options['entityManager'];
        
        $vaccines = $entityMananger->getrepository(Vaccine::class)->findAll();


        foreach($vaccines as $vaccin ){
            $builder
                ->add('date_'.$vaccin->getName(), DateType::class, [
                    'label' => 'Date du vaccin '.$vaccin->getName(),
                    'row_attr' => ['class' => 'hidden', 'id' => 'date_'.$vaccin->getName()],
                    'mapped' => false,
                ]);
        }
*/
        $builder
            ->add('name', TextType::class, ['label'=>'Nom'])
            ->add('birthday', DateType::class, [
                'label' => 'Anniversaire'
            ])
            ->add('breed_id', EntityType::class, [
                'class' => Breed::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('b')
                        ->orderBy('b.name', 'ASC');
                },
                'group_by' => 'type',
                'choice_label' => 'name',
                'label' => 'Race'
            ])
            ->add('weight', null, ['label' => 'Poids'])
            ->add('profilePhoto', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Photo de profil',
                'constraints' => new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => ['image/png', 'image/jpeg'],
                    'mimeTypesMessage' => 'Vous ne pouvez upload que des images de type jpg ou png',
                ]),
            ])
            ->add('vaccine_id', EntityType::class,[
                'class' => Vaccine::class,
                'query_builder' => function(EntityRepository $er): QueryBuilder{
                    return $er->createQueryBuilder('v')
                    ->orderBy('v.name', 'ASC');
                },
                'mapped' => false,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'name',
                'choice_value' => 'id',
                'choice_name' => 'name',
                'choice_attr' => function () { return ['onclick' => 'addingDateInput(this)'];},
                'label' => 'Vaccins',
            ])
            ->add('vaccine_date', VaccinetedType::class, [
                'label' => 'Date des vaccins',
                'required' => false,
                'mapped' => false,
            ])
            ->add('save', SubmitType::class, ['label' => 'Ajouter'])
        ;

        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animals::class,
            'entityManager' => null,
        ]);
    }
}
