<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\Property;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class PropertyTypes extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('floor')
            ->add('price')
            ->add('heat', ChoiceType::class, [
                'choices' => $this->getChoices()
            ])
            ->add('options', EntityType::class, [
                'class' => Option::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false,
            ])
            ->add('filename', FileType::class, [
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',
                ], 
                'constraints' => [
                    new Image([
                        'mimeTypes' => ['image/png','image/jpeg', 'image/webp'],
                        'mimeTypesMessage' => 'Seul les images au format PNG, JPG et WEBP sont accépté.',
                        'maxSize' => '2M',
                        'maxSizeMessage' => 'Le fichier {{ name }} est trop volumineux.'
                    ])
                ]
            ])
            ->add('city')
            ->add('address')
            ->add('postal_code')
            ->add('sold')
            ->add('text')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'translation_domain' => 'forms'
        ]);
    }

    private function getChoices()
    {
        $choices = Property::HEAT;
        $output = [];
        foreach ($choices as $key => $value) {
            $output[$value] = $key;
        }
        return $output;
    }
}
