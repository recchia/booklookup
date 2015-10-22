<?php
/**
 * Created by PhpStorm.
 * User: recchia
 * Date: 22/10/15
 * Time: 04:30 PM
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isbn', 'text', [
                'label' => 'ISBN',
                'constraints' => new Constraints\NotBlank([
                    'message' => 'El campo ISBN es obligatorio'
                ])
            ])
            ->add('api', 'choice')
            ->add('search', 'submit', ['label' => 'Buscar'])
        ;
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'search_form';
    }
}