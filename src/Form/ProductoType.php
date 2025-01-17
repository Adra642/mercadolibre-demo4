<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace App\Form;

use App\Entity\Producto;
use App\Entity\Vendedor;
use App\Entity\ProductoCategoria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use CarlosChininin\AttachFile\Form\AttachFileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('precio')
            ->add('descuento')
            ->add('categoria', EntityType::class, [
                'class' => ProductoCategoria::class,
                'choice_label' => 'nombre',
            ])
            ->add('vendedor', EntityType::class, [
                'class' => Vendedor::class,
                'choice_label' => 'nombre',
                'required' => true,
            ])
            ->add('foto', AttachFileType::class, ["required" => false])
            ->add('isActive');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
        ]);
    }
}
