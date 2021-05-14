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

class BiblitoecaCategoriaForm extends Form
{
    /**
     * Constructor.
     */
    public function __construct($name = null)
    {
        parent::__construct('bilioteca_categoria_form');
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
                'required' => false,
                'class' => 'form-control',
                'placeholder' => 'Nombre',
            ]
        ]);

        $this->add([
            'type' => Element\Number::class,
            'name' => 'input1',
            'attributes' => [
                'hidden'=> true,
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
            'type' => Element\Button::class,
            'name' => 'btnCerrar',
            'options' => [
                'label' => 'Cerrar'
            ],
            'attributes' => [
                'class' => 'btn btn-secondary',
                'data-dismiss' => 'modal'
            ]
        ]);

        $this->add([
            'type' => Element\Submit::class,
            'name' => 'btnGuardar',
            'attributes' => [
                'onClick' => 'guardar();',
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


        $inputFilter->add(
            [
                'name' => 'input1',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ]
        );

        $inputFilter->add(
            [
                'name' => 'nombre',
                'required' => true,
                'filters' => [],
                'validators' => [],
            ]
        );
    }
}
