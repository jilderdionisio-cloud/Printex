<?php

namespace App\Support;

use App\Models\Audit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditLogger
{
    /**
     * Registra una acción sobre un modelo auditable.
     */
    public static function log(string $action, Model $model): void
    {
        Audit::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'auditable_type' => get_class($model),
            'auditable_id' => $model->getKey(),
        ]);
    }
}
