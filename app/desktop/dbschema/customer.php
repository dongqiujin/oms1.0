<?php
$db['customer']=array (
    'comment' => '客户信息表',
    'columns' =>
    array (
        'cus_id' =>
        array (
            'type' => 'int',
            'required' => true,
            'primary' => true,
            'auto_increment' => true,
            'unsigned' => true,
            'comment' => '自增ID',
        ),
        'cus_bn' =>
        array (
            'type' => 'varchar(40)',
            'comment' => '客户代号',
        ),
        'cus_name' =>
        array (
            'type' => 'varchar(40)',
            'comment' => '客户公司简称',
        ),
        'cus_company' =>
        array (
            'type' => 'varchar(40)',
            'comment' => '客户公司全称',
        ),
        'cus_contacts' =>
        array (
            'type' => 'varchar(40)',
            'comment' => '联系人',
        ),
        'cus_address' =>
        array (
            'type' => 'varchar(80)',
            'comment' => '公司地址',
        ),
        'cus_tel' =>
        array (
            'type' => 'varchar(15)',
            'comment' => '电话',
        ),
        'cus_fax' =>
        array (
            'type' => 'varchar(15)',
            'comment' => '传真',
        ),
        'cus_mobile' =>
        array (
            'type' => 'varchar(15)',
            'comment' => '手机',
        ),
        'cus_zip' =>
        array (
            'type' => 'varchar(8)',
            'comment' => '邮编',
        ),
        'create_time' =>
        array (
            'type' => 'int',
            'comment' => '创建时间',
        ),
    ),
    'engine' => 'InnoDB',
    'charset' => 'utf8',
    'collate' => 'utf8_general_ci',
);
