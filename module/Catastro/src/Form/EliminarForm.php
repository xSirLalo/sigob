<?php

declare(strict_types=1);

namespace Catastro\Form;

use Laminas\InputFilter\InputFilter;
use Laminas\Validator;
use Laminas\I18n;
use Laminas\Filter;
use Laminas\Filter\FilterChain;
use Laminas\Form\Element;
use Laminas\Form\Form;

class EliminarForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('eliminar_form');
        $this->setAttribute('method', 'post');
        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements()
    {
        $this->add([
            'type' => Element\Number::class,
            'name' => 'input1',
            'attributes' => [
                // 'hidden'=> true,
                'id' => 'input1',
                'style' => 'color:red;'
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
            'name' => 'btnEliminar',
            'options' => ['label' => 'Login'],
            'attributes' => [
                'value' => 'Confirmar',
                'class' => 'btn btn-danger btn-ok'
            ]
        ]);
    }

    private function addInputFilter()
    {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

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
