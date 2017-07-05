<?php
$db['delivery_item']=array (
    'comment' => '发货明细表',
    'columns' =>
    array (
        'item_id' =>
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
        'delivery_id' =>
        array (
            'type' => 'int',
            'required' => true,
            'unsigned' => true,
            'comment' => '发货单ID',
        ),
        'order_id' =>
        array (
            'type' => 'int',
            'required' => true,
            'unsigned' => true,
            'comment' => '订单ID',
        ),
        'order_bn' =>
        array (
            'type' => 'varchar(20)',
            'comment' => '订单号',
        ),
        'type' =>
        array (
            'type' => 'int',
            'default' => '1',
            'comment' => '类型',
        ),
		'goods_type' =>
        array (
            'type' => array(
				'goods' => '商品',
				'products' => '配件'
			),
			'default' => 'goods',
            'comment' => '类型',
        ),
		'name' =>
        array (
            'type' => 'varchar(100)',
            'comment' => '名称',
        ),
        'length' =>
        array (
            'type' => 'varchar(8)',
            'default' => '0',
            'comment' => '长',
        ),
        'width' =>
        array (
            'type' => 'varchar(8)',
            'default' => '0',
            'comment' => '宽',
        ),
        'height' =>
        array (
            'type' => 'varchar(8)',
            'default' => '0',
            'comment' => '高',
        ),
        'num' =>
        array (
            'type' => 'int',
            'default' => '0',
            'comment' => '订购数量',
        ),
        'send_num' =>
        array (
            'type' => 'int',
            'default' => '0',
            'comment' => '发货数量',
        ),
        'price' =>
        array (
            'type' => 'decimal(20,4)',
            'default' => '0',
            'comment' => '单价',
        ),
        'amount' =>
        array (
            'type' => 'decimal(20,4)',
            'default' => '0',
            'comment' => '金额',
        ),
        'memo' =>
        array (
            'type' => 'varchar(80)',
            'comment' => '备注',
        ),
    ),
    'index' =>
    array (
        'ind_delivery_id' =>
        array (
            'columns' =>
            array (
                0 => 'delivery_id',
            ),
        ),
        'ind_order_id' =>
        array (
            'columns' =>
            array (
                0 => 'order_id',
            ),
        ),
    ),
    'engine' => 'InnoDB',
    'charset' => 'utf8',
    'collate' => 'utf8_general_ci',
);
