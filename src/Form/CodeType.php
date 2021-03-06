<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Class CodeType
 * @package App\Form
 */
class CodeType extends AbstractType
{
    /**
     * Form validator
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numberOfCodes', NumberType::class, [
                'constraints' => new Range(array('min' => 1))])
            ->add('lengthOfCodes', NumberType::class, [
                'constraints' => new Range(array('min' => 2))])
            ->add('generate', SubmitType::class)
            ->getForm();
        ;
    }

}