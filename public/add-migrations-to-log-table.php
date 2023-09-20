<?php
print("Commented for security reasons\n\n");
//
//define('LARAVEL_START', microtime(true));
//
//require __DIR__ . '/vendor/autoload.php';
//
//$app = require_once __DIR__.'/bootstrap/app.php';
//
//$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
//
//$response = $kernel->handle(
//    $request = Illuminate\Http\Request::createFromGlobals()
//);
//
//use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Schema;
//
//// Connect to the database
//$connection = DB::connection();
//
//// Get the list of migrations in the migrations directory
//$migrations = array_map(function ($file) {
//    return basename($file);
//}, glob(database_path('migrations/*.php')));
//
//// dd($connection->table('migrations')->get()->toArray());
//
//// Get the list of migrations already in the migrations table
//$existing_migrations = array_map(function ($migration) {
//    return $migration->migration;
//}, $connection->table('migrations')->get()->toArray());
//
//// Get the list of migrations to be added to the migrations table
//$migrations_to_add = array_diff($migrations, $existing_migrations);
//
//// Insert the migrations into the migrations table
//$connection->table('migrations')->insert(array_map(function ($migration) use (&$batch) {
//    return [
//        'migration' => $migration,
//        'batch' => ++$batch,
//    ];
//}, $migrations_to_add));
