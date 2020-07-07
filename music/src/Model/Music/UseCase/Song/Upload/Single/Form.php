<?php

declare(strict_types=1);

namespace App\Model\Music\UseCase\Song\Upload\Single;

use App\ReadModel\Music\Genre\GenreFetcher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Form extends AbstractType
{
    private GenreFetcher $genres;

    /**
     * Form constructor.
     * @param GenreFetcher $genres
     */
    public function __construct(GenreFetcher $genres)
    {
        $this->genres = $genres;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('genre', ChoiceType::class, [
                    'choices' => array_flip($this->genres->array())
                ]
            )
            ->add('name', TextType::class)
            ->add('coverPhoto', FileType::class, [
                'required' => false,
                'multiple' => false
            ])
            ->add('file', FileType::class, [
                'required' => true,
                'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => Command::class
            ])
        ;
    }
}