<?php

declare(strict_types=1);

namespace Catastro\Form;

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

        $this->add([
            'type' => Element\Text::class,
            'name' => 'nombre',
            'options' => [
                'label' => 'Nombre',
            ],
            'attributes' => [
                'required' => true,
                'class' => 'form-control',
                'placeholder' => 'Nombre',
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
                'value' => 'Guardar',
                'class' => 'btn btn-primary'
            ]
        ]);
    }
}
