<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Valores predeterminados de autenticación
    |--------------------------------------------------------------------------
    |
    | Esta opción define el guard de autenticación y el broker de recuperación
    | de contraseñas predeterminados para la aplicación. Puedes cambiarlos
    | cuando sea necesario, pero son un buen punto de partida.
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Guards de autenticación
    |--------------------------------------------------------------------------
    |
    | Aquí puedes definir cada guard de autenticación para la aplicación.
    | Se incluye una configuración predeterminada que usa sesiones y el
    | proveedor de usuarios basado en Eloquent.
    |
    | Todo guard necesita un proveedor de usuarios, que define cómo obtenerlos
    | desde la base de datos u otro almacenamiento. Normalmente se usa Eloquent.
    |
    | Disponibles: "session"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Proveedores de usuarios
    |--------------------------------------------------------------------------
    |
    | Cada guard de autenticación tiene un proveedor de usuarios que determina
    | cómo obtenerlos desde la base de datos u otros almacenes. Normalmente se
    | utiliza Eloquent.
    |
    | Si manejas varias tablas o modelos de usuarios, puedes configurar varios
    | proveedores y asignarlos a los guards adicionales que necesites.
    |
    | Disponibles: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Restablecimiento de contraseñas
    |--------------------------------------------------------------------------
    |
    | Estas opciones definen cómo funciona el restablecimiento de contraseñas:
    | la tabla donde se guardan los tokens y el proveedor de usuarios que se
    | utilizará para recuperarlos.
    |
    | El tiempo de expiración indica cuántos minutos es válido cada token;
    | así se limita su vida útil y se reducen intentos de adivinanza.
    |
    | El throttle determina los segundos que un usuario debe esperar antes de
    | generar un nuevo token, evitando solicitudes masivas.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tiempo de espera para confirmar contraseña
    |--------------------------------------------------------------------------
    |
    | Aquí defines cuántos segundos pasan antes de que caduque la confirmación
    | de contraseña y se le pida al usuario volver a introducirla. Por defecto
    | son tres horas.
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
