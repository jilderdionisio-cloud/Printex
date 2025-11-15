<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mailer predeterminado
    |--------------------------------------------------------------------------
    |
    | Esta opción define el mailer que se usará para enviar correos, salvo
    | que se especifique otro al momento de enviar el mensaje. Los demás
    | mailers se configuran en el arreglo "mailers", junto con ejemplos.
    |
    */

    'default' => env('MAIL_MAILER', 'log'),

    /*
    |--------------------------------------------------------------------------
    | Configuración de mailers
    |--------------------------------------------------------------------------
    |
    | Aquí defines todos los mailers que usa la aplicación y sus ajustes.
    | Hay varios ejemplos listos y puedes agregar los tuyos según necesidad.
    |
    | Laravel soporta múltiples drivers de transporte para enviar correos;
    | especifica cuál usa cada mailer y añade otros si lo requieres.
    |
    | Disponibles: "smtp", "sendmail", "mailgun", "ses", "ses-v2",
    |              "postmark", "resend", "log", "array",
    |              "failover", "roundrobin"
    |
    */

    'mailers' => [

        'smtp' => [
            'transport' => 'smtp',
            'scheme' => env('MAIL_SCHEME'),
            'url' => env('MAIL_URL'),
            'host' => env('MAIL_HOST', '127.0.0.1'),
            'port' => env('MAIL_PORT', 2525),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'local_domain' => env('MAIL_EHLO_DOMAIN', parse_url((string) env('APP_URL', 'http://localhost'), PHP_URL_HOST)),
        ],

        'ses' => [
            'transport' => 'ses',
        ],

        'postmark' => [
            'transport' => 'postmark',
            // 'message_stream_id' => env('POSTMARK_MESSAGE_STREAM_ID'),
            // 'client' => [
            //     'timeout' => 5,
            // ],
        ],

        'resend' => [
            'transport' => 'resend',
        ],

        'sendmail' => [
            'transport' => 'sendmail',
            'path' => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail -bs -i'),
        ],

        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],

        'array' => [
            'transport' => 'array',
        ],

        'failover' => [
            'transport' => 'failover',
            'mailers' => [
                'smtp',
                'log',
            ],
            'retry_after' => 60,
        ],

        'roundrobin' => [
            'transport' => 'roundrobin',
            'mailers' => [
                'ses',
                'postmark',
            ],
            'retry_after' => 60,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Dirección global "From"
    |--------------------------------------------------------------------------
    |
    | Si quieres que todos los correos salgan desde la misma dirección, aquí
    | puedes definir el nombre y el correo que se usarán globalmente.
    |
    */

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Example'),
    ],

];
