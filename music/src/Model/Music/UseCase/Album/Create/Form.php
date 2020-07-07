<?php

declare(strict_types=1);

namespace App\Model\Music\UseCase\Album\Create;

use App\Model\Music\Entity\Album\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('releaseYear', IntegerType::class)
            ->add('coverPhoto', FileType::class, [
                'required' => false,
                'multiple' => false
            ])
            ->add('description', TextareaType::class)
            ->add('type', ChoiceType::class, [
                'choices' => Type::TYPES
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'data_class' => Command::class
            ])
        ;
    }
}