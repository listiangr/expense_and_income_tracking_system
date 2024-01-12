<?php
class Akun{
    
  private $_formItem = [];
  private $_db = null;

  public function __construct(){
    $this->_db = DB::getInstance();
  }

  public function validate($formMethod){
    $validate = new Validate($formMethod);

    $this->_formItem['username'] = $validate->setRules('username',
    'Username', [
      'required'  => true,
      'sanitize'  => 'string',
      'unique'   => ['akun', 'username'],
      'max_char'  => 255,
    ]);

    $this->_formItem['password'] = $validate->setRules('password',
    'Password', [
      'required' => true,
      'sanitize' => 'string',
      'max_char' => 255,
    ]);


    if(!$validate->passed()) {
        return $validate->getError();
    }

  }

  public function getItem($item){
    return isset($this->_formItem[$item]) ? $this->_formItem[$item] : '';
  }

  public function setId_User($value){
    $this->_formItem['id_user'] = $value;
  }

  public function insert(){
    $akun = [
      'username' => $this->getItem('username'),
      'password' => $this->getItem('password'),
      'id_user' => $this->getItem('id_user'),
    ];

    return $this->_db->insert('akun',$akun);
  }

  public function generate($id){
    $result = $this->_db->getWhereOnce('akun',['id_akun','=',$id]);
    foreach ($result as $key => $val) {
      $this->_formItem[$key] = $val;
    }
  }

  public function checkAkun($username, $password){

    return $result = $this->_db->checkTwoCondition('akun', 'username', 'password', [$username, $password]);

  }

  public function update($id){
    $akun = [
        'username' => $this->getItem('username'),
        'password' => $this->getItem('password'),
        'id_user' => $this->getItem('id_user'),
    ];

    $this->_db->update('akun',$akun,['id_akun','=',$id]);
  }

  public function delete($id){
    $this->_db->delete('akun',['id_akun','=',$id]);
  }
}
