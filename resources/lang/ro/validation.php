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

    'accepted'             => ':attribute trebuie să fie acceptat.',
    'active_url'           => ':attribute nu este un URL valid.',
    'after'                => ':attribute trebuie să fie o dată după :date.',
    'after_or_equal'       => ':attribute trebuie să fie o dată după sau egală cu :date.',
    'alpha'                => ':attribute poate conține doar litere.',
    'alpha_dash'           => ':attribute poate conține doar litere, cifre și liniuțe.',
    'alpha_num'            => ':attribute poate conține doar litere și cifre.',
    'array'                => ':attribute trebuie să fie un array.',
    'before'               => ':attribute trebuie să fie o dată înainte de :date.',
    'before_or_equal'      => ':attribute trebuie să fie o dată înainte sau egală cu :date.',
    'between'              => [
        'numeric' => ':attribute trebuie să fie între :min și :max.',
        'file'    => ':attribute trebuie să fie între :min și :max kilobytes.',
        'string'  => ':attribute trebuie să fie între :min și :max caractere.',
        'array'   => ':attribute trebuie să aibă între :min și :max elemente.',
    ],
    'boolean'              => ':attribute trebuie să fie adevărat sau fals.',
    'confirmed'            => 'Confirmarea :attribute nu se potrivește.',
    'date'                 => ':attribute nu este o dată validă.',
    'date_format'          => ':attribute nu se potrivește cu formatul :format.',
    'different'            => ':attribute și :other trebuie să fie diferite.',
    'digits'               => ':attribute trebuie să fie :digits cifre.',
    'digits_between'       => ':attribute trebuie să fie între :min și :max cifre.',
    'dimensions'           => ':attribute are dimensiuni invalide de imagine.',
    'distinct'             => ':attribute conține o valoare duplicată.',
    'email'                => ':attribute trebuie să fie o adresă de e-mail validă.',
    'exists'               => ':attribute selectat este invalid.',
    'file'                 => ':attribute trebuie să fie un fișier.',
    'filled'               => ':attribute trebuie să aibă o valoare.',
    'image'                => ':attribute trebuie să fie o imagine.',
    'in'                   => ':attribute selectat este invalid.',
    'in_array'             => ':attribute nu există în :other.',
    'integer'              => ':attribute trebuie să fie un număr întreg.',
    'ip'                   => ':attribute trebuie să fie o adresă IP validă.',
    'ipv4'                 => ':attribute trebuie să fie o adresă IPv4 validă.',
    'ipv6'                 => ':attribute trebuie să fie o adresă IPv6 validă.',
    'json'                 => ':attribute trebuie să fie un șir JSON valid.',
    'max'                  => [
        'numeric' => ':attribute nu poate fi mai mare decât :max.',
        'file'    => ':attribute nu poate fi mai mare decât :max kilobytes.',
        'string'  => ':attribute nu poate fi mai mare decât :max caractere.',
        'array'   => ':attribute nu poate avea mai mult de :max elemente.',
    ],
    'mimes'                => ':attribute trebuie să fie un fișier de tipul: :values.',
    'mimetypes'            => ':attribute trebuie să fie un fișier de tipul: :values.',
    'min'                  => [
        'numeric' => ':attribute trebuie să fie cel puțin :min.',
        'file'    => ':attribute trebuie să fie cel puțin :min kilobytes.',
        'string'  => ':attribute trebuie să fie cel puțin :min caractere.',
        'array'   => ':attribute trebuie să aibă cel puțin :min elemente.',
    ],
    'not_in'               => ':attribute selectat este invalid.',
    'numeric'              => ':attribute trebuie să fie un număr.',
    'present'              => ':attribute trebuie să fie prezent.',
    'regex'                => 'Formatul :attribute este invalid.',
    'required'             => ':attribute este câmpul obligatoriu.',
    'required_if'          => ':attribute este obligatoriu când :other este :value.',
    'required_unless'      => ':attribute este obligatoriu, cu excepția cazului în care :other este în :values.',
    'required_with'        => ':attribute este obligatoriu atunci când :values este prezent.',
    'required_with_all'    => ':attribute este obligatoriu atunci când :values este prezent.',
    'required_without'     => ':attribute este obligatoriu atunci când :values nu este prezent.',
    'required_without_all' => ':attribute este obligatoriu atunci când niciunul dintre :values nu este prezent.',
    'same'                 => ':attribute și :other trebuie să se potrivească.',
    'size'                 => [
        'numeric' => ':attribute trebuie să fie :size.',
        'file'    => ':attribute trebuie să fie de :size kilobytes.',
        'string'  => ':attribute trebuie să fie de :size caractere.',
        'array'   => ':attribute trebuie să conțină :size elemente.',
    ],
    'string'               => ':attribute trebuie să fie un șir de caractere.',
    'timezone'             => ':attribute trebuie să fie o zonă validă.',
    'unique'               => ':attribute a fost deja luat.',
    'uploaded'             => ':attribute nu s-a încărcat.',
    'url'                  => 'Formatul :attribute este invalid.',

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
