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

    'accepted'             => 'De :attribute moeten worden geaccepteerd.',
    'active_url'           => 'De :attribute is geen geldige URL.',
    'after'                => 'De :attribute moet een geldige datum na :date zijn.',
    'alpha'                => 'De :attribute mag alleen letters bevatten.',
    'alpha_dash'           => 'Het :attribute mag alleen letters, cijfers en streepjes bevatten.',
    'alpha_num'            => 'Het :attribute mag alleen letters en cijfers bevatten.',
    'array'                => 'De :attribute moet een reeks zijn.',
    'before'               => 'De :attribute moet een datum zijn voor :date.',
    'between'              => [
        'numeric' => 'De :attribute moet tussen :min en :max zitten.',
        'file'    => 'De :attribute moet tussen :min en :max kilobytes groot zijn.',
        'string'  => 'De :attribute moet tussen :min en :max tekens lang zijn.',
        'array'   => 'De :attribute moet tussen :min en :max items lang zijn.',
    ],
    'boolean'              => 'Het :attribute -veld moet waar of onwaar zijn.', //the dash and space before 'veld' should probably be removed, but that might mess with the code.
    'confirmed'            => 'De :attribute -bevestiging komt niet overeen.',  //same here with 'bevestiging'.
    'date'                 => 'De :attribute is geen geldige datum.',
    'date_format'          => 'Het :attribute komt niet overeen met het formaat :format.',
    'different'            => 'De :attribute en :other moeten verschillend zijn.',
    'digits'               => 'De :attribute moet :digits cijfers lang zijn.',
    'digits_between'       => 'De :attribute moet tussen :min en :max cijfers lang zijn.',
    'distinct'             => 'Het :attribute -veld heeft een dubbele waarde.', //same here, again with 'veld'
    'email'                => 'Het :attribute moet een geldig e-mailadres zijn.',
    'exists'               => 'De geselecteerde :attribute is ongeldig.',
    'filled'               => 'Het :attribute -veld is vereist.', //same here
    'image'                => 'Het :attribute moet een afbeelding zijn.',
    'in'                   => 'De geselecteerde :attribute is ongeldig.',
    'in_array'             => 'Het :attribute -veld bestaat niet in :other.', //same here
    'integer'              => 'Het :attribute moet een heel getal zijn.',
    'ip'                   => 'Het :attribute moet een geldig IP-adres zijn.',
    'json'                 => 'Het :attribute moet een geldige JSON-tekst zijn.',
    'max'                  => [
        'numeric' => 'Het :attribute mag niet groter zijn dan :max.',
        'file'    => 'Het :attribute mag niet groter zijn dan :max kilobytes.',
        'string'  => 'De :attribute mag niet langer zijn dan :max karakters.',
        'array'   => 'De :attribute mag niet meer dan :max items bevatten.',
    ],
    'mimes'                => 'De :attribute moet een bestand van dit type zijn: :values.',
    'min'                  => [
        'numeric' => 'De :attribute moet minimaal :min zijn.',
        'file'    => 'Het :attribute moet minimaal :min kilobytes groot zijn.',
        'string'  => 'De :attribute moet minimaal :min karakters lang zijn.',
        'array'   => 'De :attribute moet minimaal :min bevatten.',
    ],
    'not_in'               => 'Het geselecteerde :attribute is ongeldig.',
    'numeric'              => 'Het :attribute moet een getal zijn.',
    'present'              => 'Het :attribute -veld moet aanwezig zijn.',//same as before with 'veld'
    'regex'                => 'Het :attribute -formaat is ongeldig.',//same here with 'formaat'
    'required'             => 'Het :attribute -veld is vereist.',//same as before with 'veld'
    'required_if'          => 'Het :attribute -veld is vereist wanneer :other gelijk is aan :value.',//same as before with 'veld'
    'required_unless'      => 'Het :attribute -veld is vereist tenzij :other in :values zit.',//same as before with 'veld'
    'required_with'        => 'Het :attribute -veld is vereist wanneer :values aanwezig is.',//same as before with 'veld'
    'required_with_all'    => 'Het :attribute -veld is vereist wanneer :values aanwezig is.',//same as before with 'veld'
    'required_without'     => 'Het :attribute -veld is vereist wanneer :values niet aanwezig is.',//same as before with 'veld'
    'required_without_all' => 'Het :attribute -veld is vereist wanneer geen van :values aanwezig zijn.',//same as before with 'veld'
    'same'                 => 'Het :attribute en :other moeten overeenkomen.',
    'size'                 => [
        'numeric' => 'De :attribute moet :size groot zijn.',
        'file'    => 'Het :attribute moet :size kilobytes groot zijn.',
        'string'  => 'De :attribute moet :size karakters lang zijn.',
        'array'   => 'De :attribute moet :size items lang zijn.',
    ],
    'string'               => 'De :attribute moet een stuk tekst zijn.',
    'timezone'             => 'De :attribute moet een geldige zone zijn.',
    'unique'               => 'De :attribute is al bezet.',
    'url'                  => 'Het :attribute -formaat is ongeldig.', //same here with 'formaat'

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
