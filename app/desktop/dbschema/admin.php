<?php
$db['admin']=array (
  'comment' => '后台管理员表',
  'columns' => 
  array (
    'uid' => 
    array (
      'type' => 'int',
      'required' => true,
      'primary' => true,
      'auto_increment' => true,
      'unsigned' => true,
      'comment' => '自增ID',
    ),
    'username' =>
    array (
      'type' => 'varchar(40)',
      'required' => true,
      'unique' => true,
      'comment' => '登录帐号',
    ),
    'password' =>
    array (
      'type' => 'varchar(32)',
      'required' => true,
      'comment' => '登录密码',
    ),
    'company_name' =>
    array (
      'type' => 'varchar(60)',
      'comment' => '公司名称',
    ),
    'contacts' =>
    array (
      'type' => 'varchar(20)',
      'comment' => '联系人',
    ),
    'tel' =>
    array (
      'type' => 'varchar(15)',
      'comment' => '电话',
    ),
    'fax' =>
    array (
      'type' => 'varchar(20)',
      'comment' => '传真',
    ),
    'mobile' =>
    array (
      'type' => 'varchar(15)',
      'comment' => '手机',
    ),
    'zip' =>
    array (
      'type' => 'varchar(8)',
      'comment' => '邮编',
    ),
    'email' =>
    array (
      'type' => 'varchar(50)',
      'required' => false,
      'comment' => 'email',
    ),
    'status' =>
    array (
      'type' => array(
        '1' => '成功',
    	'0' => '失败',
      ),
      'required' => true,
      'default' => '0',
      'comment' => '状态',
    ),
  ),
  'index' =>
  array (
    'ind_username' =>
    array (
        'columns' =>
        array (
          0 => 'username',
        ),
    ),
    'ind_status' =>
    array (
        'columns' =>
        array (
          0 => 'status',
        ),
    ),
  ),
  'engine' => 'InnoDB',
  'charset' => 'utf8',
  'collate' => 'utf8_general_ci',
);
