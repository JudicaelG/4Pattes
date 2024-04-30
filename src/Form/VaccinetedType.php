<?php

namespace App\Form;

use App\Entity\Vaccinated;
use App\Entity\Vaccine;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class VaccinetedType extends AbstractType
{

    public function __construct(private EntityManagerInterface $entityManager,){}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $vaccines = $this->entityManager->getrepository(Vaccine::class)->findAll();

        foreach($vaccines as $vaccin ){
            $builder
                ->add('date_'.$vaccin->getName(), DateType::class, [
                    'label' => 'Date du vaccin '.$vaccin->getName(),
                    'row_attr' => ['class' => 'hidden', 'id' => 'date_'.$vaccin->getName()],
                    'mapped' => false,
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vaccinated::class,
        ]);
    }
}
