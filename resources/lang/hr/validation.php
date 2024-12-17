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

    'accepted'             => ':attribute mora biti prihvaćen.',
    'active_url'           => ':attribute nije važeći URL.',
    'after'                => ':attribute mora biti datum nakon :date.',
    'after_or_equal'       => ':attribute mora biti datum nakon ili jednak :date.',
    'alpha'                => ':attribute smije sadržavati samo slova.',
    'alpha_dash'           => ':attribute smije sadržavati samo slova, brojeve i crtice.',
    'alpha_num'            => ':attribute smije sadržavati samo slova i brojeve.',
    'array'                => ':attribute mora biti niz.',
    'before'               => ':attribute mora biti datum prije :date.',
    'before_or_equal'      => ':attribute mora biti datum prije ili jednak :date.',
    'between'              => [
        'numeric' => ':attribute mora biti između :min i :max.',
        'file'    => ':attribute mora biti između :min i :max kilobajta.',
        'string'  => ':attribute mora biti između :min i :max znakova.',
        'array'   => ':attribute mora imati između :min i :max stavki.',
    ],
    'boolean'              => 'Polje :attribute mora biti true ili false.',
    'confirmed'            => 'Potvrda za :attribute se ne podudara.',
    'date'                 => ':attribute nije važeći datum.',
    'date_format'          => ':attribute ne odgovara formatu :format.',
    'different'            => ':attribute i :other moraju biti različiti.',
    'digits'               => ':attribute mora imati :digits znamenki.',
    'digits_between'       => ':attribute mora biti između :min i :max znamenki.',
    'dimensions'           => ':attribute ima nevažeće dimenzije slike.',
    'distinct'             => 'Polje :attribute ima duplikatnu vrijednost.',
    'email'                => ':attribute mora biti važeća e-mail adresa.',
    'exists'               => 'Odabrani :attribute nije važeći.',
    'file'                 => ':attribute mora biti datoteka.',
    'filled'               => 'Polje :attribute mora imati vrijednost.',
    'image'                => ':attribute mora biti slika.',
    'in'                   => 'Odabrani :attribute nije važeći.',
    'in_array'             => 'Polje :attribute ne postoji u :other.',
    'integer'              => ':attribute mora biti cijeli broj.',
    'ip'                   => ':attribute mora biti važeća IP adresa.',
    'ipv4'                 => ':attribute mora biti važeća IPv4 adresa.',
    'ipv6'                 => ':attribute mora biti važeća IPv6 adresa.',
    'json'                 => ':attribute mora biti važeći JSON niz.',
    'max'                  => [
        'numeric' => ':attribute ne smije biti veći od :max.',
        'file'    => ':attribute ne smije biti veći od :max kilobajta.',
        'string'  => ':attribute ne smije biti duži od :max znakova.',
        'array'   => ':attribute ne smije imati više od :max stavki.',
    ],
    'mimes'                => ':attribute mora biti datoteka tipa: :values.',
    'mimetypes'            => ':attribute mora biti datoteka tipa: :values.',
    'min'                  => [
        'numeric' => ':attribute mora biti najmanje :min.',
        'file'    => ':attribute mora biti najmanje :min kilobajta.',
        'string'  => ':attribute mora imati najmanje :min znakova.',
        'array'   => ':attribute mora imati najmanje :min stavki.',
    ],
    'not_in'               => 'Odabrani :attribute nije važeći.',
    'numeric'              => ':attribute mora biti broj.',
    'present'              => 'Polje :attribute mora biti prisutno.',
    'regex'                => 'Format :attribute je nevažeći.',
    'required'             => 'Polje :attribute je obavezno.',
    'required_if'          => 'Polje :attribute je obavezno kada :other bude :value.',
    'required_unless'      => 'Polje :attribute je obavezno osim ako :other bude u :values.',
    'required_with'        => 'Polje :attribute je obavezno kada :values bude prisutan.',
    'required_with_all'    => 'Polje :attribute je obavezno kada :values bude prisutan.',
    'required_without'     => 'Polje :attribute je obavezno kada :values nije prisutan.',
    'required_without_all' => 'Polje :attribute je obavezno kada nijedno od :values nije prisutno.',
    'same'                 => ':attribute i :other moraju biti isti.',
    'size'                 => [
        'numeric' => ':attribute mora biti :size.',
        'file'    => ':attribute mora biti :size kilobajta.',
        'string'  => ':attribute mora imati :size znakova.',
        'array'   => ':attribute mora sadržavati :size stavki.',
    ],
    'string'               => ':attribute mora biti niz.',
    'timezone'             => ':attribute mora biti važeća vremenska zona.',
    'unique'               => ':attribute je već zauzet.',
    'uploaded'             => 'Neuspješno učitavanje :attribute.',
    'url'                  => 'Format :attribute je nevažeći.',

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
