<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */

    'accepted'             => 'Polje :attribute mora biti prihvaćeno.',
    'active_url'           => 'Polje :attribute nije validan URL.',
    'after'                => 'Polje :attribute mora biti datum posle :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'Polje :attribute može sadržati samo slova.',
    'alpha_dash'           => 'Polje :attribute može sadržati samo slova, brojeve i povlake.',
    'alpha_num'            => 'Polje :attribute može sadržati samo slova i brojeve.',
    'array'                => 'Polje :attribute mora sadržati nekih niz stavki.',
    'before'               => 'Polje :attribute mora biti datum pre :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'Polje :attribute mora biti između :min - :max.',
        'file'    => 'Fajl :attribute mora biti između :min - :max kilobajta.',
        'string'  => 'Polje :attribute mora biti između :min - :max karaktera.',
        'array'   => 'Polje :attribute mora biti između :min - :max stavki.',
    ],
    'boolean'              => 'Polje :attribute mora biti tačno ili netačno',
    'confirmed'            => 'Potvrda polja :attribute se ne poklapa.',
    'date'                 => 'Polje :attribute nije važeći datum.',
    'date_format'          => 'Polje :attribute ne odgovora prema formatu :format.',
    'different'            => 'Polja :attribute i :other moraju biti različita.',
    'digits'               => 'Polje :attribute mora sadržati :digits šifri.',
    'digits_between'       => 'Polje :attribute mora biti izemđu :min i :max šifri.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'Format polja :attribute nije validan.',
    'exists'               => 'Odabrano polje :attribute nije validno.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'Polje :attribute je obavezno.',
    'image'                => 'Polje :attribute mora biti slika.',
    'in'                   => 'Odabrano polje :attribute nije validno.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'Polje :attribute mora biti broj.',
    'ip'                   => 'Polje :attribute mora biti validna IP adresa.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'Polje :attribute mora biti manje od :max.',
        'file'    => 'Polje :attribute mora biti manje od :max kilobajta.',
        'string'  => 'Polje :attribute mora sadržati manje od :max karaktera.',
        'array'   => 'Polje :attribute ne smije da image više od :max stavki.',
    ],
    'mimes'                => 'Polje :attribute mora biti fajl tipa: :values.',
    'mimetypes'            => 'Polje :attribute mora biti fajl tipa: :values.',
    'min'                  => [
        'numeric' => 'Polje :attribute mora biti najmanje :min.',
        'file'    => 'Fajl :attribute mora biti najmanje :min kilobajta.',
        'string'  => 'Polje :attribute mora sadržati najmanje :min karaktera.',
        'array'   => 'Polje :attribute mora sadrzati najmanje :min stavku.',
    ],
    'not_in'               => 'Odabrani element polja :attribute nije validan.',
    'numeric'              => 'Polje :attribute mora biti broj.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'Format polja :attribute nije validan.',
    'required'             => 'Polje :attribute je obavezno.',
    'required_if'          => 'Polje :attribute je potrebno kada polje :other sadrži :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'Polje :attribute je potrebno kada polje :values je prisutan.',
    'required_with_all'    => 'Polje :attribute je obavezno kada je :values prikazano.',
    'required_without'     => 'Polje :attribute je potrebno kada polje :values nije prisutan.',
    'required_without_all' => 'Polje :attribute je potrebno kada nijedan od sledeći polja :values nisu prisutni.',
    'same'                 => 'Polja :attribute i :other se moraju poklapati.',
    'size'                 => [
        'numeric' => 'Polje :attribute mora biti :size.',
        'file'    => 'Fajl :attribute mora biti :size kilobajta.',
        'string'  => 'Polje :attribute mora biti :size karaktera.',
        'array'   => 'Polje :attribute mora sadržati :size stavki.',
    ],
    'string'               => 'Polje :attribute mora sadržati slova.',
    'timezone'             => 'Polje :attribute mora biti ispravna vremenska zona.',
    'unique'               => 'Polje :attribute već postoji.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'Format polja :attribute ne važi.',

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

    'custom'               => [
        'name' => [
            'required' => 'Polje ime je obavezno.',
            'max' => 'Polje ime mora sadržati manje od 50 karaktera.',
        ],
        'plan_name' => [
            'required' => 'Polje naziv je obavezno.',
        ],
        'deposit_amount' => [
            'required' => 'Polje depozit je obavezno.',
            'numeric' => 'Depozit mora biti broj.',
        ],
        'type' => [
            'required' => 'Polje tip je obavezno.',
        ],
        'lastname' => [
            'required' => 'Polje prezime je obavezno.',
            'max' => 'Polje prezime mora sadržati manje od :max karaktera.',
        ],
        'birth' => ['date' => 'Polje rođendan mora biti datum.'],
        'note' => [
            'required' => 'Polje opis je obavezno.',
            'max' => 'Polje napomena mora sadržati manje od :max karaktera.'
        ],
        'phone' => [
            'required' => 'Polje telefon je obavezno.',
             'max' => 'Polje telefon mora sadržati manje od 20 cifara.',
        ],
        'theme' => [
            'required' => 'Polje tema je obavezno.',
             'max' => 'Tema mora sadržati manje od 50 karaktera.',
        ],
        'question'=> [
            'required' => 'Polje pitanje je obavezno.',
             'max' => 'Pitanje može da sadrži maksimalno do 1500 karaktera.',
        ],
         'post_title' => [
            'required' => 'Naslov je obavezn.',
            'max' => 'Naslov mora sadržati manje od 200 karaktera.',
        ],
        'post_desc' => [
            'required' => 'Kratak opis je obavezan.',
            'max' => 'Kratak opis može sadržati maksimalno do 160 karaktera.',
        ],
         'slug' => [
            'required' => 'Url slug je obavezan.',
            'unique' => 'Url slug mora biti unikatan.',
        ],
         'post_body' => [
            'required' => 'Sadžaj je obavezan.',
            'max' => 'Sadžaj može sadržati maksimalno  do 10000 karaktera.',
        ],
         'workout_number' => [
            'required' => 'Polje broj vežbača je obavezno.',
            'numeric' => 'Polje broj vežbača mora biti broj.',
        ],
         'workout_time' => [
            'required' => 'Polje vreme je obavezno.',
            'numeric' => 'Polje vreme mora biti broj.',
        ],
         'terms_number' => [
            'required' => 'Broj termina je obavezno.',
            'numeric' => 'Broj termina mora biti broj.',
            'max' => 'Broj termina ne može biti veći od 99.',
        ],
         'user_id' => [
            'required' => 'Polje korisnik je obavezno.',
            'unique' => 'Izabran korisnik već postoji.',
             'exists' => 'Izabrani vežbač ne postoji u bazi.'
        ],
        'plan_id' => [
            'required' => 'Plan je obavezan.',
            'unique' => 'Plan već postoji.',
            'exists' => 'Izabrani plan ne postoji u bazi.'
        ],
         'expired_time' => [
            'required' => 'Polje istek je obavezno.',
            'date' => 'Polje istek mora biti datum.',
        ],
         'active' => [
            'boolean' => 'Polje aktivan mora biti bulian.',
        ],
        'time_book' => [
            'required' => 'Polje Trajanje zakazivanja je obavezno.',
            'numeric' => 'Polje Trajanje zakazivanja mora biti broj.',
        ],
         'time_delay' => [
            'required' => 'Polje Trajanje otkazivanja je obavezno.',
             'numeric' => 'Polje  Trajanje otkazivanja mora biti broj.',
        ],
         'time_pause' => [
            'required' => 'Polje Trajanje pauze je obavezno.',
             'numeric' => 'Polje  Trajanje pauze mora biti broj.',
        ],
        'workout_id' => [
            'required' => 'Polje vrsta treninga je obavezno.',
            'numeric' => 'Polje  vrsta treninga mora biti broj.',
        ],
        'price' => [
            'required' => 'Polje cena  je obavezno.',
            'numeric' => 'Polje cenamora biti broj.',
        ],
        'plan_duration' => [
            'required' => 'Polje trajanje plana je obavezno.',
            'numeric' => 'Polje trajanje plana biti broj.',
        ],
        'start_datetime' => [
            'required' => 'Morate izabrati datum za termine.',
            'date' => 'Datum nije korektno formatiran.',
        ],
        'start_dates' => [
            'required' => 'Morate izabrati bar jedan datum za primenu termina.',
            'array' => 'Datumi za primenu moraju biti u listi.',
            'min' => 'Morate izabrati bar jedan datum za primenu termina.',
        ],
        'start_dates.*' => [
            'required' => 'Svaki izabrani datum mora biti validan.',
            'date' => 'Jedan od izabranih datuma nije korektno formatiran.',
        ],
        'hours' => [
            'required' => 'Mora se dodati polje za vreme početka termina.',
        ],
        'slots' => [
            'required' => 'Unestie broj mesta.',
        ],
        'pattern_id' => [
            'required' => 'Izaberite šablon.',
        ],
        'hours.*' => [
            'required' => 'Polje vreme početka je obavezno.',
        ],
        'product_name' =>[
            'required' => 'Polje ime je obavezno.',
        ],
        'product_price' =>[
            'required' => 'Polje cena je obavezno.',
            'numeric' => 'Polje cena biti broj.'
        ],
        'product_quantity' =>[
            'required' => 'Polje količina je obavezno.',
            'numeric' => 'Polje cena biti broj.'
        ],
        'product_description' =>[
            'required' => 'Polje opis je obavezno.',
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

    'attributes'           => [
        //
    ],

];
