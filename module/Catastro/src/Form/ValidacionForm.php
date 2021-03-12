<?php

declare(strict_types=1);

namespace Catastro\Form;

use Laminas\Form\Element;
use Laminas\Form\Form;

class ValidacionForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('enviar_velidacion');
        $this->setAttribute('method', 'post');
        // $this->setAttributes(['style' => "display: none"]);

        $this->add([
            'type' => Element\Hidden::class,
            'name' => 'padron_id',
            'attributes' => [
                'required' => true,
            ]
        ]);


        $this->add([
            'type' => Element\Hidden::class,
            'name' => 'status',
            'attributes' => [
                'required' => true,
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
                'name' => 'confirmar',
                'options' => [
                    'label' => '<i class="feather mr-2 icon-check-circle"></i> Confirmar',
                    'label_options' => [
                        'disable_html_escape' => true,
                    ],
                ],
                'attributes' => [
                    'type'  => 'submit',
                    'class' => 'btn btn-success'
                ]
        ]);
    }
}
