<?php

namespace App\Form;

use App\Entity\Hall;
use App\Entity\Piece;
use App\Repository\PieceRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HallType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Get the current Hall object from the 'data' option
        $hall = $options['data'] ?? null;

        if (!$hall || !$hall->getCreator()) {
            throw new \LogicException('Hall or its creator is not set. Ensure you pass the proper data to the form.');
        }

        // Get the creator (Member) of the hall
        $member = $hall->getCreator();

        $builder
            ->add('description')
            ->add('published')
            ->add('creator', null, [
                'disabled' => true,
            ])
            ->add('pieces', EntityType::class, [
                'class' => Piece::class,
                'query_builder' => function (PieceRepository $pieceRepository) use ($member) {
                    return $pieceRepository->createQueryBuilder('p')
                        ->leftJoin('p.arsenal', 'a')
                        ->leftJoin('a.member', 'm')
                        ->andWhere('m.id = :memberId')
                        ->setParameter('memberId', $member->getId());
                },
                'choice_label' => 'description', // Adjust to show a meaningful label
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false, // Needed for ManyToMany relationships
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hall::class,
        ]);
    }
}
