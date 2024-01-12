<?php
class Pemasukan{
    
  private $_formItem = [];
  private $_db = null;

  public function __construct(){
    $this->_db = DB::getInstance();
  }

  public function validate($formMethod){
    $validate = new Validate($formMethod);

    $this->_formItem['jumlah_pemasukan'] = $validate->setRules('jumlah_pemasukan',
    'Jumlah Pemasukan', [
      'required'  => true,
      'sanitize'  => 'int',
    ]);

    $this->_formItem['deskripsi_pemasukan'] = $validate->setRules('deskripsi_pemasukan',
    'Deskripsi Pemasukan', [
      'required' => false,
      'sanitize' => 'string',
      'max_char' => 100,
    ]);

    $this->_formItem['tanggal_pemasukan'] = $validate->setRules('tanggal_pemasukan',
    'Tanggal Pemasukan', [
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
    $pemasukan = [
      'jumlah_pemasukan' => $this->getItem('jumlah_pemasukan'),
      'deskripsi_pemasukan' => $this->getItem('deskripsi_pemasukan'),
      'tanggal_pemasukan' => $this->getItem('tanggal_pemasukan'),
      'id_akun' => $this->getItem('id_akun'),
    ];

    return $this->_db->insert('pemasukan',$pemasukan);
  }

  public function generate($id){
    $result = $this->_db->getWhereOnce('pemasukan',['id_pemasukan','=',$id]);
    foreach ($result as $key => $val) {
      $this->_formItem[$key] = $val;
    }
  }

  public function checkAkun($username, $password){

    return $result = $this->_db->checkTwoCondition('pemasukan', 'username', 'password', [$username, $password]);

  }

  public function update($id){
    $pemasukan = [
        'jumlah_pemasukan' => $this->getItem('jumlah_pemasukan'),
        'deskripsi_pemasukan' => $this->getItem('deskripsi_pemasukan'),
        'tanggal_pemasukan' => $this->getItem('tanggal_pemasukan'),
        'id_akun' => $this->getItem('id_akun'),
      ];

    $this->_db->update('pemasukan',$pemasukan,['id_pengeluaran','=',$id]);
  }

  public function delete($id){
    $this->_db->delete('pemasukan',['id_pemasukan','=',$id]);
  }
}
