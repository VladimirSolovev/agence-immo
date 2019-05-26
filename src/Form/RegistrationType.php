<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    /**
     * @param string $label
     * @param string $placeholder
     * @param array $options
     * @return array
     */
    private function setConfiguration(string $label, string $placeholder, $options = []) : array
    {
        return array_merge([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder ]
        ], $options);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, $this->setConfiguration('Prénom', 'Votre prénom...'))
            ->add('lastName', TextType::class, $this->setConfiguration('Nom', 'Votre nom...'))
            ->add('email', EmailType::class, $this->setConfiguration('Email', 'Votre email...'))
            ->add('password', PasswordType::class, $this->setConfiguration('Mot de passe', 'Choisissez un bon mot de passe'))
            ->add('passwordConfirm', PasswordType::class, $this->setConfiguration('Confirmation de mot de passe', 'Veuillez confirmer votre mot de passe'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
