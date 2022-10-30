<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array( 
              'attr' => array(
                'class' => 'form-control')
            ))
            ->add('description', TextType::class, array( 
              'attr' => array(
                'class' => 'form-control')
            ))
            ->add('prix', IntegerType::class, array( 
              'attr' => array(
                'class' => 'form-control')
            ))
            ->add('stock', IntegerType::class, array(
              'attr' => array(
                'class' => 'form-control mb-3')
            ))
            ->add('photo', FileType::class, [
                'label' => 'LabelImage',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                'attr' => array('class' => 'form-control'),

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'ErreurImage',
                    ])
                ],
            ])
            ->add('Sauvegarder', SubmitType::class, array( 
              'attr' => array(
                'class' => 'btn btn-primary mt-3')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
