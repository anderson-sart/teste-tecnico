<?php

namespace App;

use Illuminate\Database\Capsule\Manager as Capsule;

class DB {
    private static bool $booted = false;

    public static function boot(): void {
        if (self::$booted) return;

        $capsule = new Capsule;
        $capsule->addConnection([
            'driver'   => 'pgsql',
            'host'     => env('DB_HOST', 'db'),
            'database' => env('DB_DATABASE', 'softline_db'),
            'username' => env('DB_USERNAME', 'softline_user'),
            'password' => env('DB_PASSWORD', 'softline_pass'),
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        self::$booted = true;
    }

    public static function connection(): \PDO {
        return Capsule::connection()->getPdo();
    }
}
