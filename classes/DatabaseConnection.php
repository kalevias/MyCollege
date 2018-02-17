<?php

/**
 * Class dbc
 * Originally created by Lionite, Mar 27, 2014
 * https://www.binpress.com/tutorial/using-php-with-mysql-the-right-way/17
 *
 * Modified to suit needs of the project.
 */
class DatabaseConnection
{
    /**
     * The database connection
     *
     * @var mysqli
     */
    protected static $connection;
    /**
     * Name of the currently connected-to database
     *
     * @var string
     */
    private static $db;
    /**
     * Flag indicating if the current connection is processing an SQL transaction
     *
     * @var bool
     */
    private static $inTransaction;

    /**
     * @return bool
     * @throws Exception
     */
    public function commitTransaction(): bool
    {
        $connection = $this->connect();
        if ($stmt = $connection->prepare("COMMIT;")) {
            $result = $stmt->execute();
            $stmt->close();
            return $this::$inTransaction = !$result;
        }
        throw new Exception("Unable to connect to database");
    }

    /**
     * Connect to the database.
     * Returns a MySQLi object instance on success, false on failure.
     *
     * @return bool|mysqli
     */
    public function connect()
    {
        // Try and connect to the database
        if (!isset(self::$connection)) {
            // Load configuration as an array. Use the actual location of your configuration file
//            $config = parse_ini_file(SECURE_DIR.AutoLoader::PROJECT_DIR."config.ini");
            $config = [
                "host" => "localhost",
                "username" => "root",
                "password" => "",
                "database" => "mycollege",
            ];
            self::$connection = new mysqli($config["host"], $config["username"], $config["password"], $config["database"]);
            self::$db = $config["database"];
        }

        // If connection was not successful, handle the error
        if (self::$connection->connect_error !== null) {
            // Handle error - notify administrator, log to a file, show an error screen, etc.
            return false;
        }
        return self::$connection;
    }

    /**
     * Fetch the last error from the database.
     *
     * @return string
     */
    public function error(): string
    {
        $connection = $this->connect();
        return $connection->error;
    }

    /**
     * @return string
     */
    public function getDatabaseName(): string
    {
        return $this::$db;
    }

    /**
     * Returns the maximum allowed length of a field from a particular table.
     * In essence, returns either CHARACTER_MAXIMUM_LENGTH, DATETIME_PRECISION, or NUMERIC_PRECISION
     * from the information_schema table. For decimal, float, and double types, it will
     * return an array of the form, ["NUMERIC_PRECISION"=>int, "NUMERIC_SCALE"=>int] where
     * NUMERIC_PRECISION is the number of digits in the number, and NUMERIC_SCALE is how many
     * of those digits can be after the decimal point. Also, the function will return
     * DATETIME_PRECISION for valid datetime fields as well.
     *
     * Returns false if the specified column cannot be found in the specified table, or if
     * the DATA_TYPE of the specified column is neither numeric, a string, nor a datetime.
     *
     * @param string $table
     * @param string $field
     * @param string|null $schema
     * @return int|int[]|bool
     */
    public function getMaximumLength(string $table, string $field, string $schema = null)
    {
        $this->connect();
        if (!isset($schema)) {
            $schema = $this->getTableSchema();
        }
        $params = ["sss", $schema, $table, $field];
        $type = $this->query("select", "SELECT `DATA_TYPE` 
                                                              FROM `information_schema`.`COLUMNS` 
                                                              WHERE `TABLE_SCHEMA` = ? 
                                                                AND `TABLE_NAME` = ?
                                                                AND `COLUMN_NAME` = ?", $params);
        if ($type) {
            switch ($type["DATA_TYPE"]) {
                case "tinyint":
                case "smallint":
                case "mediumint":
                case "int":
                case "bigint":
                case "bit":
                    $length = $this->query("select", "SELECT `NUMERIC_PRECISION`
                                                                            FROM `information_schema`.`COLUMNS`
                                                                            WHERE `TABLE_SCHEMA` = ?
                                                                              AND `TABLE_NAME` = ?
                                                                              AND `COLUMN_NAME` = ?", $params);
                    if ($length) {
                        return $length["NUMERIC_PRECISION"];
                    } else {
                        return false;
                    }
                case "decimal":
                case "float":
                case "double":
                    $length = $this->query("select", "SELECT `NUMERIC_PRECISION`, `NUMERIC_SCALE`
                                                                            FROM `information_schema`.`COLUMNS`
                                                                            WHERE `TABLE_SCHEMA` = ?
                                                                              AND `TABLE_NAME` = ?
                                                                              AND `COLUMN_NAME` = ?", $params);
                    if ($length) {
                        return $length;
                    } else {
                        return false;
                    }
                case "char":
                case "varchar":
                case "tinytext":
                case "text":
                case "mediumtext":
                case "longtext":
                case "binary":
                case "varbinary":
                case "tinyblob":
                case "mediumblob":
                case "blob":
                case "longblob":
                case "enum":
                case "set":
                    $length = $this->query("select", "SELECT `CHARACTER_MAXIMUM_LENGTH`
                                                                            FROM `information_schema`.`COLUMNS`
                                                                            WHERE `TABLE_SCHEMA` = ?
                                                                              AND `TABLE_NAME` = ?
                                                                              AND `COLUMN_NAME` = ?", $params);
                    if ($length) {
                        return $length["CHARACTER_MAXIMUM_LENGTH"];
                    } else {
                        return false;
                    }
                case "datetime":
                case "timestamp":
                case "time":
                    $length = $this->query("select", "SELECT `DATETIME_PRECISION`
                                                                            FROM `information_schema`.`COLUMNS`
                                                                            WHERE `TABLE_SCHEMA` = ?
                                                                              AND `TABLE_NAME` = ?
                                                                              AND `COLUMN_NAME` = ?", $params);
                    if ($length) {
                        return $length["DATETIME_PRECISION"];
                    } else {
                        return false;
                    }
                default:
                    return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Returns the name of the database that the current connection is established with.
     *
     * @return string
     */
    public function getTableSchema(): string
    {
        return $this->getDatabaseName();
    }

    /**
     * This is a helper function to speed up the process of continually coding
     * prepared statements for queries. It accepts three arguments:
     *       $type : a string indicating what type of query should be executed. It may
     *               have any one of the following values: "select single", "select
     *               multiple", "update", "insert", or "delete"
     *      $query : a string containing an SQL query
     * $parameters : an array of parameters to be bound to any "?" (question marks)
     *               found in $query. The first item in this array must always be a
     *               string that lists the to-be-expected types of all parameters
     *               thereafter, e.g. "sssiisisi".
     *               s = string (most things get cast to a string)
     *               i = integer
     *               d = double (or float; basically decimal numbers)
     *               b = blob (bytes)
     *               For more info: http://php.net/manual/en/mysqli-stmt.bind-param.php
     *
     * If %type is "update", "insert", or "delete", the function will return true or
     * false, indicating if the query was a success.
     *
     * If $type is "select single", the function will return an associative array
     * where the keys of the array are column names, and the values are the returned
     * values from the query for their respective columns.
     *
     * If $type is "select multiple", the function will return a multidimensional
     * array, where each element is an associative array, like in a result returned
     * from when $type is "select single". These arrays are indexed numerically.
     *
     * If $type is "isset", "exist", or "exists", the function will return true or
     * false, indicating if at least one row from was returned from the database or
     * not.
     *
     * @param string $type
     * @param string $query
     * @param mixed[]|null $parameters
     * @return mixed[]|bool
     */
    public function query(string $type, string $query, array $parameters = null)
    {
        $connection = $this->connect();
        $type = strtolower($type);

        switch ($type) {
            case "select single":
            case "select":

                if ($stmt = $connection->prepare($query)) {
                    if (!is_null($parameters)) {
                        call_user_func_array(array($stmt, "bind_param"), $this->refValues($parameters));
                    }
                    $stmt->execute();
                    $result = $stmt->get_result()->fetch_assoc();
                    $stmt->free_result();
                    $stmt->close();
                    return $result;
                }
                return false;
            case "select array":
            case "select multiple":

                $result = [];
                if ($stmt = $connection->prepare($query)) {
                    if (!is_null($parameters)) {
                        call_user_func_array(array($stmt, "bind_param"), $this->refValues($parameters));
                    }
                    $stmt->execute();
                    $res = $stmt->get_result();
                    while ($row = $res->fetch_assoc()) {
                        $result[] = $row;
                    }
                    $stmt->free_result();
                    $stmt->close();
                }
                if (empty($result)) {
                    return false;
                } else {
                    return $result;
                }

                break;
            case "insert":
            case "update" :
            case "delete" :
            case "truncate":

                if ($stmt = $connection->prepare($query)) {
                    if (!is_null($parameters)) {
                        call_user_func_array(array($stmt, "bind_param"), $this->refValues($parameters));
                    }
                    $result = $stmt->execute();
                    $stmt->close();
                    return $result;
                }
                return false;
            case "isset":
            case "exist":
            case "exists":

                if ($stmt = $connection->prepare($query)) {
                    if (!is_null($parameters)) {
                        call_user_func_array(array($stmt, "bind_param"), $this->refValues($parameters));
                    }
                    $stmt->execute();
                    $result = $stmt->get_result()->fetch_assoc();
                    $stmt->free_result();
                    $stmt->close();
                }
                return isset($result);
            default:
                return false;
        }
    }

    /**
     * TODO: Finish commit implementation (rollback)
     * @return bool
     * @throws Exception
     */
    public function rollbackTransaction(): bool
    {
        $connection = $this->connect();
        if ($stmt = $connection->prepare("ROLLBACK;")) {
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        throw new Exception("Unable to connect to database");
    }

    /**
     * TODO: Finish commit implementation (startTransaction)
     * @return bool
     * @throws Exception
     */
    public function startTransaction(): bool
    {
        $connection = $this->connect();
        if ($stmt = $connection->prepare("SET autocommit = 0; START TRANSACTION;")) {
            $result = $stmt->execute();
            $stmt->close();
            return $this::$inTransaction = $result;
        }
        throw new Exception("Unable to connect to database");
    }

    /**
     * @param $params array
     * @return mixed[]
     *
     * Originally created by bitWorking, April 20, 2013
     * http://stackoverflow.com/a/16120923
     */
    private function refValues($params)
    {
        if (strnatcmp(phpversion(), '5.3') >= 0) //Reference is required for PHP 5.3+
        {
            $refs = array();
            foreach ($params as $key => $value)
                $refs[$key] = &$params[$key];
            return $refs;
        }
        return $params;
    }
}