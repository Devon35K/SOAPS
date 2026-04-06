<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Connection;

class DatabaseService
{
    private static ?Connection $instance = null;

    public static function getInstance(): Connection
    {
        if (self::$instance === null) {
            self::$instance = DB::connection();
        }

        return self::$instance;
    }

    public static function getPdo(): \PDO
    {
        return self::getInstance()->getPdo();
    }

    public static function table(string $table): \Illuminate\Database\Query\Builder
    {
        return DB::table($table);
    }

    public static function raw(string $sql, array $bindings = []): mixed
    {
        return DB::raw($sql);
    }

    public static function beginTransaction(): void
    {
        DB::beginTransaction();
    }

    public static function commit(): void
    {
        DB::commit();
    }

    public static function rollBack(): void
    {
        DB::rollBack();
    }
}
