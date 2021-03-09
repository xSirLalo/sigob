<?php

declare(strict_types=1);

namespace Catastro\Form;

use Laminas\InputFilter\InputFilter;
use Laminas\Validator;
use Laminas\Filter;
use Laminas\Filter\FilterChain;
use Laminas\Form\Element;
use Laminas\Form\Form;

class BibliotecaForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('biblioteca_form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');

        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements()
    {
        $this->add([
            'type' => Element\Select::class,
            'name' => 'id_contribuyente',
            'options' => [
                'label' => 'Contribuyente',
                'empty_option' => 'Buscar...',
                'disable_inarray_validator' => true,
            ],
            'attributes' => [
                'required' => true,
                'class' => 'custom-select'
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
                'required' => true,
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
            'type' => Element\Submit::class,
            'name' => 'btnGuardar',
            'attributes' => [
                'value' => 'Guardar',
                'class' => 'btn btn-primary'
            ]
        ]);
    }

    protected function addInputFilter()
    {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $inputFilter->add([
            'name' => 'archivo',
            'required' => true,
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
    }
}
