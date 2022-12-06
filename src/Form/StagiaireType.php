<?php

namespace App\Form;

use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StagiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class, ['label' => 'Prénom :'])
            ->add('nom', TextType::class, ['label' => 'Nom :'])
            ->add('dateNaissance', DateType::class, ['label' => 'Date de Naissance :','widget' => 'single_text'])
            ->add('email', EmailType::class, ['label' => 'Adresse E-mail :'])
            ->add('telephone', TextType::class, ['label' => 'Téléphone :']) 
            ->add('adresse', TextType::class, ['label' => 'Adresse :'])
            ->add('cp', TextType::class, ['label' => 'Code Postal :'])
            ->add('ville', TextType::class, ['label' => 'Ville :'])
            ->add('sexe', TextType::class, ['label' => 'Sexe :'])
            ->add('submit', SubmitType::class, ['label' => 'Valider'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
        ]);
    }
}
