<?php

declare(strict_types=1);

namespace Catastro\Form;

use Laminas\Form\Element;
use Laminas\Form\Form;

class AportacionForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('aportacion_form');
        $this->setAttribute('method', 'post',);

        $this->add([
            'type' => Element\Select::class,
            'name' => 'search_aportacion',
            'options' => [
                'label' => 'Buscar...',
                'empty_option' => 'Buscar por ID, Parcela, Propietario o Contribuyente',
                'disable_inarray_validator' => true,
            ],
            'attributes' => [
                'class' => 'custom-select',
                'id' =>'searchAportacion',
            ]
        ]);

        $this->add([
            'type' => Element\Select::class,
            'name' => 'contribuyente_id',
            'options' => [
                'label' => 'Buscar...',
                'empty_option' => 'Seleccione uno..',
                'disable_inarray_validator' => true,
            ],
            'attributes' => [
                'class' => 'custom-select',
                'id' =>'contribuyenteId',
            ]
        ]);

        $this->add([
            'type' => Element\File::class,
            'name' => 'archivo',
            'options' => [
                'label' => 'Archivos'
            ],
            'attributes' => [
                'required'      => true,
                'valueDisabled' => true,
                'isArray'       => true,
                'multiple'      => true,
                'class'         => 'form-control',
                'id'            => 'archivo',
                'data-toggle'   => 'tooltip',
                'title'         => 'Cargar archivo'
            ]
        ]);
//////Targeta de Aportacion////////
        $this->add([
            'type' => Element\Text::class,
            'name' => 'parcela',
            'options' => [
                'label' => 'Parcela',
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
                'id' => 'parcela',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'manzana',
            'options' => [
                'label' => 'Manzana',
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
                'id'=>'manzana',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'lote',
            'options' => [
                'label' => 'Lote',
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
                'id'=>'lote',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'local',
            'options' => [
                'label' => 'Local',
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
                'id'=>'local',
            ]
        ]);

        $this->add([
            'type' => Element\Select::class,
            'name' => 'categoria',
            'options' => [
                    'label' => 'Categoria',
                'value_options' => [
            'Rustico' => 'Rustico',
            'Urbano'=>'Urbano',
        ],
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'custom-select w-30',
                'id'=>'categoria',
            ]
        ]);

        $this->add([
            'type' => Element\Select::class,
            'name' => 'condicion',
            'options' => [
                    'label' => 'Condicion',
                'value_options' => [
            'Baldío' => 'Baldío',
            'Construido'=>'Construido',
            'Construyendo' => 'Construyendo',
        ],
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'custom-select w-30',
                'id'=>'condicion',
            ]
        ]);

        // $this->add([
        //     'type' => Element\Text::class,
        //     'name' => 'condicion',
        //     'options' => [
        //         'label' => 'Condicion',
        //     ],
        //     'attributes' => [
        //         //'required' => true,
        //         'class' => 'form-control',
        //     ]
        // ]);

/////DATOS DE INMUEBLE/////
        $this->add([
            'type' => Element\Text::class,
            'name' => 'titular',
            'options' => [
                'label' => 'Titular',
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
                'id' =>'titular',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'ubicacion',
            'options' => [
                'label' => 'Ubicación',
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
                'id'=>'ubicacion',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'antecedentes',
            'options' => [
                'label' => 'Antecedentes',
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
                'id'=>'antecedentes',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'con_norte',
            'options' => [
                'label' => 'Con',
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'con_sur',
            'options' => [
                'label' => 'Con',
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'con_este',
            'options' => [
                'label' => 'Con',
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'con_oeste',
            'options' => [
                'label' => 'Con',
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'norte',
            'options' => [
                'label' => 'Al Norte',
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
                'onkeypress' => 'return filterFloat(event,this);',
                'id' => 'norte'
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'sur',
            'options' => [
                'label' => 'Al Sur',
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
                'onkeypress' => 'return filterFloat(event,this);',
                'id' => 'sur'
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'este',
            'options' => [
                'label' => 'Al Este',
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
                'onkeypress' => 'return filterFloat(event,this);',
                'id' => 'este'
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'oeste',
            'options' => [
                'label' => 'Al Oeste',
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
                'onkeypress' => 'return filterFloat(event,this);',
                'id' => 'oeste'
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'clave_catastral',
            'options' => [
                'label' => 'Clave Catastral',
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
                'id' => 'claveCatastral'
            ]
        ]);

        $this->add([
            'type' => Element\Select::class,
            'name' => 'regimen_propiedad',
            'options' => [
                'label' => 'Regimen de Propiedad',
                'value_options' => [
            'Particular' => 'Particular',
            'Federal' => 'Federal',
            'Estatal'=>'Estatal',
            'Municipal' => 'Municipal',
            'Ejidal' => 'Ejidal',
            'Decentralizada' => 'Decentralizada',
            'Fidecomiso' => 'Fidecomiso',
            'Posesion Pacifica' => 'Posesion Pacifica',
        ],
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'custom-select w-30',
                'id'=>'regimenPropiedad',
            ]
        ]);

        $this->add([
            'type' => Element\Date::class,
            'name' => 'fecha_adquisicion',
            'options' => [
            'label' => 'Fecha de Adquicision',
            'format' => 'Y-m-d',
        ],
        'attributes' => [
            'class' => 'form-control',
            'min' => '2021-01-01',
            'max' => '2030-01-01',
            'step' => '1', // days; default step interval is 1 day
            'id' =>'fechaAdquicision',
            'required' => true,
            'value' => date("Y-m-d"),
        ],
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'titular_anterior',
            'options' => [
                'label' => 'Titular anterior',
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
                'id' =>'titularAnterior'
            ]
        ]);
/////REGISTRO FISCAL//////
        $this->add([
            'type' => Element\Text::class,
            'name' => 'contribuyente',
            'options' => [
                'label' => 'Contribuyente',
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
                'id' => 'Contribuyente'
            ]
        ]);

        $this->add([
            'type' => Element\Select::class,
            'name' => 'factura',
            'options' => [
                    'label' => 'Factura',
                'value_options' => [
            'Si' => 'Si',
            'No' => 'No',
        ],
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
                'id' => 'factura'
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'giro_comercial',
            'options' => [
                'label' => 'Giro Comercial',
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
                'id' => 'giro Comercial'
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'nombre_comercial',
            'options' => [
                'label' => 'Nombre Comercial',
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
                'id' => 'nombreComercial'
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'tenencia',
            'options' => [
                'label' => 'Tenencia',
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
                'id' => 'tenecia'
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'rfc',
            'options' => [
                'label' => 'RFC',
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
                'id' => 'rfContribuyente'
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 's_ocupada',
            'options' => [
                'label' => 'Superficie Ocupada',
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'uso_destino',
            'options' => [
                'label' => 'Uso o destino',
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
                'id' => 'usoDestino'
            ]
        ]);

//////AVALUO/////
$this->add([
            'type' => Element\Date::class,
            'name' => 'vig',
            'options' => [
            'label' => 'Fecha',
            'format' => 'Y-m-d',
        ],
        'attributes' => [
            'class' => 'form-control',
            'min' => '2021-01-01',
            'max' => '2030-01-01',
            'step' => '1', // days; default step interval is 1 day
            // 'onkeyup'=>'esvacio()',
            'id' =>'vig',
            'value' => date("Y-m-d"),
        ],
        ]);

        $this->add([
            'type' => Element\Textarea::class,
            'name' => 'observaciones',
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
                'rows' => '3',
                'id' => 'observaciones',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'terreno',
            'options' => [
                'label' => 'SUP.M2 TERRENO',
            ],
            'attributes' => [
                'required' => true,
                'class' => 'form-control',
                'data-toggle' => 'tooltip',
                "oninput"=> "Calcular()",
                "onkeypress"=> "return filterFloat(event,this);",
                // 'onkeyup'=>'esvacio()',
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
            'name' => 'v_terreno',
            'options' => [
                'label' => 'VALOR DEL TERRENO',
            ],
            'attributes' => [
                'readonly' => true,
                "onkeypress"=> "return filterFloat(event,this);",
                'class' => 'form-control',
                'id' =>'v_terreno',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'sup_m',
            'options' => [
                'label' => 'SUP.M2 CONSTRUCCIÓN',
            ],
            'attributes' => [
                'required' => true,
                'class' => 'form-control',
                'oninput'=> 'Calcular()',
                'onkeypress'=> 'return filterFloat(event,this);',
                // 'onkeyup'=>'esvacio()',
                'id' =>'sup_m',
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
            'name' => 'v_c',
            'options' => [
                'label' => 'VALOR DE LA CONSTRUCCION',
            ],
            'attributes' => [
                'readonly' => true,
                "onkeypress"=> "return filterFloat(event,this);",
                'class' => 'form-control',
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
                'readonly' => true,
                'onkeypress' => 'return filterFloat(event,this);',
                'class' => 'form-control',
                'id' =>'a_total',
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
            'type' => Element\Text::class,
            'name' => 'año_hidden',
            'attributes' => [
                // 'readonly' => true,
                'class' => 'form-control',
                // 'hidden' => true,
                'id' =>'año_hidden',
            ]
        ]);

        // $this->add([
        //     'type' => Element\Text::class,
        //     'name' => 'ejercicio_f',
        //     'options' => [
        //         'label' => 'EJERCICIO FISCAL',
        //     ],
        //     'attributes' => [
        //         // 'required' => true,
        //         'class' => 'form-control',
        //         'onkeypress'=>'return validaNumericos(event)',
        //         // 'onkeyup'=>'esvacio()',
        //         'id' =>'ejercicio_f',
        //     ]
        // ]);


		$this->add([
			'type' => Element\DateSelect::class,
			'name' => 'ejercicio_fiscal',
			'options' => [
				'label' => 'Ejercicio Fiscal',
				// 'create_empty_option' => true,
				'min_year' => date('Y')-21,
				'max_year' => date('Y'), # here we want users over the age of 13 only
				'year' => date('Y'),
				'render_delimiters' => false,
				'year_attributes' => [
					'class' => 'custom-select w-30',
                    'id' => 'ejercicio_fiscal',
                    'onchange' => 'CalcularAño()',
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
				'label' => 'Ejercicio Fiscal Final',
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
                'data-toggle' => 'tooltip',
                "onkeypress"=> "return filterFloat(event,this);",
                // 'onkeyup'=>'esvacio()',
                'id' =>'pago_a',
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

        // $this->add([
        //     'type' => Element\Text::class,
        //     'name' => 'parametro',
        //     'options' => [
        //     ],
        //     'attributes' => [
        //         'required' => true,
        //         'size' => 40,
        //         'maxlength' => 10,
        //         'class' => 'form-control',
        //         'hidden'=> true,
        //     ]
        // ]);

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
                'class' => 'btn btn-success btn-ok',
                'id' =>'btn-ok',
                // 'disabled' => 'true',
            ]
        ]);
    }
}
