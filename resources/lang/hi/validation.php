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

    'accepted'             => ':attribute को स्वीकार किया जाना चाहिए।',
    'active_url'           => ':attribute एक वैध यूआरएल नहीं है।',
    'after'                => ':attribute :date के बाद की तिथि होनी चाहिए। ',
    'alpha'                => ':attribute में केवल अक्षर हो सकते हैं।',
    'alpha_dash'           => ':attribute में केवल अक्षर, नंबर, और डैश हो सकते हैं।',
    'alpha_num'            => ':attribute में केवल अक्षर और नंबर हो सकते हैं।',
    'array'                => ':attribute एक सरणी होनी चाहिए।',
    'before'               => ':attribute :date के पहले की तिथि होनी चाहिए।',
    'between'              => [
        'numeric' => ':attribute :min और :max के बीच होना चाहिए।',
        'file'    => ':attribute :min और :max केबी के बीच होना चाहिए।',
        'string'  => ':attribute :min और :max वर्णों के बीच होना चाहिए।',
        'array'   => ':attribute :min और :max वस्तुओं के बीच होना चाहिए।',
    ],
    'boolean'              => ':attribute क्षेत्र सही या गलत होना चाहिए।',
    'confirmed'            => ':attribute पुष्टि मेल नहीं करती।',
    'date'                 => ':attribute एक मान्य तिथि नहीं है।',
    'date_format'          => ':attribute प्रारूप :format से मेल नहीं खाता।',
    'different'            => ':attribute और :other अलग होना चाहिए।',
    'digits'               => ':attribute :digits अंकों का होना चाहिए।',
    'digits_between'       => ':attribute :min और :max अंकों के बीच होना चाहिए।',
    'distinct'             => ':attribute क्षेत्र में एक डुप्लीकेट मान है।',
    'email'                => ':attribute एक मान्य ईमेल पता होना चाहिए।',
    'exists'               => 'चयनित :attribute अमान्य है।',
    'filled'               => ':attribute आवश्यक क्षेत्र है।',
    'image'                => ':attribute एक तस्वीर होनी चाहिए।',
    'in'                   => 'चयनित :attribute अमान्य है।',
    'in_array'             => ':attribute क्षेत्र :other में मौजूद नहीं है।',
    'integer'              => ':attribute एक पूर्णांक ही होना चाहिए।',
    'ip'                   => ':attribute एक मान्य आईपी एड्रेस होना चाहिए।',
    'json'                 => ':attribute एक मान्य जावास्क्रिप्ट ऑब्जेक्ट नोटेशन स्ट्रिंग होनी चाहिए।',
    'max'                  => [
        'numeric' => ':attribute :max से अधिक नहीं हो सकता है।',
        'file'    => ':attribute :max केबी से अधिक नहीं हो सकता है।',
        'string'  => ':attribute :max वर्णों से अधिक नहीं हो सकता है।',
        'array'   => ':attribute में :max वस्तुओं से अधिक नहीं हो सकती है।',
    ],
    'mimes'                => ':attribute निम्न प्रकार की एक फ़ाइल होनी चाहिए: :values',
    'min'                  => [
        'numeric' => ':attribute कम से कम :min होना चाहिए।',
        'file'    => ':attribute कम से कम :min केबी होना चाहिए।',
        'string'  => ':attribute कम से कम :min वर्ण होने चाहिए।',
        'array'   => ':attribute कम से कम :min वस्तुएं होनी चाहिए।',
    ],
    'not_in'               => 'चयनित :attribute अमान्य है।',
    'numeric'              => ':attribute एक संख्या होनी चाहिए।',
    'present'              => ':attribute क्षेत्र उपस्थित होना चाहिए।',
    'regex'                => ':attribute का प्रारूप अमान्य है।',
    'required'             => ':attribute क्षेत्र आवश्यक है।',
    'required_if'          => ':attribute क्षेत्र आवश्यक है जब :other :value है।',
    'required_unless'      => ':attribute क्षेत्र आवश्यक है जब तक कि :other :values में है।',
    'required_with'        => ':attribute क्षेत्र आवश्यक है जब :values उपस्थित है।',
    'required_with_all'    => ':attribute क्षेत्र आवश्यक है जब :values उपस्थित है।',
    'required_without'     => ':attribute क्षेत्र आवश्यक है जब :values उपस्थित नहीं है।',
    'required_without_all' => ':attribute क्षेत्र आवश्यक है जब :values में से कोई भी उपस्थित नहीं है।',
    'same'                 => ':attribute एवं :other समान होने चाहिए।',
    'size'                 => [
        'numeric' => ':attribute :size होना चाहिए।',
        'file'    => ':attribute :size केबी होना चाहिए।',
        'string'  => ':attribute :size वर्णों का होना चाहिए।',
        'array'   => ':attribute में :size वस्तुएं होनी चाहिए।',
    ],
    'string'               => ':attribute एक स्ट्रिंग होनी चाहिए।',
    'timezone'             => ':attribute एक मान्य ज़ोन होना चाहिए।',
    'unique'               => ':attribute पहले से ही लिया जा चुका है।',
    'url'                  => ':attribute का प्रारूप अमान्य है।',

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
            'rule-name' => 'कस्टम-संदेश',
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
