<?php
class delivery extends base_model
{
    var $pk = "delivery_id";
    var $table = "desktop_delivery";

    // 表关联
    public $linker = array(
        array(
            'type' => 'hasmany',
            'map' => 'delivery_item',// 发货单明细表
            'mapkey' => 'delivery_id',
            'fclass' => 'deliveryItem',
            'fkey' => 'delivery_id',
            'enabled' => true,
        ),
    );
}