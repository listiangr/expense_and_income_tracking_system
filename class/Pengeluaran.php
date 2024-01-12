<?php
class Pengeluaran{
    
  private $_formItem = [];
  private $_db = null;

  public function __construct(){
    $this->_db = DB::getInstance();
  }

  public function validate($formMethod){
    $validate = new Validate($formMethod);

    $this->_formItem['jumlah_pengeluaran'] = $validate->setRules('jumlah_pengeluaran',
    'Jumlah Pengeluaran', [
      'required'  => true,
      'sanitize'  => 'int',
    ]);

    $this->_formItem['deskripsi_pengeluaran'] = $validate->setRules('deskripsi_pengeluaran',
    'Deskripsi Pengeluaran', [
      'required' => false,
      'sanitize' => 'string',
      'max_char' => 100,
    ]);

    $this->_formItem['tanggal_pengeluaran'] = $validate->setRules('tanggal_pengeluaran',
    'Tanggal Pengeluaran', [
      'required'  => true,
      'sanitize'  => 'string',
    ]);

    $this->_formItem['id_akun'] = $validate->setRules('id_akun',
    'ID Akun', [
      'required'  => true,
      'sanitize'  => 'int',
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
    $pengeluaran = [
      'jumlah_pengeluaran' => $this->getItem('jumlah_pengeluaran'),
      'deskripsi_pengeluaran' => $this->getItem('deskripsi_pengeluaran'),
      'tanggal_pengeluaran' => $this->getItem('tanggal_pengeluaran'),
      'id_akun' => $this->getItem('id_akun'),
    ];

    return $this->_db->insert('pengeluaran',$pengeluaran);
  }

  public function generate($id){
    $result = $this->_db->getWhereOnce('pengeluaran',['id_pengeluaran','=',$id]);
    foreach ($result as $key => $val) {
      $this->_formItem[$key] = $val;
    }
  }

  public function checkAkun($username, $password){

    return $result = $this->_db->checkTwoCondition('pengeluaran', 'username', 'password', [$username, $password]);

  }

  public function update($id){
    $pengeluaran = [
      'username' => $this->getItem('username'),
      'deskripsi_pengeluaran' => $this->getItem('deskripsi_pengeluaran'),
      'tanggal_pengeluaran' => $this->getItem('tanggal_pengeluaran'),
      'id_akun' => $this->getItem('id_akun'),
    ];

    $this->_db->update('pengeluaran',$pengeluaran,['id_pengeluaran','=',$id]);
  }

  public function delete($id){
    $this->_db->delete('pengeluaran',['id_pengeluaran','=',$id]);
  }
}
