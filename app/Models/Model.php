<?php

namespace App\Models;

abstract class Model {
  private $databaseHost;
  private $databaseName;
  private $databaseUsername;
  private $databasePassword;
  private $conn;
  private $rows = [];

  protected $table;
  protected $primaryKey = "id";
  private $bindings = [
    "select" => ["*"],
    "where" => "",
    "limit" => "",
    "joins" => ""
  ];
  private $query;

  public function __construct() {
    $DATABASE = require(__DIR__.'/../../configs/database.php');
    $this->databaseHost = $DATABASE['db_host'];
    $this->databaseName = $DATABASE['db_database'];
    $this->databaseUsername = $DATABASE['db_username'];
    $this->databasePassword = $DATABASE['db_password'];
  }

  public static function query() {
    return new static();
  }

  public static function all() {
    return (new static())->get();
  }

  public function select($fields = ["*"]) {
    $this->bindings['select'] = $fields;
    return $this;
  }

  public function where($column, $operator, $value, $boolean = "AND") {
    $wheres = $this->bindings['where'];
    $where = ($wheres !== "") ? " $boolean" : " ";
    $where .= " $column $operator '$value'";
    $this->bindings['where'] .= $where;
    return $this;
  }

  public function orWhere($column, $operator, $value) {
    return $this->where($column, $operator, $value, "OR");
  }

  public function join($table, $foreign, $operator, $local, $type = "INNER") {
    $this->bindings['joins'] .= " $type JOIN $table ON $foreign $operator $local";
    return $this;
  }

  public function toSql() {
    $query = "SELECT ";
    $query .= join(',',$this->bindings['select']);
    $query .= " FROM ".$this->table;

    if ($this->bindings['joins'] !== "") {
      $query .= $this->bindings['joins'];
    }

    if ($this->bindings['where'] !== "") {
      $query .= " WHERE ".$this->bindings['where'];
    }


    if ($this->bindings['limit'] !== "") {
      $query .= " LIMIT ".$this->bindings['limit'];
    }
    return $query;
  }

  public function get() {
    $result = $this->execute($this->toSql());

    while($row = $result->fetch_assoc()) {
      if (!is_null($row))  {
        $this->rows[] = $row;
      }
    }

    $result->close();
    return $this->rows;
  }

  public function execute($sql = "") {
    $this->openConnection();
    $result = $this->conn->query($sql);

    if ($result === FALSE) {
        throw new \Exception($this->conn->error);
    }

    if ($this->conn->insert_id > 0) {
      $this->fill([$this->primaryKey => $this->conn->insert_id]);
    }

    $this->closeConnection();
    return $result;
  }

  public function fill($attributes = []) {
    foreach($attributes as $key => $value) {
      $this->$key = $value;
    }
  }

  public function limit($limit = 1) {
    $this->bindings["limit"] = $limit;
    return $this;
  }

  public function count() {
    return count($this->get());
  }

  public function first() {
    $result = $this->limit(1)->get();
    if (count($result) > 0) {
      $this->fill($result[0]);
      $this->rows = [];
      return $this;
    } else {
      return NULL;
    }
  }

  public static function find($id = 0) {
    $instance = self::query();
    return $instance->where($instance->primaryKey, '=', $id)->first();
  }

  public function save() {
    $methods = get_class_vars(static::class);
    $attributes = array_diff_key(get_object_vars($this), $methods);

    if (count($attributes) === 0) {
      throw new \Exception("No se han asignado ningun atributo.");
    }

    $attributesKeys = array_keys($attributes);
    $attributesValues = array_map(
      function($value) {
        return "'$value'";
      },
      array_values($attributes)
    );

    if (empty($this->id)) {
      $sql = "INSERT INTO $this->table (".join(',', $attributesKeys).") ";
      $sql .= "VALUES(".join(',', $attributesValues).")";
    } else {
      if (empty($this->id)) {
        throw new \Exception("El modelo no tiene definido un identificador unico.");
      }
      $attributes = array_map(function($value, $key) {
        return "$key = $value";
      },  $attributesValues, $attributesKeys);
      $sql = "UPDATE $this->table SET ".join(',', $attributes);
      $sql .= " WHERE $this->primaryKey = $this->id";
    }


    return $this->execute($sql);
  }

  public function delete() {
    if (empty($this->id)) {
      throw new \Exception("El modelo no tiene definido un identificador unico.");
    }
    $result = $this->execute("DELETE FROM $this->table WHERE $this->primaryKey = $this->id");
    $result->close();
    return true;
  }


  public function belongsTo($class, $localKey) {
    $model = call_user_func([$class, 'query']);
    $objectProperties = get_object_vars($this);

    if (empty($this->id)) {
      throw new \Exception(
        "El modelo no ha sido guardado o no posee un identificador unico."
      );
    }

    if (empty($objectProperties[$localKey])) {
      throw new \Exception("El objeto no cuenta con la propiedad $localKey.");
    }

    return $model->where($model->primaryKey, '=', $objectProperties[$localKey])
      ->first();
  }

  public function belongsToMany($class, $pivotTable, $primaryForeignKey, $secondaryForeignKey) {
    $model = call_user_func([$class, 'query']);

    if (empty($this->id)) {
      throw new \Exception(
        "El modelo no ha sido guardado o no posee un identificador unico."
      );
    }

    return $model->select([$model->table.".*"])
      ->join($pivotTable, $pivotTable . "." . $secondaryForeignKey, "=", $model->table . "." . $this->primaryKey)
      ->where($pivotTable . "." . $primaryForeignKey, "=", $this->id);
  }

  public function hasMany($class, $foreignKey, $localKey = NULL) {
      $model = call_user_func([$class, 'query']);

      if (empty($this->id)) {
        throw new \Exception(
          "El modelo no ha sido guardado o no posee un identificador unico."
        );
      }
      return $model->where($foreignKey, '=', (is_null($localKey)) ? $this->id : $this->$localKey);
  }

  public function openConnection() {
    $this->conn = new \mysqli(
        $this->databaseHost,
        $this->databaseUsername,
        $this->databasePassword,
        $this->databaseName
      );
    $this->conn->set_charset('utf8');
  }

  public function closeConnection() {
    $this->conn->close();
    $this->conn = NULL;
  }

}
