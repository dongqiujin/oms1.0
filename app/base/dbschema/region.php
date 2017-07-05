<?php
$db['region']=array (
  'comment' => '地区表' ,
  'columns' =>
  array (
    'region_id' =>
    array (
      'type' => 'int',
      'required' => true,
      'primary' => true,
      'auto_increment' => true,
      'unsigned' => true,
      'comment' => '地区ID',
    ),
	'parent_id' =>
    array (
      'type' => 'int',
      'default' => '0',
      'comment' => '上级地区ID',
    ),
    'region_name' =>
    array (
      'type' => 'varchar(100)',
      'comment' => '地区名称',
    ),
	'region_type' =>
    array (
      'type' => 'smallint',
      'default' => '0',
      'comment' => '地区级别类型',
    ),
  ),
  'index' =>
  array (
	'ind_parent_id' =>
    array (
      'columns' =>
      array (
        0 => 'parent_id',
      ),
    ),
    'ind_region_type' =>
    array (
      'columns' =>
      array (
        0 => 'region_type',
      ),
    ),
  ),
  'engine' => 'InnoDB',
  'charset' => 'utf8',
  'collate' => 'utf8_general_ci',
);
