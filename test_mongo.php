<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap/app.php';

use App\Models\Log;

try {
    $log = Log::create([
        'action' => 'Teste de conexão MongoDB',
        'task_id' => 0,
        'timestamp' => now()
    ]);
    echo "Conexão com MongoDB OK! Log criado.\n";
} catch (\Exception $e) {
    echo "Erro na conexão: " . $e->getMessage() . "\n";
}
