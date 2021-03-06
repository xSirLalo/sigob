<?php

declare(strict_types=1);

namespace Catastro\Form;

use Laminas\InputFilter\InputFilter;
use Laminas\Validator;
use Laminas\Filter;
use Laminas\Filter\FilterChain;
use Laminas\Form\Element;
use Laminas\Form\Form;

class ContribuyenteForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('contribuyente_form');
        $this->setAttribute('method', 'post');
        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements()
    {
        $this->add([
            'type' => Element\Text::class,
            'name' => 'nombre',
            'options' => [
                'label' => 'Nombre',
            ],
            'attributes' => [
                // 'required' => true,
                'class' => 'form-control',
                'title' => 'Nombre',
                'placeholder' => 'Nombre',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'apellido_paterno',
            'options' => [
                'label' => 'Apellido Paterno',
            ],
            'attributes' => [
                // 'required' => true,
                'class' => 'form-control',
                'placeholder' => 'Apellido Paterno',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'apellido_materno',
            'options' => [
                'label' => 'Apellido Materno',
            ],
            'attributes' => [
                // 'required' => true,
                'class' => 'form-control',
                'placeholder' => 'Apellido Materno',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'rfc',
            'options' => [
                'label' => 'R.F.C.',
            ],
            'attributes' => [
                // 'required' => true,
                'class' => 'form-control',
                'placeholder' => 'R.F.C.',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'curp',
            'options' => [
                'label' => 'C.U.R.P.',
            ],
            'attributes' => [
                // 'required' => true,
                'class' => 'form-control',
                'placeholder' => 'C.U.R.P',
            ]
        ]);

        $this->add([
            'type' => Element\Number::class,
            'name' => 'genero',
            'options' => [
                'label' => 'Genero',
            ],
            'attributes' => [
                // 'required' => true,
                'class' => 'form-control',
                'placeholder' => 'Genero',
            ]
        ]);

        $this->add([
            'type' => Element\Csrf::class,
            'name' => 'csrf',
            'options' => [
                'csrf_options' => [
                    'timeout' => 600,
                ],
            ],
        ]);

        $this->add([
            'type' => Element\Submit::class,
            'name' => 'btnGuardar',
            'attributes' => [
                'id' => 'btnGuardar',
                'value' => 'Guardar',
                'class' => 'btn btn-primary'
            ]
        ]);
    }

    private function addInputFilter()
    {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);
        $inputFilter->add([
            'name' => 'nombre',
            'required' => true,
            'filters' => [
                [ 	// Remueve las etiquetas HTML y PHP
                    'name' => Filter\StripTags::class,
                    'options'=>[
                        'tagsallowed'=>['p']
                    ],
                    'priority'=>FilterChain::DEFAULT_PRIORITY
                ],
                [	// Remueve los espacios en blanco
                    'name' => Filter\StringTrim::class,
                    'options'=>[
                        'charlist'=>"\r\n\t "
                    ],
                    'priority'=>FilterChain::DEFAULT_PRIORITY
                ],
                [	// Remueve los saltos de Linea
                    'name' => Filter\StripNewlines::class,
                    'priority'=>FilterChain::DEFAULT_PRIORITY
                ],
            ],
            'validators' => [
                [
                    'name' => Validator\NotEmpty::class
                ],
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'min' => 3,
                        'max' => 30,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'apellido_paterno',
            'required' => true,
            'filters' => [
                [	// Remueve las etiquetas HTML y PHP
                    'name' => Filter\StripTags::class,
                    'options'=>[
                        'tagsallowed'=>['p']
                    ],
                    'priority'=>FilterChain::DEFAULT_PRIORITY
                ],
                [	// Remueve los espacios en blanco
                    'name' => Filter\StringTrim::class,
                    'options'=>[
                        'charlist'=>"\r\n\t "
                    ],
                    'priority'=>FilterChain::DEFAULT_PRIORITY
                ],
                [	// Remueve los saltos de Linea
                    'name' => Filter\StripNewlines::class,
                    'priority'=>FilterChain::DEFAULT_PRIORITY
                ],
            ],
            'validators' => [
                [
                    'name' => Validator\NotEmpty::class
                ],
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'min' => 3,
                        'max' => 30,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'apellido_materno',
            'required' => true,
            'filters' => [
                [	// Remueve las etiquetas HTML y PHP
                    'name' => Filter\StripTags::class,
                    'options'=>[
                        'tagsallowed'=>['p']
                    ],
                    'priority'=>FilterChain::DEFAULT_PRIORITY
                ],
                [	// Remueve los espacios en blanco
                    'name' => Filter\StringTrim::class,
                    'options'=>[
                        'charlist'=>"\r\n\t "
                    ],
                    'priority'=>FilterChain::DEFAULT_PRIORITY
                ],
                [	// Remueve los saltos de Linea
                    'name' => Filter\StripNewlines::class,
                    'priority'=>FilterChain::DEFAULT_PRIORITY
                ],
            ],
            'validators' => [
                [
                    'name' => Validator\NotEmpty::class
                ],
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'min' => 3,
                        'max' => 30,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'rfc',
            'required' => true,
            'filters' => [
                [	// Remueve las etiquetas HTML y PHP
                    'name' => Filter\StripTags::class,
                    'options'=>[
                        'tagsallowed'=>['p']
                    ],
                    'priority'=>FilterChain::DEFAULT_PRIORITY
                ],
                [	// Remueve los espacios en blanco
                    'name' => Filter\StringTrim::class,
                    'options'=>[
                        'charlist'=>"\r\n\t "
                    ],
                    'priority'=>FilterChain::DEFAULT_PRIORITY
                ],
                [	// Remueve los saltos de Linea
                    'name' => Filter\StripNewlines::class,
                    'priority'=>FilterChain::DEFAULT_PRIORITY
                ],
            ],
            'validators' => [
                [
                    'name' => Validator\NotEmpty::class
                ],
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'min' => 12,
                        'max' => 13,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'curp',
            'required' => true,
            'filters' => [
                [	// Remueve las etiquetas HTML y PHP
                    'name' => Filter\StripTags::class,
                    'options'=>[
                        'tagsallowed'=>['p']
                    ],
                    'priority'=>FilterChain::DEFAULT_PRIORITY
                ],
                [	// Remueve los espacios en blanco
                    'name' => Filter\StringTrim::class,
                    'options'=>[
                        'charlist'=>"\r\n\t "
                    ],
                    'priority'=>FilterChain::DEFAULT_PRIORITY
                ],
                [	// Remueve los saltos de Linea
                    'name' => Filter\StripNewlines::class,
                    'priority'=>FilterChain::DEFAULT_PRIORITY
                ],
            ],
            'validators' => [
                [
                    'name' => Validator\NotEmpty::class
                ],
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'min' => 18,
                        'max' => 18,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'csrf',
            'required' => true,
            'filters' => [
                [	// Remueve las etiquetas HTML y PHP
                    'name' => Filter\StripTags::class
                ],
                [	// Remueve los espacios en blanco
                    'name' => Filter\StringTrim::class
                ],
            ],
            'validators' => [
                [
                    'name' => Validator\NotEmpty::class],
                [
                    'name' => Validator\Csrf::class,
                    'options' => [
                        'messages' => [
                            Validator\Csrf::NOT_SAME => 'Oops! Rellene el formulario nuevamente y vuelve a intentarlo.',
                        ],
                    ],
                ],
            ],
        ]);
    }
}
