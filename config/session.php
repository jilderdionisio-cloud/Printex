<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Controlador de Sesión Predeterminado
    |--------------------------------------------------------------------------
    |
    | Esta opción determina el controlador de sesión predeterminado que se utiliza para
    | las solicitudes entrantes. Laravel soporta una variedad de opciones de almacenamiento para
    | conservar los datos de sesión. El almacenamiento en base de datos es una excelente opción predeterminada.
    |
    | Soportados: "archivo", "cookie", "base de datos", "memcached",
    | "redis", "dynamodb", "array"
    |
    */

'driver' => env('SESSION_DRIVER', 'file'),

    /*
    |--------------------------------------------------------------------------
    | Duración de la sesión
    |--------------------------------------------------------------------------
    |
    | Aquí puede especificar el número de minutos que desea que la sesión
     permanezca inactiva antes de que expire. Si desea que expire
    | inmediatamente al cerrar el navegador, puede indicarlo mediante
    | la opción de configuración expire_on_close.
    |
    */

    'lifetime' => (int) env('SESSION_LIFETIME', 120),

    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),

    /*
    |--------------------------------------------------------------------------
    | Cifrado de Sesión
    |--------------------------------------------------------------------------
    |
    | Esta opción te permite especificar fácilmente que todos los datos de tu sesión
    | sean cifrados antes de ser almacenados. Todo el cifrado se realiza
    | automáticamente por Laravel y puedes usar la sesión como de costumbre.
    |
    */

    'encrypt' => env('SESSION_ENCRYPT', false),

    /*
    |--------------------------------------------------------------------------
| Ubicación del archivo de sesión
|--------------------------------------------------------------------------
|
| Al utilizar el controlador de sesión "file", los archivos de sesión se colocan
| en el disco. La ubicación de almacenamiento predeterminada se define aquí; sin embargo,
| eres libre de proporcionar otra ubicación donde deberían almacenarse.
|
    */

    'files' => storage_path('framework/sessions'),

    /*
    |--------------------------------------------------------------------------
| Conexión a la Base de Datos de Sesión
|--------------------------------------------------------------------------
|
| Al usar los controladores de sesión "database" o "redis", puedes especificar una
| conexión que se debe utilizar para administrar estas sesiones. Esto debe
| corresponder a una conexión en las opciones de configuración de tu base de datos.
|
    */

    'connection' => env('SESSION_CONNECTION'),

    /*
    |--------------------------------------------------------------------------
| Tabla de Base de Datos de Sesiones
|--------------------------------------------------------------------------
|
| Al usar el controlador de sesión "database", puedes especificar la tabla
| que se usará para almacenar las sesiones. Por supuesto, se define un
| valor predeterminado razonable para ti; sin embargo, puedes cambiarlo
| a otra tabla si lo deseas.
|
    */

    'table' => env('SESSION_TABLE', 'sessions'),

    /*
    |--------------------------------------------------------------------------
| Almacén de Caché de Sesión
|--------------------------------------------------------------------------
|
| Al utilizar uno de los backends de sesión basados en caché del framework, puedes
| definir el almacén de caché que se debe usar para guardar los datos de sesión
| entre solicitudes. Esto debe coincidir con uno de tus almacenes de caché definidos.
|
| Afecta a: "dynamodb", "memcached", "redis"
|
    */

    'store' => env('SESSION_STORE'),

    /*
    |--------------------------------------------------------------------------
| Lotería de limpieza de sesiones
|--------------------------------------------------------------------------
|
| Algunos controladores de sesión deben limpiar manualmente su ubicación de almacenamiento
| para deshacerse de las sesiones antiguas. Aquí están las probabilidades de que
| esto ocurra en una solicitud determinada. Por defecto, las probabilidades son 2 de cada 100.
|
    */

    'lottery' => [2, 100],

    /*
    |--------------------------------------------------------------------------
| Nombre de la Cookie de Sesión
|--------------------------------------------------------------------------
|
| Aquí puedes cambiar el nombre de la cookie de sesión que es creada por
| el framework. Normalmente, no deberías necesitar cambiar este valor,
| ya que hacerlo no proporciona una mejora significativa en la seguridad.
|
    */

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug((string) env('APP_NAME', 'laravel')).'-session'
    ),

    /*
    |--------------------------------------------------------------------------
| Ruta de la Cookie de Sesión
|--------------------------------------------------------------------------
|
| La ruta de la cookie de sesión determina la ruta para la cual la cookie
| será considerada disponible. Normalmente, esta será la ruta raíz de
| tu aplicación, pero puedes cambiarla cuando sea necesario.
|
    */

    'path' => env('SESSION_PATH', '/'),

    /*
    |--------------------------------------------------------------------------
| Dominio de la Cookie de Sesión
|--------------------------------------------------------------------------
|
| Este valor determina el dominio y los subdominios a los que la cookie de sesión
| estará disponible. Por defecto, la cookie estará disponible para el dominio raíz
| y todos los subdominios. Normalmente, esto no debería cambiarse.
|
    */

    'domain' => env('SESSION_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
| Cookies Solo HTTPS
|--------------------------------------------------------------------------
|
| Al configurar esta opción en verdadero, las cookies de sesión solo se enviarán
| de vuelta al servidor si el navegador tiene una conexión HTTPS. Esto evitará
| que la cookie se envíe cuando no se pueda hacer de forma segura.
|
    */

    'secure' => env('SESSION_SECURE_COOKIE'),

    /*
    |--------------------------------------------------------------------------
| Solo Acceso HTTP
|--------------------------------------------------------------------------
|
| Configurar este valor en verdadero evitará que JavaScript acceda al
| valor de la cookie y la cookie solo será accesible a través del protocolo
| HTTP. Es poco probable que debas desactivar esta opción.
|
    */

    'http_only' => env('SESSION_HTTP_ONLY', true),

    /*
    |--------------------------------------------------------------------------
| Cookies Same-Site
|--------------------------------------------------------------------------
|
| Esta opción determina cómo se comportan tus cookies cuando se realizan
| solicitudes entre sitios y puede usarse para mitigar ataques CSRF.
| Por defecto, configuraremos este valor en "lax" para permitir solicitudes
| seguras entre sitios.
|
| Ver: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie#samesitesamesite-value
|
| Compatibles: "lax", "strict", "none", null
|
    */

    'same_site' => env('SESSION_SAME_SITE', 'lax'),

    /*
    |--------------------------------------------------------------------------
| Cookies Particionadas
|--------------------------------------------------------------------------
|
| Establecer este valor en verdadero vinculará la cookie al sitio de nivel superior
| en un contexto de sitios cruzados. Las cookies particionadas son aceptadas por el
| navegador cuando se marcan como "seguras" y el atributo Same-Site se establece en "none".
|
    */

    'partitioned' => env('SESSION_PARTITIONED_COOKIE', false),

];
