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

    'accepted'             => 'الـ :attribute يجب أن تقبل.',
    'active_url'           => 'الـ :attribute رابط غير صحيح',
    'after'                => 'الـ :attribute يجب أن تكون قبل تاريخ :date.',
    'alpha'                => 'الـ :attribute قد تحتوي على حروف فقط.',
    'alpha_dash'           => 'الـ :attribute قد تحتوي على حروف، وأرقام ورموز فقط.',
    'alpha_num'            => 'الـ :attribute قد تحتوي على حروف وأرقام فقط.',
    'array'                => 'الـ :attribute يجب أن تكون مصفوفة',
    'before'               => 'الـ :attribute يجب أن تكون بتاريخ قبل :date.',
    'between'              => [
        'numeric' => 'الـ :attribute يجب أن تتراوح بين :min و :max.',
        'file'    => 'الـ :attribut يجب أن تتراوح بين :min و :max كيلوبايت.',
        'string'  => 'الـ :attribute يجب أن يتراوح بين :min و :max حرف.',
        'array'   => 'الـ :attribute يجب أن يكون بين :min  و :max عنصر.',
    ],
    'boolean'              => 'الـ :attribute الحق يجب أن يكون صحيح أو خاطئ.',
    'confirmed'            => 'الـ :attribute التأكيد لم يتطابق.',
    'date'                 => 'الـ :attribute تاريخ غير صحيح.',
    'date_format'          => 'الـ :attribute لم يتطابق مع صيغة :format.',
    'different'            => 'الـ :attribute و :other يجب أن يكونوا مختلفين',
    'digits'               => 'الـ :attribute يجب أن يكون :digits رقم',
    'digits_between'       => 'الـ :attribute يجب أن تكون بين :min و :max رقم.',
    'distinct'             => 'حقل الـ :attribute له قيمة مكررة.',
    'email'                => 'الـ :attribute يجب أن يكون البريد الإلكتروني صحيح.',
    'exists'               => ' :attribute المحدد غير صحيح',
    'filled'               => 'حقل الـ :attribute مطلوب',
    'image'                => 'الـ :attribute يجب أن يكون صورة',
    'in'                   => 'الـ :attribute المحدد غير صحيح',
    'in_array'             => 'حقل الـ :attribute غير موجود في :other.',
    'integer'              => 'الـ :attribute يجب أن يكون رقم صحيح',
    'ip'                   => 'الـ :attribute يجب أن يكون عنوان IP صحيح.',
    'json'                 => 'الـ :attribute يجب أن يكون JSON جملة صحيحة.',
    'max'                  => [
        'numeric' => 'الـ :attribute قد لا تكون أكبر من :max.',
        'file'    => 'الـ :attribute قد لا تكون أكبر من :max كيلوبايت.',
        'string'  => 'الـ :attribute قد لا تكون أكبر من :max حرف.',
        'array'   => 'الـ :attribute قد لا تحتوي على أكثر من  :max عنصر',
    ],
    'mimes'                => 'الـ :attribute يجب أن يكون نوع الملف: :values.',
    'min'                  => [
        'numeric' => 'الـ :attribute يجب ألا يقل عن :min.',
        'file'    => 'الـ :attribute  يجب ألا يقل عن :min كيلوبايت',
        'string'  => 'الـ :attribute  يجب ألا يقل عن :min حرف',
        'array'   => 'الـ :attribute يجب أن تحتوي على  :min عنصر على الأقل.',
    ],
    'not_in'               => 'الـ :attribute المحدد غير صحيح',
    'numeric'              => 'الـ :attribute يجب أن يكون رقم.',
    'present'              => 'حقل الـ :attribute field يجب أن يكون موجود.',
    'regex'                => 'صيغة الـ :attribute غير صحيحة',
    'required'             => 'حقل الـ :attribute مطلوب.',
    'required_if'          => 'حقل الـ :attribute مطلوب عندما :other هي :value.',
    'required_unless'      => 'حقل الـ :attribute مطلوب فيما عدا :other هو :values.',
    'required_with'        => 'حقل الـ :attribute مطلوب عندما :values تكون موجودة',
    'required_with_all'    => 'حقل الـ :attribute مطلوبة عندما :values تكون موجودة.',
    'required_without'     => 'حقل الـ :attribute مطلوب عندما :values تكون غير موجودة.',
    'required_without_all' => 'حقل الـ :attribute field مطلوب عندما لا يتواجد أي من :values.',
    'same'                 => 'الـ :attribute و :other يجب أن يتطابقا.',
    'size'                 => [
        'numeric' => 'الـ :attribute يجب أن يكون :size.',
        'file'    => 'الـ :attribute يجب أن يكون :size كيلوبايت',
        'string'  => 'الـ :attribute يجب أن يكون :size حرف',
        'array'   => 'الـ :attribute يجب أن تحتوي على  :size عنصر',
    ],
    'string'               => 'الـ :attribute يجب أن تكون جملة.',
    'timezone'             => 'الـ :attribute يجب أن تكون منطقة صحيحة',
    'unique'               => 'الـ :attribute تم أخذه بالفعل.',
    'url'                  => 'صيغة الـ :attribute غير صحيحة.',

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

