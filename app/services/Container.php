<?php
namespace app\services;
use Exception;

class Container
{
    protected array $instances = [];
    private static ?Container $instance = null;

    private function __construct() {}

    public static function getInstance(): Container
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function set(string $abstract, $concrete = null)
    {
        if ($concrete === null) {
            $concrete = $abstract;
        }

        $this->instances[$abstract] = $concrete;
    }

    /**
     * @throws Exception
     */
    public function get(string $abstract)
    {
        if (!isset($this->instances[$abstract])) {
            throw new Exception("No instance registered for {$abstract}");
        }

        if (is_callable($this->instances[$abstract])) {
            return $this->instances[$abstract]($this);
        }

        return $this->instances[$abstract];
    }

    public function has(string $abstract): bool
    {
        return isset($this->instances[$abstract]);
    }
}