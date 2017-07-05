<?php
/**
 * 发货单
 * @author Mr 2013.11.7
 */
class ctl_delivery extends desktop_controller {

    public $_printStatus = array('0' => '未发货', '1' => '已发货');

    public function index()
    {
        $args = $this->spArgs();
        $pageSize = 5000;
        $page = $args['p'] ? $args['p'] : 1;
		$offset = ($page-1)*$pageSize;
        //当前url
        $this->selfUrl = spUrl('desktop', 'ctl_delivery', 'index', array_filter($args));

        $this->cus_id = $args['cus_id'];
        if ($args['sort_name']){
            $sort = $args['sort_name'] . ' ' . $args['sort_type'];
        }else{
            $sort = 'delivery_time asc';
        }
        if (!$args['cus_id']) $this->allCustomer = 'true';

        //客户信息
        $customerModel = spBase::new_class('desktop_mdl_customer');
        if ($this->cus_id) {
            $this->customer = $customerModel->find(array('cus_id'=>$this->cus_id));
        }

        //所有客户列表
        $this->customerList = $customerModel->findAll(array('1'=>'1'));

        $filter = array('1'=>'1');
        if ($args['print_status'] != ''){
            $filter['print_status'] = $args['print_status'];
            $this->print_status = $args['print_status'];
        }
        if ($args['delivery_bn']){
            $filter['delivery_bn'] = $args['delivery_bn'];
            unset($filter['print_status']);
            $this->delivery_bn = $args['delivery_bn'];
        }
        if ($args['order_bn']){
            $dlyItemModel = spBase::new_class('desktop_mdl_deliveryItem');
            $items = $dlyItemModel->findAll(array('order_bn' => $args['order_bn']));
            if ($items) {
                $dlyIds = array();
                foreach ($items as $val) {
                    $dlyIds[] = $val['delivery_id'];
                }
            }
            if ($dlyIds) {
                $filter['delivery_id|IN'] = '('.implode(',', $dlyIds).')';
                unset($filter['print_status']);
            }
            $this->order_bn = $args['order_bn'];
        }
        if ($this->cus_id){
            $filter['cus_id'] = $this->cus_id;
        }
        if ($args['from_print_time']){
            $filter['print_time|>='] = strtotime($args['from_print_time'] . ' 00:00:00');
            $this->from_print_time = $args['from_print_time'];
        }
        if ($args['to_print_time']){
            $filter['print_time|<='] = strtotime($args['to_print_time'] . ' 23:59:59');
            $this->to_print_time = $args['to_print_time'];
        }

        $dlyModel = spBase::new_class('desktop_mdl_delivery');
		
        //$list = $dlyModel->spPager($page, $pageSize)->findAll($filter,$sort,'*',$offset.','.$pageSize);
        $list = $dlyModel->spPager($page, $pageSize)->findAll($filter,$sort,'*',$offset.','.$pageSize);
        $this->pager = $dlyModel->spPager()->getPager();

        //标签数量统计
        $countFilter = array('1'=>'1');
        if ($this->cus_id) {
            $countFilter['cus_id'] = $this->cus_id;
        }
        //全部
        $this->counterAll = $dlyModel->findCount($countFilter);
        //未打印
        $countFilter['print_status'] = '0';
        $this->counterUnPrint = $dlyModel->findCount($countFilter);
        //已打印
        $countFilter['print_status'] = '1';
        $this->counterPrinted = $dlyModel->findCount($countFilter);

        if ($list){
            // 纸张类型
            $paperType = spBase::new_class('desktop_func')->getPaperType();
	        $itemModel = spBase::new_class('desktop_mdl_deliveryItem');
            foreach ( $list as $key=>$val ){
                $customer = $customerModel->find(array('cus_id'=>$val['cus_id']));
                $list[$key]['cus_name'] = $customer['cus_name'];

                $list[$key]['type_name'] = $paperType[$val['type']]['full_name'];

                $list[$key]['print_status_name'] = $this->_printStatus[$val['print_status']];

				//订单明细数量
                $items = $itemModel->findCount(array('delivery_id'=>$val['delivery_id']));
                $list[$key]['orderNums'] = $items;
            }
        }
        $this->list = $list;
        $this->sort_name = $args['sort_name'];
        $this->sort_type = $args['sort_type'];
        if ($filter){
            foreach ($filter as $key=>$val){
                $this->$key = $val;
            }
        }
        $this->display('delivery/list.html');
    }

    public function prints()
    {
        $args = $this->spArgs();
        $this->cus_id = $args['cus_id'];
        $delivery_id = $args['delivery_id'];
        if (empty($delivery_id)) {
            $this->msg('请选择需要打印的发货单');
            exit;
        }

        $filter = array();
        if ($args['delivery_id']){
            $filter['delivery_id|IN'] = '('. implode(',', $args['delivery_id']) .')';
        }

        //客户信息
        $cusModel = spBase::new_class('desktop_mdl_customer');
        // 纸张类型
        $paperType = spBase::new_class('desktop_func')->getPaperType();

        $dlyModel = spBase::new_class('desktop_mdl_delivery');
        $dlyItemModel = spBase::new_class('desktop_mdl_deliveryItem');
        $list = $dlyModel->findAll($filter);
        if ($list){
            $printData = array();
            $deliveryIds = array();
            foreach ($list as $key=>$dly) {
                $deliveryIds[] = $dly['delivery_id'];
                $filter = array('delivery_id' => $dly['delivery_id']);

                //客户信息
                $dly['customer'] = $cusModel->find(array('cus_id'=>$dly['cus_id']));

                //发货明细
                $totalRecords = $dlyItemModel->findCount($filter);
                $pageSize = 10;
                $totalPage = ceil($totalRecords / $pageSize);
                for ($page = 1; $page <= $totalPage; $page++) {
                    $totalMoney = $totalNum = 0;
                    $dly['items'] = $dlyItemModel->spPager($page, $pageSize)->findAll($filter);
                    if ($dly['items']) {
                        foreach ($dly['items'] as $k => $v) {
                            $totalMoney += $v['amount'];
							$totalNum += $v['send_num'];
                            $dly['items'][$k]['type_name'] = $paperType[$v['type']]['full_name'];
                        }
                    }
                    $dly['total_money'] = round($totalMoney, 2);
                    $dly['line_num'] = count($dly['items']);
                    $dly['total_nums'] = $totalNum;
                    $dly['line_top'] = 100 - ($dly['line_num'] * 10);
                    $printData[] = $dly;
                }
            }
        }
        $this->printData = $printData;
        $this->deliveryIds = implode(',', $deliveryIds);
        $this->display('delivery/print.html');
    }

    public function doPrint()
    {
        $args = $this->spArgs();
        $deliveryIds = $args['delivery_id'];
        if ($deliveryIds) {
            $dlyModel = spBase::new_class('desktop_mdl_delivery');
            $dlyModel->update(array('delivery_id|IN' => '('.$deliveryIds.')'), array('print_status' => '1', 'print_time' => time()));
        }
    }

    public function printInventory()
    {
        $args = $this->spArgs();
        $filter['cus_id'] = $args['cus_id'];
        if ($args['delivery_id']) {
            $filter['delivery_id|IN'] = '('. implode(',', $args['delivery_id']) .')';
        }

        //客户信息
        $customerModel = spBase::new_class('desktop_mdl_customer');
        if ($args['cus_id']) {
            $this->customer = $customerModel->find(array('cus_id'=>$args['cus_id']));
        }

        $dlyItemModel = spBase::new_class('desktop_mdl_deliveryItem');
		$dlyModel = spBase::new_class('desktop_mdl_delivery');
        $paperType = spBase::new_class('desktop_func')->getPaperType();
        $totalRecords = $dlyItemModel->findCount($filter);
        $pageSize = 30;
        $totalPage = ceil($totalRecords / $pageSize);
        $totalMoney = $totalNums = 0;
        $printData = array();
        for ($page = 1; $page <= $totalPage; $page++) {
            $list = $dlyItemModel->spPager($page, $pageSize)->findAll($filter);
            foreach ( $list as $key=>$item ){
                // 纸张类型
                $list[$key]['type_name'] = $paperType[$item['type']]['full_name'];

				$dly = $dlyModel->find(array('delivery_id' => $item['delivery_id']));
                $list[$key]['delivery_time'] = date('Y-m-d', $dly['delivery_time']);

                //总金额
                $totalMoney += $item['amount'];

				$totalNums += $item['send_num'];
            }
            $printData[]['item'] = $list;
        }
//        echo "<pre>";
//print_r($printData);
        $this->totalMoney = $totalMoney;
        $this->totalNums = $totalNums;
        $this->printData = $printData;
        $this->display('order/inventory.html');
    }

    /**
     * 发货单明细
     * @access public
     * @param Number $order_id 订单ID
     * @reutrn 订单商品明细
     */
    public function items(){
        $delivery_id = $this->spArgs('delivery_id');
        $itemsModel = spBase::new_class('desktop_mdl_deliveryItem');
        $items = $itemsModel->findAll(array('delivery_id' => $delivery_id));
        if ($items){
            // 纸张类型
            $paperType = spBase::new_class('desktop_func')->getPaperType();
            foreach ( $items as $key=>$val ){
                $items[$key]['type_name'] = $paperType[$val['type']]['full_name'];
            }
        }
        $this->items = $items;
        $this->display('delivery/items.html');
    }

	/**
	* 删除发货单明细
	*/
	public function delItem(){
        $args = $this->spArgs();
        $item_id = $args['item_id'];
        if (empty($item_id)){
            $result['rsp'] = 'fail';
            $result['res'] = '传递参数有误';
        }else{
            
			$dlyItemModel = spBase::new_class('desktop_mdl_deliveryItem');
            $dlyOrderModel = spBase::new_class('desktop_mdl_deliveryOrder');

            $items = $dlyItemModel->find(array('item_id' => $item_id));

			//获取发货单明细
			if($dlyItemModel->delete(array('item_id'=>$item_id))){

                //删除发货单订单关联数据
                $dlyOrderModel->delete(array('order_id' => $items['order_id'], 'delivery_id' => $items['delivery_id']));

				$result['rsp'] = 'succ';
				$result['item_id'] = $item_id;
			}else{
				$result['rsp'] = 'fail';
				$result['res'] = '删除失败';
			}

        }
        die(json_encode($result));
    }

    /**
     * 删除发货单
     * @param String $_GET
     * @return json
     */
    public function del(){
        $args = $this->spArgs();
        $delivery_id = $args['delivery_id'];
        if (empty($delivery_id)){
            $result['rsp'] = 'fail';
            $result['res'] = '传递参数有误';
        }else{
            $result = $this->_delDelivery($delivery_id);
        }
        die(json_encode($result));
    }

    private function _delDelivery($delivery_id){
        $oModel = spBase::new_class('desktop_mdl_order');
        $dlyModel = spBase::new_class('desktop_mdl_delivery');
        $dlyItemModel = spBase::new_class('desktop_mdl_deliveryItem');
        $dlyOrderModel = spBase::new_class('desktop_mdl_deliveryOrder');

        //获取发货单明细
        $dlyItems = $dlyItemModel->findAll(array('delivery_id' => $delivery_id));
        foreach ($dlyItems as $val) {
            $orders = $oModel->find(array('order_id' => $val['order_id']));
            $updateSdf = array(
                'send_num' => $orders['send_num'] - $val['send_num'],
                'ship_status' => ($orders['send_num'] - $val['send_num']) > 0 ? '2' : '0',
            );
            $oModel->update(array('order_id' => $val['order_id']), $updateSdf);

            //删除发货单订单关联数据
            $dlyOrderModel->delete(array('order_id' => $val['order_id'], 'delivery_id' => $delivery_id));
        }

        if($dlyModel->spLinker()->delete(array('delivery_id'=>$delivery_id))){
            $result['rsp'] = 'succ';
        }else{
            $result['rsp'] = 'fail';
            $result['res'] = '删除失败';
        }
        return $result;
    }

}