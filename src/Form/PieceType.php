<?php

namespace App\Form;

use App\Entity\Arsenal;
use App\Entity\Hall;
use App\Entity\Piece;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PieceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('type')
            ->add('acquired', null, [
                'widget' => 'single_text',
            ])
            ->add('era')
            ->add('arsenal', EntityType::class, [
                'class' => Arsenal::class,
                'choice_label' => 'id',
            ])
            ->add('halls', EntityType::class, [
                'class' => Hall::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Piece::class,
        ]);
    }
}
