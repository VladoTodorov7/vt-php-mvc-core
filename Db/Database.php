<?php 
namespace Vlgeto\PhpMvc\Db;
use Vlgeto\PhpMvc\Application;

/**
 * Database
 * @package Vlgeto\PhpMvc
 */
class Database {
    /**
     * Summary of pdo
     * @var \PDO
     */
    public \PDO $pdo;

    /**
     * Summary of __construct
     * @param array $config
     */
    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';

        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Summary of applyMigrations
     * @return void
     */
    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $applyMigrations = $this->getAppliedMigrations();
        
        $files = scandir(Application::$ROOT_DIR . '/migrations');
        $toApplyMigrations = array_diff($files, $applyMigrations, array('.', '..'));
        $newMigrations = [];

        foreach ($toApplyMigrations as $key => $migration) {
            require_once Application::$ROOT_DIR.'/migrations/'.$migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();
            $this->log("Applying migration $migration");
            $instance->up();
            $this->log("Applied migration $migration");
            $newMigrations[] = $migration;
        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log("All migrations are applied");
        }
    }

    /**
     * Summary of createMigrationsTable
     * @return void
     */
    public function createMigrationsTable()
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;");
    }

    /**
     * Summary of getAppliedMigrations
     * @return array
     */
    public function getAppliedMigrations()
    {
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * Summary of saveMigrations
     * @param array $migrations
     * @return void
     */
    public function saveMigrations(array $migrations)
    {
        $str = implode(",", array_map(fn($m) => "('$m')", $migrations));

        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES
            $str
        ");

        $statement->execute();
    }

    /**
     * Summary of prepare
     * @param mixed $sql
     * @return \PDOStatement|bool
     */
    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }

    /**
     * Summary of log
     * @param mixed $message
     * @return void
     */
    protected function log($message)
    {
        echo '['.date('Y-m-d H:i:s').'] - '.$message.PHP_EOL;
    }
}
?>