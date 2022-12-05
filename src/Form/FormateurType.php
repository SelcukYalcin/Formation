<?php

namespace App\Form;

use App\Entity\Formateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FormateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('prenom', TextType::class)
        ->add('nom', TextType::class)
        ->add('dateNaissance', DateType::class, ['label' => 'Date de naissance','widget' => 'single_text'])
        ->add('email', EmailType::class, ['label' => 'Adresse e-mail'])
        ->add('telephone', TextType::class, ['label' => 'Téléphone']) 
        ->add('adresse', TextType::class)
        ->add('cp', TextType::class)
        ->add('ville', TextType::class)
        ->add('sexe', TextType::class)
        ->add('submit', SubmitType::class, ['label' => 'Valider'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formateur::class,
        ]);
    }
}
