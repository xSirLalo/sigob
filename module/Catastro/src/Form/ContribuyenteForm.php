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
            'type' => Element\Select::class,
            'name' => 'persona',
            'options' => [
                'label' => 'Buscar...',
                'empty_option' => 'Buscar Contribuyente por Nombre o R.F.C',
                'disable_inarray_validator' => true,
            ],
            'attributes' => [
                'id' => 'persona',
                // 'required' => true,
                'class' => 'custom-select'
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'input1',
            'attributes' => [
                'hidden'=> true,
            ]
        ]);

        $this->add([
            'type' => Element\Select::class,
            'name' => 'tipo_persona',
            'options' => [
                'label' => 'Tipo',
                'empty_option' => 'Seleccionar...',
                'value_options' => [
                    'F'  => 'Física',
                    'M' => 'Moral',
                ]
            ],
            'attributes' => [
                'id' => 'tipo_persona',
                // 'required' => true,
                'class' => 'custom-select'
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'nombre',
            'options' => [
                'label' => 'Nombre',
            ],
            'attributes' => [
                // 'required' => true,
                'class' => 'form-control',
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
            'type' => Element\Text::class,
            'name' => 'razon_social',
            'options' => [
                'label' => 'Razón Social',
            ],
            'attributes' => [
                // 'required' => true,
                'class' => 'form-control',
                'placeholder' => 'Razón Social',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'correo',
            'options' => [
                'label' => 'Correo Electrónico',
            ],
            'attributes' => [
                // 'required' => true,
                'size' => 40,
                'maxlength' => 128,
                'pattern' => '^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$',
                'autocomplete' => false,
                'class' => 'form-control',
                'placeholder' => 'Correo Electrónico',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'telefono',
            'options' => [
                'label' => 'Teléfono',
            ],
            'attributes' => [
                // 'required' => true,
                'class' => 'form-control',
                'placeholder' => 'Teléfono',
            ]
        ]);

        $this->add([
            'type' => Element\Select::class,
            'name' => 'genero',
            'options' => [
                'label' => 'Genero',
                'empty_option' => 'Seleccionar...',
                'value_options' => [
                    'M' => 'Mujer',
                    'H' => 'Hombre',
                    'O' => 'Otro'
                ],
            ],
            'attributes' => [
                // 'required' => true,
                'class' => 'custom-select', # styling
            ]
        ]);

        $this->add([
            'type' => Element\Select::class,
            'name' => 'estado_civil',
            'options' => [
                'label' => 'Estado Civil',
                'empty_option' => 'Seleccionar...',
                'value_options' => [
                    'S' => 'Soltero',
                    'C' => 'Casado',
                    'O' => 'Otro'
                ],
            ],
            'attributes' => [
                // 'required' => true,
                'class' => 'custom-select', # styling
            ]
        ]);

        $this->add([
            'type' => Element\DateSelect::class,
            'name' => 'fecha_nacimiento',
            'options' => [
                'label' => 'Fecha de nacimiento',
                'create_empty_option' => true,
                'max_year' => date('Y') - 13, # here we want users over the age of 13 only
                'render_delimiters' => false,
                'year_attributes' => [
                    'data-placeholder' => 'Year',
                    'style'            => 'width: 33%',
                    'class' => 'custom-select'
                ],
                'month_attributes' => [
                    'data-placeholder' => 'Month',
                    'style'            => 'width: 33%',
                    'class' => 'custom-select'
                ],
                'day_attributes' => [
                    'data-placeholder' => 'Day',
                    'style'            => 'width: 33%',
                    'class' => 'custom-select',
                    'id' => 'day'
                ],
            ],
            'attributes' => [
                'required' => true
            ]
        ]);

        $this->add([
            'type' => Element\Select::class,
            'name' => 'id_archivo_categoria',
            'options' => [
                'label' => 'Categorias',
                // 'empty_option' => 'Seleccione una categoría',
                'create_empty_option' => true,
                'allowEmpty' => true,
                'render_delimiters' => false,
                'disable_inarray_validator' => true,
            ],
            'attributes' => [
                'class' => 'custom-select',
                'data-placeholder' => 'Categoria',
                'required' => false,
                'multiple' => 'multiple',
                'size' => 1 ,
                'placeholder' => 'Categoria',
            ]
        ]);

        $this->add([
            'type' => Element\File::class,
            'name' => 'archivo',
            'options' => [
                'label' => 'Archivos',
                // 'label_attributes' => [
                //     'class' => 'custom-file-label'
                // ],
            ],
            'attributes' => [
                // 'required'      => false,
                'valueDisabled' => true,
                'isArray'       => true,
                'multiple'      => true,
                'class' => 'custom-select',
                // 'class'         => 'custom-file-input',
                'id'            => 'archivo',
            ]
        ]);

        $this->add([
            'type' => Element\Button::class,
            'name' => 'add_more',
            'options' => [
                'label' => 'Agregar +'
            ],
            'attributes' => [
                'class' => 'btn btn-success',
                'id' => 'add_more'
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

        $inputFilter->add(
            [
                'name' => 'persona',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ]
        );

        $inputFilter->add(
            [
                'name' => 'id_archivo_categoria',
                'required' => false,
                'allow_empty' => true,
                'allowEmpty' => true,
                'continue_if_empty' => true,
                'filters' => [
                    ['name' => Filter\StripTags::class],
                    ['name' => Filter\StringTrim::class],
                    ['name' => Filter\ToInt::class],
                ],
                'validators' => [
                    [
                        'name' => Validator\NotEmpty::class,
                        'options' => [
                            "type" => "string"
                        ]
                    ],
                    // ['name' => I18n\Validator\IsInt::class],
                    // [
                    //     'name' => Validator\InArray::class,
                    //     'options' => [
                    //         'haystack' => [0, 1, 2, 3],
                    //         'strict'   => false
                    //     ],
                    // ],
                ],
            ]
        );

        // $inputFilter->add([
        //     'name' => 'archivo',
        //     'required' => false,
        //     # note for files we start with validators before we use filters
        //     'validators' => [
        //         // ['name' => Validator\NotEmpty::class],
        //         // ['name' => Validator\File\IsImage::class],
        //         // [
        //         //     'name' => Validator\File\MimeType::class,
        //         //     'options' => [
        //         //         'mimeType' => 'image/png. image/jpeg, image/jpg, image/gif'
        //         //     ],
        //         // ], # just uncomment this one. I forgot. It always gives issues.
        //         [
        //             'name' => Validator\File\Size::class,
        //             'options' => [
        //                 'min' => '3kB',
        //                 'max' => '15MB'
        //             ],
        //         ],
        //     ],
        //     'filters' => [
        //         ['name' => Filter\StripTags::class],
        //         ['name' => Filter\StringTrim::class],
        //         [
        //             'name' => Filter\File\RenameUpload::class,
        //             'options' => [
        //                 'target' => './public/img',
        //                 'use_upload_name' => true,
        //                 'use_upload_extension' => true,
        //                 'overwrite' => true,
        //                 'randomize' => false
        //             ]
        //         ]
        //     ]
        // ]);

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
                        'encoding' => 'UTF-8',
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

        $inputFilter->add(
            [
                'name' => 'correo',
                'required' => true,
                'filters' => [
                    ['name' => Filter\StripTags::class],
                    ['name' => Filter\StringTrim::class],
                ],
                'validators' => [
                    // ['name' => Validator\NotEmpty::class],
                    ['name' => Validator\EmailAddress::class],
                        // [
                        // 	'name' => Validator\Db\RecordExists::class,
                        // 	'options' => [
                        // 		'table' => 'contribuyente',
                        // 		'field' => 'email',
                        // 		// 'adapter' => $this->adapter,
                        // 	],
                        // ],
                ],
            ]
        );

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
