<?php

declare(strict_types=1);

namespace Catastro\Form;

use Laminas\InputFilter\InputFilter;
use Laminas\Validator;
use Laminas\Filter;
use Laminas\Filter\FilterChain;
use Laminas\Form\Element;
use Laminas\Form\Form;

class PredioForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('predio_form');
        $this->setAttribute('method', 'post');
        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements()
    {
        $this->add([
            'type' => Element\Select::class,
            'name' => 'cve_catastral',
            'options' => [
                'label' => 'Buscar...',
                'empty_option' => 'Buscar Predio por Clave Catastral',
                'disable_inarray_validator' => true,
            ],
            'attributes' => [
                // 'required' => true,
                'class' => 'custom-select'
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'input1',
            'attributes' => [
                'class' => 'form-control',
                'title' => 'input1',
                'placeholder' => 'input1',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'titular',
            'options' => [
                'label' => 'Titular',
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
            ]
        ]);

        $this->add([
            'type' => Element\Text::class,
            'name' => 'localidad',
            'options' => [
                'label' => 'Localidad',
            ],
            'attributes' => [
                //'required' => true,
                'class' => 'form-control',
            ]
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
            ]
        ]);

        $this->add([
            'type' => Element\Select::class,
            'name' => 'id_archivo_categoria',
            'options' => [
                'label' => 'Categorias',
                'empty_option' => 'Seleccione una categoría',
                'disable_inarray_validator' => true,
            ],
            'attributes' => [
                // 'required' => true,
                'class' => 'custom-select'
            ]
        ]);

        $this->add([
            'type' => Element\File::class,
            'name' => 'archivo',
            'options' => [
                'label' => 'Archivos'
            ],
            'attributes' => [
                // 'required'      => true,
                'valueDisabled' => true,
                'isArray'       => true,
                'multiple'      => true,
                'class'         => 'form-control',
                'id'            => 'archivo',
                'data-toggle'   => 'tooltip',
                'title'         => 'Cargar archivo'
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

        $inputFilter->add([
            'name' => 'archivo',
            // 'required' => true,
            # note for files we start with validators before we use filters
            'validators' => [
                // ['name' => Validator\NotEmpty::class],
                // ['name' => Validator\File\IsImage::class],
                // [
                //     'name' => Validator\File\MimeType::class,
                //     'options' => [
                //         'mimeType' => 'image/png. image/jpeg, image/jpg, image/gif'
                //     ],
                // ], # just uncomment this one. I forgot. It always gives issues.
                [
                    'name' => Validator\File\Size::class,
                    'options' => [
                        'min' => '3kB',
                        'max' => '15MB'
                    ],
                ],
            ],
            'filters' => [
                ['name' => Filter\StripTags::class],
                ['name' => Filter\StringTrim::class],
                [
                    'name' => Filter\File\RenameUpload::class,
                    'options' => [
                        'target' => './public/img',
                        'use_upload_name' => true,
                        'use_upload_extension' => true,
                        'overwrite' => true,
                        'randomize' => false
                    ]
                ]
            ]
        ]);

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
