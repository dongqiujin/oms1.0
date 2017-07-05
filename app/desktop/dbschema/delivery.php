<?php
$db['delivery']=array (
    'comment' => '发货单',
    'columns' =>
    array (
        'delivery_id' =>
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
        'delivery_bn' =>
        array (
            'type' => 'varchar(32)',
            'comment' => '发货单号',
        ),
        'print_status' =>
        array (
            'type' => "enum('0','1')",
            'default' => '0',
            'comment' => '打印状态:0未打印,1已打印',
        ),
        'print_time' =>
        array (
            'type' => 'int',
            'comment' => '打印时间',
        ),
        'delivery_time' =>
        array (
            'type' => 'int',
            'comment' => '发货时间',
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
        ),
        'ind_delivery_bn' =>
        array (
            'columns' =>
            array (
                0 => 'delivery_bn',
            ),
        ),
        'ind_print_status' =>
        array (
            'columns' =>
            array (
                0 => 'print_status',
            ),
        )
    ),
    'engine' => 'InnoDB',
    'charset' => 'utf8',
    'collate' => 'utf8_general_ci',
);
