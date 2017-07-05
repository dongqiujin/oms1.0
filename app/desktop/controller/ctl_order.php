<?php
/**
* 订单管理
* @author Mr 2013.11.7
*/
class ctl_order extends desktop_controller {

    public $_shipStatus = array('0' => '未发货', '1' => '已发货', '2' => '部分发货');

    public function index()
    {
        $args = $this->spArgs();
        $pageSize = 5000;
        $page = $args['p'] ? $args['p'] : 1;
		$offset = ($page-1)*$pageSize;
        //当前url
        $this->selfUrl = spUrl('desktop', 'ctl_order', 'index', array_filter($args));

        $this->cus_id = $args['cus_id'];
        if ($args['sort_name']){
            $sort = $args['sort_name'] . ' ' . $args['sort_type'];
        }else{
            $sort = 'create_time desc';
        }

        //客户信息
        $customerModel = spBase::new_class('desktop_mdl_customer');
        if ($this->cus_id) {
            $this->customer = $customerModel->find(array('cus_id'=>$this->cus_id));
        }

        //所有客户列表
        $this->customerList = $customerModel->findAll(array('1'=>'1'));

        if ($args['ship_status'] == ''){
            $args['ship_status'] = 'waiting';
        }
        if (!$args['cus_id']) $this->allCustomer = 'true';

        $filter = array('1'=>'1');
        if ($args['order_bn']){
            $filter['order_bn'] = $args['order_bn'];
            unset($args['ship_status']);
            $this->order_bn = $args['order_bn'];
        }
        if ($args['ship_status'] != ''){
            switch($args['ship_status']) {
                case 'waiting':
                    $filter['ship_status|<>'] = '1';
                    break;
                case 'all':
                    break;
                default:
                    $filter['ship_status'] = $args['ship_status'];
            }
            $this->ship_status = $args['ship_status'];
        }
        if ($this->cus_id){
            $filter['cus_id'] = $this->cus_id;
        }
        if ($args['from_create_time']){
            $filter['create_time|>='] = strtotime($args['from_create_time'] . ' 00:00:00');
            $this->from_create_time = $args['from_create_time'];
        }
        if ($args['to_create_time']){
            $filter['create_time|<='] = strtotime($args['to_create_time'] . ' 23:59:59');
            $this->to_create_time = $args['to_create_time'];
        }

        //产品名称
        if ($args['product_name']){
            $filter['name'] = $args['product_name'];
            $this->product_name = $args['product_name'];
        }

        //尺寸
        if ($args['product_size']){
            $filter['size'] = !strstr($args['product_size'], '寸') ? $args['product_size'].'寸' : $args['product_size'];
            $this->product_size = $args['product_size'];
        }

        //颜色
        if ($args['product_color']){
            $filter['color'] = $args['product_color'];
            $this->product_color = $args['product_color'];
        }

        //发货时间
        $fromDeliveryTime = $args['from_delivery_time'];
        $toDeliveryTime = $args['to_delivery_time'];
        if ($fromDeliveryTime && $toDeliveryTime){
            $filterOrder['delivery_time|>='] = strtotime($fromDeliveryTime . ' 00:00:00');
            $filterOrder['delivery_time|<='] = strtotime($toDeliveryTime . ' 23:59:59');
            $dlyModel = spBase::new_class('desktop_mdl_delivery');
            $dlyOrderModel = spBase::new_class('desktop_mdl_deliveryOrder');
            $deliveryList = $dlyModel->findAll($filterOrder);
            if ($deliveryList) {
                $dlyIds = array();
                foreach ($deliveryList as $val) {
                    $dlyIds[] = $val['delivery_id'];
                }
            }
            if ($dlyIds) {
                $filterDlyOrder['delivery_id|IN'] = '('.implode(',', $dlyIds).')';
                $deliveryOrderList = $dlyOrderModel->findAll($filterDlyOrder);
                if ($deliveryOrderList) {
                    $oids = array();
                    foreach ($deliveryOrderList as $k => $v) {
                        $oids[] = $v['order_id'];
                    }
                    $filter['order_id|IN'] = '('.implode(',', $oids).')';
                }
            }
            $this->from_delivery_time = $fromDeliveryTime;
            $this->to_delivery_time = $toDeliveryTime;
        }

// echo "<pre>";print_r($filter);
        $ordersModel = spBase::new_class('desktop_mdl_order');
        $order_list = $ordersModel->spPager($page, $pageSize)->findAll($filter,$sort,'*', $offset.','.$pageSize);
        $this->pager = $ordersModel->spPager()->getPager();

        //标签数量统计
        $countFilter = array('1'=>'1');
        if ($this->cus_id) {
            $countFilter['cus_id'] = $this->cus_id;
        }
        //全部
        $this->counterAll = $ordersModel->findCount($countFilter);
        //待发货
        $countFilter['ship_status|<>'] = '1';
        $this->counterWaiting = $ordersModel->findCount($countFilter);
        unset($countFilter['ship_status|<>']);
        //已发货
        $countFilter['ship_status'] = '1';
        $this->counterShiped = $ordersModel->findCount($countFilter);

        if ($order_list){
            $paperType = spBase::new_class('desktop_func')->getPaperType();
            $deliveryOrderModel = spBase::new_class('desktop_mdl_deliveryOrder');
            $deliveryModel = spBase::new_class('desktop_mdl_delivery');
            foreach ( $order_list as $key=>$orders ){
                $customer = $customerModel->find(array('cus_id'=>$orders['cus_id']));
                $order_list[$key]['cus_name'] = $customer['cus_name'];

                // 纸张类型
                $order_list[$key]['type_name'] = $paperType[$orders['type']]['full_name'];

                $order_list[$key]['ship_status_name'] = $this->_shipStatus[$orders['ship_status']];

                //发货时间
                $dlyOrders = $deliveryOrderModel->find(array('order_id' => $orders['order_id']));
                $dlys = $deliveryModel->find(array('delivery_id' => $dlyOrders['delivery_id']));
                $order_list[$key]['delivery_time'] = $dlys['delivery_time'];
            }
        }

        //统计
        //----产品、尺寸、颜色
        $sql = 'select name,size,color,sum(num) num,sum(send_num) send_num from desktop_order '.$ordersModel->getWhereSql($filter) . ' GROUP BY name,size,color';
        $rs = $ordersModel->findSql($sql);
        // echo "<pre>";
        // print_r($rs);exit;
        $this->total_products_all = $rs;

        //----产品
        $sql = 'select name,sum(num) num,sum(send_num) send_num from desktop_order '.$ordersModel->getWhereSql($filter) . ' GROUP BY name';
        $rs = $ordersModel->findSql($sql);
        $this->total_products_name = $rs;

        //----尺寸
        $sql = 'select size,sum(num) num,sum(send_num) send_num from desktop_order '.$ordersModel->getWhereSql($filter) . ' GROUP BY size';
        $rs = $ordersModel->findSql($sql);
        $this->total_products_size = $rs;

        //----颜色
        $sql = 'select color,sum(num) num,sum(send_num) send_num from desktop_order '.$ordersModel->getWhereSql($filter) . ' GROUP BY color';
        $rs = $ordersModel->findSql($sql);
        $this->total_products_color = $rs;

        $this->order_list = $order_list;
        $this->sort_name = $args['sort_name'];
        $this->sort_type = $args['sort_type'];
        if ($filter){
            foreach ($filter as $key=>$val){
                $this->$key = $val;
            }
        }
        $this->display('order/order_list.html');
    }

    public function add(){
        $args = $this->spArgs();
        $this->cus_id = $args['cus_id'];
        $filter = array('cus_id'=>$this->cus_id);

        // 纸张类型
        $paperType = spBase::new_class('desktop_func')->getPaperType();

        //客户信息
        $cusModel = spBase::new_class('desktop_mdl_customer');
        $customer = $cusModel->find($filter);

        //客户产品价格列表
        $cusPriceModel = spBase::new_class('desktop_mdl_customerPrice');
        $productList = $cusPriceModel->findAll($filter);
        $pPriceList = $pNameList = $pSizeList = $pColorList = array();
        foreach ($productList as $k => $v) {
            $pNameList[] = $v['product_name'];
            $pSizeList[] = $v['product_size'];
            $pColorList[] = $v['product_color'];
        }

        $this->pNameList = array_unique($pNameList);
        $this->pSizeList = array_unique($pSizeList);
        $this->pColorList = array_unique($pColorList);

        $this->customer = $customer;
        $this->display('order/add.html');
    }

    /**
     * 获取会员产品的价格
     * @return echo json
     */
    public function getMemberPrice()
    {
        $args = $this->spArgs();

        $cusPriceModel = spBase::new_class('desktop_mdl_customerPrice');
        $productDetail = $cusPriceModel->find(array('product_name' => $args['product_name'], 'product_size' => $args['product_size'], 'product_color' => $args['product_color']));
        $price = explode(',', $productDetail['price']);

        $arr = array(
            'rsp' => 'succ',
            'nums' => $productDetail['price'] ? count($price) : 0,
            'data' => $price
        );
        echo json_encode($arr);
        exit;
    }

    public function doSave()
    {
        $args = $this->spArgs();
        $rs = array('rsp'=>'fail','msg'=>'');
        //组织数据
        $cusId = $args['cus_id'];
        $num = $args['num'];
        $length = $args['length'];
        $width = $args['width'];
        $height = $args['height'];
        $type = $args['type'];
        $typePrice = $args['price'];
        $salePrice = $args['sale_price'];
        $amount = $args['amount'];
        $memo = $args['memo'];
        $name = $args['product_name'];
        $size = $args['product_size'];
        $color = $args['product_color'];
        $createTime = time();
        $orderModel = spBase::new_class('desktop_mdl_order');
        if ($num) {
            foreach ($num as $key=>$val) {
				$orderSdf = array(
					'cus_id' => $cusId,
					'order_bn' => $this->getBn(),
					'goods_type' => 'products',
					'type_price' => $typePrice[$key],
					'name' => $name[$key],
                    'size' => $size[$key],
                    'color' => $color[$key],
                    'length' => $length[$key],
                    'width' => $width[$key],
					'num' => $num[$key],
					'price' => $salePrice[$key],
					'amount' => $amount[$key],
					'memo' => $memo[$key],
					'create_time' => $createTime
				);
                $orderModel->create($orderSdf);
            }
        }

        $rs['msg'] = '下单成功';
        $rs['rsp'] = 'succ';
        die(json_encode($rs));
    }

    public function delivery()
    {
        $args = $this->spArgs();
        $this->cus_id = $args['cus_id'];
        $this->backUrl = $args['selfUrl'];

        //客户信息
        $cusModel = spBase::new_class('desktop_mdl_customer');
        $this->customer = $cusModel->find(array('cus_id'=>$this->cus_id));

        $filter = array();
        if ($args['order_id']){
            $filter['order_id|IN'] = '('. implode(',', $args['order_id']) .')';
        }

        $ordersModel = spBase::new_class('desktop_mdl_order');
        $order_list = $ordersModel->findAll($filter);

        if ($order_list){
            // 纸张类型
            $paperType = spBase::new_class('desktop_func')->getPaperType();
            foreach ( $order_list as $key=>$orders ){
                $order_list[$key]['type_name'] = $paperType[$orders['type']]['full_name'];
            }
        }
        $this->order_list = $order_list;
        $this->display('order/delivery.html');
    }

    public function makeDelivery()
    {
        $args = $this->spArgs();
        $result = array('rsp' => 'fail', 'msg' => '');
        $sendNum = $args['send_num'];
        if ($sendNum) {
            foreach ($sendNum as $key=>$num) {
                if (!$num) {
                    unset($sendNum[$key]);
                }
            }
        }
        if (empty($sendNum)){
            $result['rsp'] = 'fail';
            $result['res'] = '请选择订单';
            die(json_encode($result));
        }

        if (empty($args['cus_id'])){
            $result['rsp'] = 'fail';
            $result['res'] = '请选择客户';
            die(json_encode($result));
        }

        $dlyMdl = spBase::new_class('desktop_mdl_delivery');
        $deliverySdf = array(
            'delivery_bn' => $this->getDeliveryBn(),
            'cus_id' => $args['cus_id'],
            'delivery_time' => time()
        );
        if ($deliveryId = $dlyMdl->create($deliverySdf)) {
            $ordersModel = spBase::new_class('desktop_mdl_order');
            $dlyItemModel = spBase::new_class('desktop_mdl_deliveryItem');
            $dlyOrderModel = spBase::new_class('desktop_mdl_deliveryOrder');
            foreach ($sendNum as $order_id => $num) {
                $filter = array('order_id' => $order_id);
                $orders = $ordersModel->find($filter);

				//发货单明细
				$deliveryItems = array(
					'delivery_id' => $deliveryId,
					'cus_id' => $args['cus_id'],
					'order_id' => $order_id,
					'order_bn' => $orders['order_bn'],
					'type' => $orders['type'],
					'goods_type' => 'products',
					'name' => $orders['name'],
                    'size' => $orders['size'],
                    'color' => $orders['color'],
                    'length' => $orders['length'],
                    'width' => $orders['width'],
					'num' => $orders['num'],
					'send_num' => $num,
					'price' => $orders['price'],
					'amount' => round($orders['price']*$num,3),
					'memo' => $orders['memo']
				);

                if ($dlyItemModel->create($deliveryItems)) {
                    //更新订单发货状态及发货数量
                    $sendNum = $orders['send_num'] + $num;
                    $orderUpdateSdf = array(
                        'send_num' => $sendNum,
                        'ship_status' => $orders['num'] <= $sendNum ? '1' : '2',
                    );
                    $ordersModel->update($filter, $orderUpdateSdf);

                    //记录发货单订单关联数据
                    $dlyOrderSdf = array(
                        'delivery_id' => $deliveryId,
                        'order_id' => $order_id,
                    );
                    if (!$dlyOrderModel->create($dlyOrderSdf)) {
                        $result['msg'] = '生成发货单失败';
                        die(json_encode($result));
                    }
                }
            }
            $result['rsp'] = 'succ';
            $result['msg'] = '生成发货单成功';
            die(json_encode($result));
        } else {
            $result['msg'] = '生成发货单失败';
            die(json_encode($result));
        }
    }

    function getDeliveryBn(){
        $dModel = spBase::new_class('desktop_mdl_delivery');
        $today = date('Ymd');
        $dly = $dModel->find(array('delivery_bn|like' => $today),'', 'max(delivery_bn) AS delivery_bn');
        if (empty($dly) || !$dly['delivery_bn']) {
            $newBn = str_pad($today, 11, '0');
        } else {
            $newBn = $dly['delivery_bn'];
        }
        $i = 1;
        do{
            if($i >= 999){
                exit('请联系管理员');
            }
            $i++;
            $newBn += 1;
            $d = $dModel->findCount(array('delivery_bn' => $newBn));
        }while($d);

        return $newBn;
    }

    function getBn(){
        $oModel = spBase::new_class('desktop_mdl_order');
        $orders = $oModel->find('','', 'max(order_bn) AS order_bn');
        if (empty($orders) || !$orders['order_bn']) {
            $newOrderBn = '10000';
        } else {
            $newOrderBn = $orders['order_bn'];
        }
        $i = 1;
        do{
            if($i >= 99){
                break;
            }
            $i++;
            $newOrderBn += 1;
            $orders = $oModel->findCount(array('order_bn' => $newOrderBn));
        }while($orders);

        return $newOrderBn;
    }

    public function choicePrice()
    {
        $this->display('order/choice_price.html');
    }

    /**
     * 删除订单
     * @param String $_GET
     * @return json
     */
    public function del(){
        $args = $this->spArgs();
        $order_id = $args['order_id'];
        if (empty($order_id)){
            $result['rsp'] = 'fail';
            $result['res'] = '传递参数有误';
        }else{
            $result = $this->_del_orders($order_id);
        }
        die(json_encode($result));
    }

    /**
     * 订单操作
     * @access public
     * @param POST
     * @return boolean
     */
    public function operator(){
        $args = $this->spArgs();
        $update_data = array();
        $update_flag = true;
        $order_ids = $args['order_id'];
        if (empty($order_ids)){
            $this->msg('请选择要操作的订单');
            exit;
        }
        switch($args['action']){
            case '1':// 删除
                if ($order_ids){
                    foreach ( $order_ids as $order_id ){
                        $this->_del_orders($order_id);
                    }
                }
                $update_flag = false;
                break;
        }
        if ($update_flag){
            $ordersModel = spBase::new_class('desktop_mdl_order');
            if ($order_ids){
                foreach ( $order_ids as $order_id ){
                    $ordersModel->update(array('order_id'=>$order_id), $update_data);
                }
            }
        }
        $this->msg('操作成功', $args['selfUrl'], 'succ');
    }

    private function _del_orders($order_id){
        $ordersModel = spBase::new_class('desktop_mdl_order');
        if($ordersModel->spLinker()->delete(array('order_id'=>$order_id))){
            $result['rsp'] = 'succ';
        }else{
            $result['rsp'] = 'fail';
            $result['res'] = '删除失败';
        }
        return $result;
    }

}