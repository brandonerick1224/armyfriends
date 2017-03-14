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

    'accepted'             => ':attribute kabul edilmelidr.',
    'active_url'           => ':attribute geçerli bir URL değil.',
    'after'                => ':attribute :date tarihinden sonraki bir tarih olmalıdır.',
    'alpha'                => ':attribute yalnızca harflerden oluşabilir.',
    'alpha_dash'           => ':attribute yalnızca harfler, rakamlar veya boşluklardan oluşabilir.',
    'alpha_num'            => ':attribute yalnızca harfler veya rakamlardan oluşabilir..',
    'array'                => ':attribute bir dizi olmalıdır.',
    'before'               => ':attribute :date tarihinden önceki bir tarih olmalıdır.',
    'between'              => [
        'numeric' => ':attribute :min ile :max arasında olmalıdır.',
        'file'    => ':attribute :min ile :max kilobayt arasında olmalıdır.',
        'string'  => ':attribute :min ile :max karakter arasında olmalıdır.',
        'array'   => ':attribute :min ile :max nesne arasında olmalıdır.',
    ],
    'boolean'              => ':attribute alanı doğru veya yanlış olmalıdır.',
    'confirmed'            => ':attribute doğrulama eşleşmiyor.',
    'date'                 => ':attribute geçerli bir tarih değil.',
    'date_format'          => ':attribute :format formatıyla eşleşmiyor.',
    'different'            => ':attribute ve :other farklı olmalıdır.',
    'digits'               => ':attribute :digits basamak olmalıdır.',
    'digits_between'       => ':attribute :min ile :max basamak arasında olmalıdır.',
    'distinct'             => ':attribute alanında tekrar eden bir değer bulunuyor.',
    'email'                => ':attribute geçerli bir eposta adresi olmalıdır.',
    'exists'               => 'Seçili :attribute geçersiz.',
    'filled'               => ':attribute alanı gereklidir.',
    'image'                => ':attribute bir resim olmalıdır.',
    'in'                   => 'Seçili :attribute geçersiz.',
    'in_array'             => ':attribute alanı :other içinde bulunmuyor.',
    'integer'              => ':attribute bir tam sayı olmalıdır.',
    'ip'                   => ':attribute geçerli bir IP adresi olmalıdır.',
    'json'                 => ':attribute JSON stringi olmalıdır.',
    'max'                  => [
        'numeric' => ':attribute :max değerinden büyük olamaz.',
        'file'    => ':attribute :max kilobayt değerinden büyük olamaz.',
        'string'  => ':attribute :max karakter değerinden büyük olamaz.',
        'array'   => ':attribute :max adetten daha fazla nesne içeremez.',
    ],
    'mimes'                => ':attribute şu dosya türünden olmalıdır: :values.',
    'min'                  => [
        'numeric' => ':attribute en az :min değerinde olmalıdır.',
        'file'    => ':attribute en az :min kilobayt değerinde olmalıdır.',
        'string'  => ':attribute en az :min karakter değerinde olmalıdır.',
        'array'   => ':attribute en az :min nesne içermelidir.',
    ],
    'not_in'               => 'Seçili :attribute geçerli değil.',
    'numeric'              => ':attribute bir rakam olmalıdır.',
    'present'              => ':attribute alanı bulunmalıdır.',
    'regex'                => ':attribute formatı geçersiz.',
    'required'             => ':attribute alanı gereklidir.',
    'required_if'          => ':attribute alanı :other :value olduğunda gereklidir.',
    'required_unless'      => ':attribute alanı :other mevcut :values olduğunda gereklidir.',
    'required_with'        => ':attribute alanı :values mevcut olduğunda gereklidir.',
    'required_with_all'    => ':attribute alanı :values mevcut olduğunda gereklidir.',
    'required_without'     => ':attribute alanı :values mevcut olmadığında gereklidir.',
    'required_without_all' => ':attribute alanı :values değerlerinden hiçbiri mevcut olmadığında gereklidir.',
    'same'                 => ':attribute ve :other eşleşmelidir.',
    'size'                 => [
        'numeric' => ':attribute boyutu şu olmalıdır :size.',
        'file'    => ':attribute boyutu :size kilobayt olmalıdır.',
        'string'  => ':attribute :size karakter olmalıdır.',
        'array'   => ':attribute :size nesne içermelidir.',
    ],
    'string'               => ':attribute string olmalıdır.',
    'timezone'             => ':attribute geçerli bir bölge olmalıdır.',
    'unique'               => ':attribute zaten alınmış.',
    'url'                  => ':attribute formatı geçersiz.',

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
            'rule-name' => 'kişiselleştirilmiş-mesaj',
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
