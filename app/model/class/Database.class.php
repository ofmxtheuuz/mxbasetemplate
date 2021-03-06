<?php

#require_once __DIR__ . '\..\..\..\vendor\autoload.php';

class Database
{

    private string $HOST;
    private string $DATABASE;
    private string $USER;
    private string $PASS;

    function __construct(array $connect)
    {
        $this->HOST =  $connect['host'];
        $this->DATABASE =  $connect['dbname'];
        $this->USER = $connect['user'];
        $this->PASS = $connect['password'];
    }

    public function Conn()
    {
        try {
            $connection = new PDO("mysql:host=".$this->HOST.";dbname=".$this->DATABASE, $this->USER, $this->PASS);
            return $connection;
        } catch (PDOException $PDOerror) {
            print_r("Error: " . $PDOerror->getMessage());
        } catch (Exception $error) {
            print_r("Error: " . $error->getMessage());
        }
    }

    static public function query($query)
    {

        $stmt = Self::Conn()->query($query);
        if ($stmt->rowCount() > 0) {
            $res = $stmt->fetchAll();
            return [
                'fetch' => $res,
                'rowCount' => $stmt->rowCount(),
            ];
        } else {
            return false;
        }
    }

    static public function selectAll($table)
    {
        $stmt = Self::Conn()->query("SELECT * FROM `$table`");
        if ($stmt->rowCount() > 0) {
            $res = $stmt->fetchAll();
            return [
                'fetch' => $res,
                'rowCount' => $stmt->rowCount(),
            ];
        } else {
            return false;
        }
    }

    static public function selectAllWhere($table, $where1, $where2)
    {
        $stmt = Self::Conn()->query("SELECT * FROM `$table` WHERE `$where1` = '$where2'");
        if ($stmt->rowCount() > 0) {
            return [
                'fetch' => $stmt->fetchAll(),
                'rowCount' => $stmt->rowCount(), 
            ];
        }
    }

    static public function selectWhere($table, $column, $where1, $where2)
    {
        $stmt = Database::Conn()->query("SELECT `$column` FROM `$table` WHERE `$where1` = '$where2'");
        if ($stmt->rowCount() > 0) {
            $res = $stmt->fetchAll();
            return $res;
        }
    }


    static public function truncateTable($table)
    {
        # Use por sua conta em risco
        Database::Conn()->query("TRUNCATE TABLE $table");
    }
}
