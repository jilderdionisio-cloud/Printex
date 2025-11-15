<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Nombre de la aplicación
    |--------------------------------------------------------------------------
    |
    | Este valor es el nombre de la aplicación y se usa cuando el framework
    | necesita mostrarlo en una notificación u otros elementos de la interfaz.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Entorno de la aplicación
    |--------------------------------------------------------------------------
    |
    | Este valor determina en qué “entorno” se está ejecutando la aplicación.
    | Puede condicionar cómo configuras los distintos servicios utilizados.
    | Establécelo en tu archivo ".env".
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Modo debug de la aplicación
    |--------------------------------------------------------------------------
    |
    | Cuando la aplicación está en modo debug se muestran mensajes de error
    | detallados con stack traces. Si está desactivado, solo se verá una
    | página de error genérica.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | URL de la aplicación
    |--------------------------------------------------------------------------
    |
    | Esta URL la usa la consola para generar rutas correctamente cuando se
    | ejecutan comandos Artisan. Debe apuntar a la raíz de la aplicación.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Zona horaria de la aplicación
    |--------------------------------------------------------------------------
    |
    | Aquí puedes definir la zona horaria predeterminada para la aplicación,
    | utilizada por las funciones de fecha y hora de PHP. Por defecto es UTC.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Configuración regional de la aplicación
    |--------------------------------------------------------------------------
    |
    | Define la configuración regional predeterminada que usarán los métodos
    | de traducción/localización de Laravel. Puedes elegir cualquier locale
    | para el que tengas cadenas traducidas.
    |
    */

    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Clave de cifrado
    |--------------------------------------------------------------------------
    |
    | Esta clave la usan los servicios de cifrado de Laravel y debe ser una
    | cadena aleatoria de 32 caracteres para garantizar que todo valor sea
    | seguro. Debes definirla antes de desplegar la aplicación.
    |
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', (string) env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Controlador del modo mantenimiento
    |--------------------------------------------------------------------------
    |
    | Estas opciones determinan el driver que se usa para activar o gestionar
    | el estado de "modo mantenimiento" de Laravel. El driver "cache" permite
    | controlar el modo mantenimiento entre múltiples máquinas.
    |
    | Drivers permitidos: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

];
