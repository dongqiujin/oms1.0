<?php
$db['customer_price']=array (
    'comment' => '客户价格表',
    'columns' =>
    array (
        'price_id' =>
        array (
            'type' => 'int',
            'required' => true,
            'primary' => true,
            'auto_increment' => true,
            'unsigned' => true,
            'comment' => '自增ID',
        ),
        'cus_id' =>
        array (
            'type' => 'int',
            'required' => true,
            'unsigned' => true,
            'comment' => '客户ID',
        ),
        'type' =>
        array (
            'type' => 'int',
            'comment' => '类型',
        ),
        'product_name' =>
        array (
            'type' => 'varchar(32)',
            'comment' => '产品名称',
        ),
        'product_size' =>
        array (
            'type' => 'varchar(32)',
            'comment' => '产品尺寸',
        ),
        'product_color' =>
        array (
            'type' => 'varchar(32)',
            'comment' => '产品颜色',
        ),
        'price' =>
        array (
            'type' => 'varchar(100)',
            'comment' => '价格',
        ),
    ),
    'index' =>
    array (
        'ind_cus_id' =>
        array (
            'columns' =>
            array (
                0 => 'cus_id',
            ),
        )
    ),
    'engine' => 'InnoDB',
    'charset' => 'utf8',
    'collate' => 'utf8_general_ci',
);
