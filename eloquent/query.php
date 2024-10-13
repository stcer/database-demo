<?php

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/../laravel_boot.php';

DB::listen(function (QueryExecuted $query) {
    echo  $query->sql;
    // $query->bindings;
    echo "({$query->time})";
    // $query->toRawSql();
    echo "\n";
});

$users = DB::select('select * from users');
foreach ($users as $user) {
    var_dump($user);
}
