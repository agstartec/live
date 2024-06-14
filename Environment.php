<?php
class Environment {
    public static function load() {
        $envFile = __DIR__ . '/.env';
        if (file_exists($envFile)) {
            $env = parse_ini_file($envFile);
            foreach ($env as $key => $value) {
                $_ENV[$key] = $value;
                putenv("$key=$value");
            }
        }
    }
}