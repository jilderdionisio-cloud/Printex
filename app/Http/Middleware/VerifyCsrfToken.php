<?php
//protege tu aplicación contra ataques CSRF (Cross-Site Request Forgery)
namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        //
        '/chat-productos',
    ];
}
