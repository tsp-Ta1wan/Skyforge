<?php

namespace App\Form;

use App\Entity\Hall;
use App\Entity\Member;
use App\Entity\Piece;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HallType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('published')
            ->add('member', EntityType::class, [
                'class' => Member::class,
                'choice_label' => 'id',
            ])
            ->add('pieces', EntityType::class, [
                'class' => Piece::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hall::class,
        ]);
    }
}
