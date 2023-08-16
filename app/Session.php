<?php

class Session
{
    public static function put(string $name, string|array $value) :array|string
    {
        return $_SESSION[$name] = $value;
    }

    public static function exists(string $name) :bool
    {
        return isset($_SESSION[$name]);
    }

    public static function delete(string $name) :void
    {
        if(self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    public static function get(string $name) :array|string
    {
        return $_SESSION[$name];
    }

    public static function flash(string $name, array $array = []): array
    {


        if(self::exists($name) && self::get($name) !== []) {
            $session = self::get($name);
            self::delete($name);
            return $session;
        }

        self::put($name, $array);
        return [];
    }

}
