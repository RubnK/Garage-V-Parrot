<?php

namespace App\Form;

use App\Entity\Occasions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OccasionsAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('photo', FileType::class)
            ->add('description')
            ->add('price')
            ->add('miseCirculation')
            ->add('km')
            ->add('boite', ChoiceType::class, [
                'choices'  => [
                    'Automatique' => 'Automatique',
                    'Manuelle' => 'Manuelle',
                ],
            ])
            ->add('energy', ChoiceType::class, [
                'choices'  => [
                    'Essence' => 'Essence',
                    'Électrique' => 'Électrique',
                    'Diesel' => 'Diesel',
                    'Hybride' => 'Hybride',
                ],
            ])
            ->add('nbPortes')
            ->add('puissance')
            ->add('color')
            ->add('critair', ChoiceType::class, [
                'choices'  => [
                    '0' => '0',
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                ],
            ])
            ->add('post_date', null, [
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Occasions::class,
        ]);
    }
}
