<?php
$db['order']=array (
    'comment' => '订单表',
    'columns' =>
    array (
        'order_id' =>
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
        'order_bn' =>
        array (
            'type' => 'varchar(32)',
            'comment' => '订单号',
        ),
        'status' =>
        array (
            'type' => "enum('active','cancel')",
            'default' => 'active',
            'comment' => '订单状态:active正常,cancel取消',
        ),
        'ship_status' =>
        array (
            'type' => "enum('0','1','2')",
            'default' => '0',
            'comment' => '发货状态:0未发货,1已发货,2部分发货',
        ),
        'type' =>
        array (
            'type' => 'int',
            'comment' => '类型',
        ),
        'type_price' =>
        array (
            'type' => 'decimal(20,4)',
            'comment' => '类型价格',
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
            'comment' => '已发数量',
        ),
        'price' =>
        array (
            'type' => 'decimal(20,4)',
            'comment' => '单价',
        ),
        'amount' =>
        array (
            'type' => 'decimal(20,4)',
            'comment' => '金额',
        ),
        'memo' =>
        array (
            'type' => 'varchar(80)',
            'comment' => '备注',
        ),
        'create_time' =>
        array (
            'type' => 'int',
            'comment' => '下单时间',
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
        'ind_order_bn' =>
        array (
            'columns' =>
            array (
                0 => 'order_bn',
            ),
        ),
        'ind_ship_status' =>
        array (
            'columns' =>
            array (
                0 => 'ship_status',
            ),
        )
    ),
    'engine' => 'InnoDB',
    'charset' => 'utf8',
    'collate' => 'utf8_general_ci',
);
