<?php

namespace App\Services;

use App\Models\Genral\LogModel;

class SystemMonitor
{
    public function reportError(string $message): void
    {
        LogModel::create([
            'action' => 'System Error',
            'description' => $message,
        ]);
    }

    public function logEvent(string $action, string $description): void
    {
        LogModel::create([
            'action' => $action,
            'description' => $description,
        ]);
    }
}
