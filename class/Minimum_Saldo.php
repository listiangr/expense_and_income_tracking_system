<?php
class Minimum_Saldo{
    
  private $_formItem = [];
  private $_db = null;

  public function __construct(){
    $this->_db = DB::getInstance();
  }

  public function validate($formMethod){
    $validate = new Validate($formMethod);

    $this->_formItem['jumlah_minimum_saldo'] = $validate->setRules('jumlah_minimum_saldo',
    'Jumlah Minimum Saldo', [
      'required'  => true,
      'sanitize'  => 'int',
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


  public function insert(){
    $minimum_saldo = [
      'jumlah_minimum_saldo' => $this->getItem('jumlah_minimum_saldo'),
      'id_akun' => $this->getItem('id_akun'),
    ];

    return $this->_db->insert('minimum_saldo',$minimum_saldo);
  }

  public function generate($id){
    $result = $this->_db->getWhereOnce('minimum_saldo',['id_akun','=',$id]);
    
    if($result == false){
      return false;
    }else{
      foreach ($result as $key => $val) {
        $this->_formItem[$key] = $val;
      }
    }

  }

  public function update($id){
    $minimum_saldo = [
        'jumlah_minimum_saldo' => $this->getItem('jumlah_minimum_saldo'),
        'id_akun' => $this->getItem('id_akun'),
      ];

    $this->_db->update('minimum_saldo',$minimum_saldo,['id_akun','=',$id]);
  }

  public function delete($id){
    $this->_db->delete('minimum_saldo',['id_minimum_saldo','=',$id]);
  }
}
