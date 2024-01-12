<?php
class AdminModel{
    
  private $_formItem = [];
  private $_db = null;

  public function __construct(){
    $this->_db = DB::getInstance();
  }

  public function validate($formMethod){
    $validate = new Validate($formMethod);

    $this->_formItem['nama'] = $validate->setRules('nama',
    'Nama', [
      'required'  => true,
      'sanitize'  => 'string',
      'max_char'  => 100,
    ]);

    $this->_formItem['email'] = $validate->setRules('email',
    'Email', [
      'required' => true,
      'sanitize' => 'string',
      'unique'   => ['admin', 'email'],
      'max_char' => 50,
    ]);

    $this->_formItem['no_telepon'] = $validate->setRules('no_telepon',
    'No Telepon', [
      'required' => true,
      'sanitize' => 'string',
      'max_char' => 20,
    ]);

    if(!$validate->passed()) {
        return $validate->getError();
    }

  }

  public function getItem($item){
    return isset($this->_formItem[$item]) ? $this->_formItem[$item] : '';
  }

  public function insert(){
    $admin = [
      'nama' => $this->getItem('nama'),
      'no_telepon' => $this->getItem('no_telepon'),
      'email' => $this->getItem('email'),
    ];

    return $this->_db->insert('admin',$admin);
  }

  public function generate($id){
    $result = $this->_db->getWhereOnce('admin',['id_admin','=',$id]);
    foreach ($result as $key => $val) {
      $this->_formItem[$key] = $val;
    }
  }


  public function update($id){
    $admin = [
        'nama' => $this->getItem('nama'),
        'no_telepon' => $this->getItem('no_telepon'),
        'email' => $this->getItem('email'),
      ];

    $this->_db->update('admin',$admin,['id_admin','=',$id]);
  }

  public function delete($id){
    $this->_db->delete('admin',['id_admin','=',$id]);
  }
}
