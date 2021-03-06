<?php

declare(strict_types=1);

namespace Catastro\Form;

use Laminas\Form\Element;
use Laminas\Form\Form;

class EliminarForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('eliminar_form');
        $this->setAttribute('method', 'post');

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
            'name' => 'delete',
            'attributes' => [
                'class' => 'btn btn-danger'
            ]
        ]);
    }
}
