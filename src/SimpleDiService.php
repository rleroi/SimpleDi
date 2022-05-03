<?php

declare(strict_types=1);

final class SimpleDiService
{
    private static array $singletons = [];
    private static array $binds = [];

    /**
     * @return mixed|void
     */
    public static function make(string $class)
    {
        if (isset(self::$singletons[$class])) {
            return self::$singletons[$class];
        }

        if (isset(self::$binds[$class])) {
            return self::$binds[$class]();
        }

        if (class_exists($class)) {
            return new $class();
        }
    }

    public static function singleton(string $type, $instance): void
    {
        if (substr($type, 0, 1) !== '\\') {
            $type = '\\' . $type;
        }

        self::$singletons[$type] = $instance;
    }

    public static function bind(string $type, callable $callback): void
    {
        if (substr($type, 0, 1) !== '\\') {
            $type = '\\' . $type;
        }

        self::$binds[$type] = $callback;
    }
}
