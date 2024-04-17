<?php

namespace App\Form;

use App\Entity\Animals;
use App\Entity\Breed;
use App\Entity\User;
use App\Entity\Vaccinated;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label'=>'Nom'])
            ->add('birthday', null, [
                'widget' => 'single_text',
                'label' => 'Anniversaire',
            ])
            ->add('breed_id', EntityType::class, [
                'class' => Breed::class,
                'choice_label' => 'name',
                'label' => 'Race'
            ])
            ->add('weight', null, ['label' => 'Poids'])
            ->add('profilePhoto', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => ['image/png', 'image/jpeg'],
                    'mimeTypesMessage' => 'Vous ne pouvez upload que des images de type jpg ou png',
                ]),
            ])
            ->add('save', SubmitType::class, ['label' => 'Ajouter'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animals::class,
        ]);
    }
}
