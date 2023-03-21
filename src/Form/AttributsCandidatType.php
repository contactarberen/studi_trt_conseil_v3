<?php

namespace App\Form;

use App\Entity\AttributsCandidat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AttributsCandidatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('userId')
            ->add('nom')
            ->add('prenom')
            ->add("image", FileType::class, [
                "label" => "L'image",
                'mapped' => false,
                "required" => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            "image/gif",
                            "image/png",
                            "image/svg+xml",
                            "image/jpg",
                            "image/webp"
                        ],
                        'mimeTypesMessage' => 'Veuillez proposer une image valide.',
                    ])
                ],
            ])
            
            ->add('cv', FileType::class, [
                'label' => 'Cv (fichier pdf)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Merci de télécharger un pdf valide',
                    ])
                ],
            ])
            //->add('userId')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AttributsCandidat::class,
        ]);
    }
}
