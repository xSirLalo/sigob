<?php

declare(strict_types=1);

namespace Catastro\Form;

use Laminas\InputFilter\InputFilter;
use Laminas\Validator;
use Laminas\Filter;
use Laminas\Filter\FilterChain;
use Laminas\Form\Element;
use Laminas\Form\Form;

class PruebaForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('prueba_form');
        $this->setAttribute('method', 'post');
        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements()
    {
        $this->add([
            'type' => Element\Text::class,
            'name' => 'input1',
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Agregar dato1',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'input2',
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Agregar dato2',
            ]
        ]);

        $this->add([
            'type' => Element\Submit::class,
            'name' => 'btnGuardar',
            'attributes' => [
                'id' => 'btnGuardar',
                'value' => 'Guardar',
                'class' => 'btn btn-primary btn-ok'
            ]
        ]);
    }

    private function addInputFilter()
    {
    }
}
