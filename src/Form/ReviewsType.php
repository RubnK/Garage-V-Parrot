<?php

namespace App\Form;

use App\Entity\Reviews;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ReviewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('comment')
            ->add('note', ChoiceType::class, [
                'choices' => [
                    '⭐⭐⭐⭐⭐' => 5,
                    '⭐⭐⭐⭐' => 4,
                    '⭐⭐⭐' => 3,
                    '⭐⭐' => 2,
                    '⭐' => 1,
                ],
            ])
            ->add('approved')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reviews::class,
        ]);
    }
}
