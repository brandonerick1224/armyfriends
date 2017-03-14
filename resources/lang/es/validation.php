<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'El :attribute debe ser aceptado.',
    'active_url'           => 'El :attribute no es una URL válida.',
    'after'                => 'El :attribute debe ser una fecha después de  :date.',
    'alpha'                => 'El :attribute solamente puede contener letras.',
    'alpha_dash'           => 'El :attribute solamente puede contener letras, números y guiones.',
    'alpha_num'            => 'El :attribute solamente puede contener letras y números.',
    'array'                => 'El :attribute debe ser un conjunto.',
    'before'               => 'El :attribute debe ser una fecha después de  :date.',
    'between'              => [
        'numeric' => 'El :attribute debe ser de entre :min and :max.',
        'file'    => 'El :attribute debe ser de entre :min and :max kilobytes.',
        'string'  => 'El  :attribute debe ser de entre :min and :max characters.',
        'array'   => 'El :attribute debe ser de entre :min and :max items.',
    ],
    'boolean'              => 'El campo de :attribute debe ser verdadero o falso.',
    'confirmed'            => 'La :attribute de confirmación no coincide.',
    'date'                 => 'La :attribute no es una fecha válida.',
    'date_format'          => 'La :attribute no coincide con el formato :format.',
    'different'            => 'El :attribute y :other deben ser diferentes.',
    'digits'               => 'El :attribute debe ser de :digits dígitos.',
    'digits_between'       => 'El :attribute debe ser de entre :min and :max dígitos.',
    'distinct'             => 'El campo :attribute tiene un valor duplicado.',
    'email'                => 'El :attribute debe ser una dirección de email válida.',
    'exists'               => 'El :attribute seleccinado no es válido.',
    'filled'               => 'El campo :attribute es obligatorio.',
    'image'                => 'La :attribute debe ser una imagen.',
    'in'                   => 'El :attribute seleccionado no es válido.',
    'in_array'             => 'El campo :attribute no existe en :other.',
    'integer'              => 'El :attribute debe ser un número entereo.',
    'ip'                   => 'El :attribute debe ser una dirección de IP válida.',
    'json'                 => 'El :attribute debe ser una cadena JSON válida.',
    'max'                  => [
        'numeric' => 'El :attribute no puede ser mayor a :max.',
        'file'    => 'El :attribute no puede ser mayor a :max kilobytes.',
        'string'  => 'El :attribute no puede ser mayor a :max caracteres.',
        'array'   => 'El :attribute no puede ser mayor a :max objetos.',
    ],
    'mimes'                => 'El :attribute debe ser un archivo del tipo :values.',
    'min'                  => [
        'numeric' => 'El :attribute debe ser por lo menos de :min.',
        'file'    => 'El :attribute debe ser por lo menos de :min kilobytes.',
        'string'  => 'El :attribute debe ser por lo menos de :min caracteres.',
        'array'   => 'El :attribute debe ser por lo menos de :min objetos.',
    ],
    'not_in'               => 'El :attribute seleccionado no es válido.',
    'numeric'              => 'El :attribute debe ser un número.',
    'present'              => 'El campo :attribute debe estar presente.',
    'regex'                => 'El formato de :attribute no es válido.',
    'required'             => 'El campo :attribute es obligatorio.',
    'required_if'          => 'El campo :attribute es obligatorio cuando :other es :value.',
    'required_unless'      => 'El campo :attribute es obligatorio a no ser que :other es :values.',
    'required_with'        => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_with_all'    => 'El campo :attribute es obligatorio cuando  :values está presente.',
    'required_without'     => 'El campo :attribute es obligatorio cuando :values no está presente.',
    'required_without_all' => 'El campo :attribute es obligatorio cuando ninguno de los :values está presente.',
    'same'                 => 'El :attribute y :other deben coincidir.',
    'size'                 => [
        'numeric' => 'El :attribute debe ser :size.',
        'file'    => 'El :attributedebe ser :size kilobytes.',
        'string'  => 'El :attribute debe ser :size caracteres.',
        'array'   => 'El :attribute debe contener :size objetos.',
    ],
    'string'               => 'El :attribute debe ser una cadena.',
    'timezone'             => 'El :attribute debe ser una zona válida.',
    'unique'               => 'El :attribute ya ha sido tomado.',
    'url'                  => 'El formato de :attribute no es valido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'mensaje especial',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
