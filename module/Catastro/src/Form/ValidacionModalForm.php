<?php

declare(strict_types=1);

namespace Catastro\Form;

use Laminas\Form\Element;
use Laminas\Form\Form;

class ValidacionModalForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('validacion_form_modal');
        $this->setAttribute('method', 'post');


        $this->add([
            'type' => Element\Text::class,
            'name' => 'terreno',
            'options' => [
                'label' => 'Sup. M2 Terreno',
            ],
            'attributes' => [
                // 'required' => true,
                'class' => 'form-control',
                "oninput"=> "Calcular()",
                "onkeypress"=> "return filterFloat(event,this);",
                'id' =>'terreno',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'sup_m',
            'options' => [
                'label' => 'Sup.M2 Construcion',
            ],
            'attributes' => [
                // 'required' => true,
                'class' => 'form-control',
                "oninput"=> "Calcular()",
                "onkeypress"=> "return filterFloat(event,this);",
                'id' =>'sup_m',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'v_terreno',
            'options' => [
                'label' => 'Valor del Terreno',
            ],
            'attributes' => [
                // 'required' => true,
                'readonly' => true,
                'class' => 'form-control',
                'id' =>'v_terreno',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'v_c',
            'options' => [
                'label' => 'Valor de la construccion',
            ],
            'attributes' => [
                // 'required' => true,
                'readonly' => true,
                'class' => 'form-control',
                'data-toggle' => 'tooltip',
                'id' =>'v_c',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'a_total',
            'options' => [
                'label' => 'Avaluo Total',
            ],
            'attributes' => [
                // 'required' => true,
                'readonly' => true,
                'class' => 'form-control',
                'id' =>'a_total',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'ejercicio_f',
            'options' => [
                'label' => 'Ejercicio Fiscal',
            ],
            'attributes' => [
                // 'required' => true,
                'class' => 'form-control',
                'data-toggle' => 'tooltip',
                'onkeypress'=>'return validaNumericos(event)',
                'id' =>'ejercicio_f',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'pago_a',
            'options' => [
                'label' => 'Pago aportacion',
            ],
            'attributes' => [
                'readonly' => true,
                'class' => 'form-control',
                'id' =>'pago_a',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'id_predio',
            'options' => [
                'label' => 'id_predio',
            ],
            'attributes' => [
                'readonly' => true,
                'hidden'=> true,
                'class' => 'form-control',
                'id' => 'id_predio',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'idcontribuyente',
            'options' => [
                'label' => 'idcontribuyente',
            ],
            'attributes' => [
                'readonly' => true,
                'hidden'=> true,
                'class' => 'form-control',
                'id'   => 'idcontribuyente',
            ]
        ]);

        $this->add([
            'type' => Element\Hidden::class,
            'name' => 'cvlCatastral',
            'options' => [
                'label' => 'cvlCatastral',
            ],
            'attributes' => [
                'readonly' => true,
                'hidden'=> true,
                'class' => 'form-control',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'status',
            'options' => [
                'label' => 'status',
            ],
            'attributes' => [
                'readonly' => true,
                'class' => 'form-control',
                'value' => 3,
                'hidden'=> true,
            ]
        ]);

        $this->add([
            'type' => Element\Date::class,
            'name' => 'vig',
            'options' => [
            'label' => 'Vigencia',
            'format' => 'Y-m-d',
        ],
        'attributes' => [
            'class' => 'form-control',
            'min' => '2021-01-01',
            'max' => '2030-01-01',
            'step' => '1', // days; default step interval is 1 day
            'id' =>'vig',
        ],
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
                'value' => 'Guardar1',
                'class' => 'btn btn-success',
                //'id' =>'guardar',
                'id' => 'btnGuardar',
            ]
        ]);
        // $this->add([
        //     'type' => Element\Submit::class,
        //     'name' => 'btnGuardar',
        //     'attributes' => [
        //         'id' => 'btnGuardar',
        //         'value' => 'Guardar1',
        //         'class' => 'btn btn-primary'
        //     ]
        // ]);
    }
}
