<?php

declare(strict_types=1);

namespace App\Library;

use PDO;
use PDOException;
use Exception;

class Database
{
    private static ?PDO $pdo = null;

    /**
     * Returns a PDO instance for database operations.
     *
     * @return PDO The PDO instance.
     * @throws Exception If the database connection fails.
     */
    public static function db(): PDO
    {
        if (self::$pdo === null) {
            $config = self::getDbConfig();
            self::$pdo = self::createPdoConnection($config);
        }

        return self::$pdo;
    }

    /**
     * Retrieves the database configuration.
     *
     * @return array The database configuration array.
     */
    private static function getDbConfig(): array
    {
        return [
            'host' => getenv('DB_HOST'),
            'dbname' => getenv('DB_NAME'),
            'port' => getenv('DB_PORT'),
            'user' => getenv('DB_USER'),
            'password' => getenv('DB_PASSWORD')
        ];
    }

    /**
     * Creates a PDO connection.
     *
     * @param array $config The database configuration array.
     * @return PDO The PDO connection object.
     * @throws Exception If the database connection fails.
     */
    private static function createPdoConnection(array $config): PDO
    {
        $dsn = sprintf(
            "mysql:host=%s;dbname=%s;port=%s;charset=utf8mb4",
            $config['host'],
            $config['dbname'],
            $config['port']
        );

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            return new PDO($dsn, $config['user'], $config['password'], $options);
        } catch (PDOException $e) {
            error_log('Database connection failed: ' . $e->getMessage());
            throw new Exception('Database connection failed. Please try again later.');
        }
    }
}
