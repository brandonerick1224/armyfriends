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

    'accepted'             => ':attribute deve essere accettato.',
    'active_url'           => ':attribute non è un URL valido.',
    'after'                => ':attribute deve essere una data successiva a :date.',
    'alpha'                => ':attribute può contenere solo lettere.',
    'alpha_dash'           => ':attribute può contenere solo lettere, numeri e trattini separatori.',
    'alpha_num'            => ':attribute può contenere solo lettere e numeri .',
    'array'                => ':attribute deve essere un vettore.',
    'before'               => ':attribute deve essere una data precedente a :date.',
    'between'              => [
        'numeric' => ':attribute deve essere compreso tra :min e :max.',
        'file'    => ':attribute deve essere compreso tra :min e :max kilobyte.',
        'string'  => ':attribute deve essere compreso tra :min e :max caratteri.',
        'array'   => ':attribute deve essere compreso tra :min e :max elementi.',
    ],
    'boolean'              => 'Il campo :attribute deve essere vero o  falso.',
    'confirmed'            => 'La conferma di :attribute non corrisponde.',
    'date'                 => ':attribute non è una data valida.',
    'date_format'          => ':attribute non corrisponde al formato :format.',
    'different'            => ':attribute e :other devono essere diversi.',
    'digits'               => ':attribute deve essere di :digits cifre.',
    'digits_between'       => ':attribute deve essere compreso tra :min e :max cifre.',
    'distinct'             => 'Il campo :attribute ha un valore duplicato.',
    'email'                => ':attribute deve essere un indirizzo email valido.',
    'exists'               => ':attribute selezionato non valido.',
    'filled'               => 'Il campo :attribute è richiesto.',
    'image'                => ':attribute deve essere un\'immagine.',
    'in'                   => ':attribute selezionato non valido.',
    'in_array'             => 'Il campo :attribute non esiste in :other.',
    'integer'              => ':attribute deve essere un numero intero.',
    'ip'                   => ':attribute deve essere un indirizzo IP valido.',
    'json'                 => ':attribute deve essere una stringa JSON valida.',
    'max'                  => [
        'numeric' => ':attribute non deve essere maggiore di :max.',
        'file'    => ':attribute non deve essere maggiore di :max kilobyte.',
        'string'  => ':attribute non deve essere maggiore di :max caratteri.',
        'array'   => ':attribute non può avere più di :max elementi.',
    ],
    'mimes'                => ':attribute deve essere un file di tipo: :values.',
    'min'                  => [
        'numeric' => ':attribute deve essere almeno :min.',
        'file'    => ':attribute deve essere almeno :min kilobyte.',
        'string'  => ':attribute deve essere almeno di :min caratteri.',
        'array'   => ':attribute deve avere almeno :min elementi.',
    ],
    'not_in'               => ':attribute selezionato non valido.',
    'numeric'              => ':attribute deve essere un numero.',
    'present'              => 'Il campo :attribute deve essere presente.',
    'regex'                => 'Il formato di :attribute non è valido.',
    'required'             => 'Il campo :attribute è richiesto.',
    'required_if'          => 'Il campo :attribute è richiesto quando :other è :value.',
    'required_unless'      => 'Il campo :attribute è richiesto a meno che :other sia in :values.',
    'required_with'        => 'Il campo :attribute è richiesto quando :values è presente.',
    'required_with_all'    => 'Il campo :attribute è richiesto quando :values sono presenti.',
    'required_without'     => 'Il campo :attribute è richiesto quando :values non è presente.',
    'required_without_all' => 'Il campo :attribute è richiesto quando nessuno di :values è presente.',
    'same'                 => ':attribute e :other devono corrispondere.',
    'size'                 => [
        'numeric' => ':attribute deve essere :size.',
        'file'    => ':attribute deve essere :size kilobyte.',
        'string'  => ':attribute deve essere :size caratteri.',
        'array'   => ':attribute deve contenere :size elementi.',
    ],
    'string'               => ':attribute deve essere una stringa.',
    'timezone'             => ':attribute deve essere una zona valida.',
    'unique'               => ':attribute è già stato preso.',
    'url'                  => 'Il formato di :attribute non è valido.',

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
            'rule-name' => 'custom-message',
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
