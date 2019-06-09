<?php

namespace App\Form;

use App\Entity\Booking;
use App\Form\DataTransformer\FrenchDateToDateTimeTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    private $transformer;

    public function __construct(FrenchDateToDateTimeTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', TextType::class, [
                'label' => "Date d'arrivée",
                'attr' => [
                    'placeholder' => "La date à laquelle vous comptez arriver"
                ]
            ])
            ->add('endDate', TextType::class, [
                'label' => "Date de départ",
                'attr' => [
                    'placeholder' => "La date à laquelle vous quittez les lieux"
                ]
            ])
            ->add('comment', TextareaType::class, [
                'label' => "Vous avez un commentaire ?",
                'required' => false,
                'attr' => [
                    'placeholder' => "Si vous avez un commentaire..."
                ]
            ])
        ;

        $builder->get('startDate')->addModelTransformer($this->transformer);
        $builder->get('endDate')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
