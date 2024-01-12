<?php
class DB{
  private $_host = '127.0.0.1';
  private $_dbname = 'db_expense_tracker';
  private $_username = 'root';
  private $_password = '';

  private static $_instance = null;
  private $_pdo;
  private $_columnName = "*";
  private $_orderBy = "";
  private $_count = 0;

  private function __construct(){
    try {
      $this->_pdo = new PDO('mysql:host='.$this->_host.';dbname='.$this->_dbname,
                             $this->_username, $this->_password);
    } catch (PDOException $e){
      die("Error ".$e->getMessage(). " (".$e->getCode().")");
    }
  }

  // Singleton pattern
  public static function getInstance(){
    if(!isset(self::$_instance)) {
      self::$_instance = new DB();
    }
    return self::$_instance;
  }

  // prepared statement query
  public function runQuery($query, $bindValue = []){
    try {
      $stmt = $this->_pdo->prepare($query);
      $stmt->execute($bindValue);
    }
    catch (PDOException $e){
      die("Error: ".$e->getMessage(). " (".$e->getCode().")");
    }
    return $stmt;
  }

  // show query SELECT as fetchAll (object)
  public function getQuery($query,$bindValue = []){
    return $this->runQuery($query,$bindValue)->fetchAll(PDO::FETCH_OBJ);
  }

  // select column
  public function select($columnName){
    $this->_columnName = $columnName;
    return $this;
  }

  // query orderBy
  public function orderBy($columnName, $sortType = 'ASC'){
    $this->_orderBy = "ORDER BY {$columnName} {$sortType}";
    return $this;
  }

  // get table data
  public function get($tableName, $condition = "", $bindValue = []){
    $query = "SELECT {$this->_columnName} FROM {$tableName} {$condition} {$this->_orderBy}";
    $this->_columnName = "*";
    $this->_orderBy = "";
    return $this->getQuery($query, $bindValue);
  }

  // WHERE condition
  public function getWhere($tableName, $condition){
    $queryCondition ="WHERE {$condition[0]} {$condition[1]} ? ";
    return $this->get($tableName,$queryCondition,[$condition[2]]);
  }

  // WHERE but only once
  public function getWhereOnce($tableName, $condition){
    $result = $this->getWhere($tableName,$condition);
    if (!empty($result)) {
      return $result[0];
    } else {
      return false;
    }
  }

  // query LIKE
  public function getLike($tableName, $columnLike, $search){
    $queryLike = "WHERE {$columnLike} LIKE ?";
    return $this->get($tableName,$queryLike,[$search]);
  }

  // check if value unique or not
  public function check($tableName, $columnName, $dataValues){
    $query = "SELECT {$columnName} FROM {$tableName} WHERE {$columnName} = ? ";
    return $this->runQuery($query,[$dataValues])->rowCount();
  }

  // check two condition
  public function checkTwoCondition($tableName, $columnName1, $columnName2, $dataValues){
    $query = "SELECT {$columnName1} FROM {$tableName} WHERE {$columnName1} = ? and {$columnName2} = ? ";
    return $this->runQuery($query,[$dataValues[0], $dataValues[1]])->rowCount();
  }

   // range 
   public function range($tableName, $columnName1, $columnName2, $dataValues){
    $query = "SELECT * FROM {$tableName} WHERE {$columnName1} = ? and {$columnName2} BETWEEN ? and ? ";
    //return $this->runQuery($query,[$dataValues[0], $dataValues[1]]);
    return $this->getQuery($query, [$dataValues[0], $dataValues[1], $dataValues[2]]);
  }
  
  // row_count
  public function count(){
    return $this->_count;
  }

  // INSERT Query
  public function insert($tableName, $data){
    $dataKeys = array_keys($data);
    $dataValues = array_values($data);
    $placeholder = '('.str_repeat('?,', count($data)-1) . '?)';

    $query = "INSERT INTO {$tableName} (".implode(', ',$dataKeys).") VALUES {$placeholder}";
    $this->_count = $this->runQuery($query,$dataValues)->rowCount();
    return true;
  }

  // UPDATE Query
  public function update($tableName, $data, $condition){
    $query = "UPDATE {$tableName} SET ";
    foreach ($data as $key => $val){
      $query .= "$key = ?, " ;
    }
    $query = substr($query,0,-2);
    $query .= " WHERE {$condition[0]} {$condition[1]} ?";

    $dataValues = array_values($data);
    array_push($dataValues,$condition[2]);

    $this->_count = $this->runQuery($query,$dataValues)->rowCount();
    return true;
  }

  // DELETE Query
  public function delete($tableName, $condition){
    $query = "DELETE FROM {$tableName} WHERE {$condition[0]} {$condition[1]} ? ";
    $this->_count = $this->runQuery($query,[$condition[2]])->rowCount();
    return true;
  }



}
