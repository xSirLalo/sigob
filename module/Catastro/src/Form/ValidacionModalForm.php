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
                'label' => 'SUP.M2 TERRENO',
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
            'name' => 'valor_m2_zona',
            'options' => [
                'label' => 'VALOR M2 DE ZONA',
            ],
            'attributes' => [
                // 'readonly' => true,
                'class' => 'form-control',
                "onkeypress"=> "return filterFloat(event,this);",
                'oninput'=> 'Calcular()',
                'id' =>'valor_zona',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'valor',
            'options' => [
                'label' => 'VALOR M2 CONSTRUCCION',
            ],
            'attributes' => [
                'readonly' => true,
                "onkeypress"=> "return filterFloat(event,this);",
                'class' => 'form-control',
                'id' =>'valor',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'sup_m',
            'options' => [
                'label' => 'SUP.M2 CONSTRUCCIÓN',
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
                'label' => 'VALOR DEL TERRENO',
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
                'label' => 'VALOR DE LA CONSTRUCCION',
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
                'label' => 'AVALUO',
            ],
            'attributes' => [
                // 'required' => true,
                'readonly' => true,
                'class' => 'form-control',
                'id' =>'a_total',
            ]
        ]);

        // $this->add([
        //     'type' => Element\Text::class,
        //     'name' => 'ejercicio_f',
        //     'options' => [
        //         'label' => 'Ejercicio Fiscal',
        //     ],
        //     'attributes' => [
        //         // 'required' => true,
        //         'class' => 'form-control',
        //         'data-toggle' => 'tooltip',
        //         'onkeypress'=>'return validaNumericos(event)',
        //         'id' =>'ejercicio_f',
        //     ]
        // ]);

        $this->add([
			'type' => Element\DateSelect::class,
			'name' => 'ejercicio_fiscal',
			'options' => [
				'label' => 'EJERCICIO FISCAL',
				// 'create_empty_option' => true,
				'min_year' => date('Y')-21,
				'max_year' => date('Y'), # here we want users over the age of 13 only
				'year' => date('Y'),
				'render_delimiters' => false,
				'year_attributes' => [
					'class' => 'custom-select w-30',
                    'id' => 'ejercicio_fiscal',
                    'onchange' => 'CalcularAño()',
                    //'value' => date('Y'),
				],
				'month_attributes' => [
					'class' => 'custom-select w-30',
					'hidden' => true,
				],
				'day_attributes' => [
					'class' => 'custom-select w-30',
					'hidden' => true,
					'id' => 'day',
				],
			],
			'attributes' => [
				'required' => true

			]
		]);

        $this->add([
			'type' => Element\DateSelect::class,
			'name' => 'ejercicio_fiscal_final',
			'options' => [
				'label' => 'EJERCICIO FISCAL FINAL',
				// 'create_empty_option' => true,
				'min_year' => date('Y')-21,
				'max_year' => date('Y'), # here we want users over the age of 13 only
				'year' => date('Y'),
				'render_delimiters' => false,
				'year_attributes' => [
					'class' => 'custom-select w-30',
					'value' => '2021',
                    'id' => 'ejercicio_fiscal_final',
                    'onchange' => 'CalcularAño()',
                    'value' => date('Y'),
				],
				'month_attributes' => [
					'class' => 'custom-select w-30',
					'hidden' => true,
				],
				'day_attributes' => [
					'class' => 'custom-select w-30',
					'hidden' => true,
					'id' => 'day'
				],
			],
			'attributes' => [
				'required' => true
			]
		]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'pago_a',
            'options' => [
                'label' => 'APORTACION',
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
            'name' => 'cvepredio',
            'options' => [
            ],
            'attributes' => [
                'size' => 40,
                'maxlength' => 10,
                'class' => 'form-control',
                'hidden'=> true,
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
            'type' => Element\Text::class,
            'name' => 'parametro',
            'options' => [
            ],
            'attributes' => [
                'required' => true,
                'size' => 40,
                'maxlength' => 10,
                'class' => 'form-control',
                'hidden'=> true,
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'tasa_hidden',
            'attributes' => [
                // 'readonly' => true,
                'class' => 'form-control',
                'hidden' => true,
                'id' =>'tasa_hidden',
            ]
        ]);

        $this->add([
            'type' => Element\Date::class,
            'name' => 'vig',
            'options' => [
            'label' => 'FECHA',
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
                'value' => 'Guardar',
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
