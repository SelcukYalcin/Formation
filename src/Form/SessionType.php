<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Formateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('intitule', TextType::class, ['label' => 'Intitulé :'])
            ->add('dateDebut', DateType::class, ['label' => 'Date de Début :','widget' => 'single_text'])
            ->add('dateFin', DateType::class, ['label' => 'Date de Fin :','widget' => 'single_text'])
            ->add('nbPlace', NumberType::class, ['label' => 'Nombre de Place(s) :'])
            ->add('formateur', EntityType::class, ['class' => Formateur::class, 'choice_label' =>'identite'])
            ->add('submit', SubmitType::class, ['label' => 'Valider'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
