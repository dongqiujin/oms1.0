<?php
/**
 * 客户类
 * @author Mr 2013.11.5
 */
class ctl_customer extends desktop_controller {

    public function index(){

        $args = $this->spArgs();
        $filter = array('1' => '1');
        if ($args['cus_name']) {
            $filter['cus_name|like'] = trim($args['cus_name']);
        }

        $customerModel = spBase::new_class('desktop_mdl_customer');
        $list = $customerModel->findAll($filter, ' create_time asc ');

        $quickList = array();
        foreach ($list as $k => $v) {
            $quickList[] = '\''.$v['cus_name'].'\'';
        }
// print_r($quickList);exit
        $this->quickList = '['.implode(',', $quickList).']';
        $this->list = $list;
        $this->display('customer/list.html');
    }

    public function add(){
        $this->edit('add');
    }

    public function edit($action='edit'){
        $args = $this->spArgs();
        $this->cus_id = $args['cus_id'];

        if ($action == 'edit'){
            // 客户详情
            $customerModel = spBase::new_class('desktop_mdl_customer');
            $detail = $customerModel->find(array('cus_id'=>$this->cus_id));
            $this->detail = $detail;
        }
        $this->action = $action;
        $this->display('customer/info.html');
    }

    public function save(){

        $args = $this->spArgs();
        $cus_name = trim($args['cus_name']);
        $cus_id = trim($args['cus_id']);
        if ($cus_name){
            $cusModel = spBase::new_class('desktop_mdl_customer');
            if ($sameCus = $cusModel->findAll(array('cus_name' => $cus_name), '', 'cus_id,cus_name')) {
                foreach ($sameCus as $val) {
                    if ($val['cus_id'] == $cus_id) continue;
                    if ($val['cus_name'] == $cus_name) {
                        die(json_encode(array('rsp'=>'fail','msg'=>'客户已经存在')));
                    }
                }
            }

            $cusSdf = array(
                'cus_name' => $args['cus_name'],
                'cus_company' => $args['cus_company'],
                'cus_address' => $args['cus_address'],
                'cus_bn' => $args['cus_bn'],
                'cus_contacts' => $args['cus_contacts'],
                'cus_tel' => $args['cus_tel'],
                'cus_fax' => $args['cus_fax'],
                'cus_mobile' => $args['cus_mobile'],
                'cus_zip' => $args['cus_zip']
            );
            if ($cus_id) {
                $cusModel->update(array('cus_id' => $cus_id), $cusSdf);
            } else {
                $cusSdf['create_time'] = time();
                $cusModel->create($cusSdf);
            }
            die(json_encode(array('rsp'=>'succ','msg'=>'添加成功')));
        }else{
            die(json_encode(array('rsp'=>'fail','msg'=>'请输入客户名称')));
        }
    }

    public function price(){
        $args = $this->spArgs();
        $this->cus_id = $args['cus_id'];

        // 客户价格
        $cpModel = spBase::new_class('desktop_mdl_customerPrice');
        $price = $cpModel->findAll(array('cus_id'=>$this->cus_id));

        $this->price = $price;
        $this->display('customer/price.html');
    }

    public function setPrice(){

        $args = $this->spArgs();
        $cus_id = trim($args['cus_id']);
        $product = $args['product'];

        $cpModel = spBase::new_class('desktop_mdl_customerPrice');

        //保存
        if ($product) {
            foreach ($product['product_name'] as $k => $name) {
                $sizeUnit = '';
                if (!strstr($product['product_size'][$k], '寸')) {
                    $sizeUnit = '寸';
                }
                $priceId = $product['price_id'][$k];
                $productSize = trim($product['product_size'][$k]).$sizeUnit;
                $productColor = trim($product['product_color'][$k]);
                $price = trim($product['price'][$k]);

                if (empty($productSize)) {
                    die(json_encode(array('rsp'=>'fail','msg'=>'尺寸不能为空')));
                }
                if (empty($productColor)) {
                    die(json_encode(array('rsp'=>'fail','msg'=>'颜色不能为空')));
                }
                if (empty($price)) {
                    die(json_encode(array('rsp'=>'fail','msg'=>'价格不能为空')));
                }

                $sdf = array(
                    'cus_id' => $cus_id,
                    'type' => 0,
                    'product_name' => trim($name),
                    'product_size' => $productSize,
                    'product_color' => $productColor,
                    'price' => $price,
                );
// echo "<pre>";print_r($sdf);
                $productDetail = $cpModel->find(array('product_name' => $name, 'product_size' => $productSize, 'product_color' => $productColor, 'cus_id' => $cus_id));
                if ($productDetail && $productDetail['price_id'] != $priceId) {
                    die(json_encode(array('rsp'=>'fail','msg'=>'保存失败:'.$name.$productSize.$productColor.'已存在')));
                }

                //更新
                if ($priceId) {
                    $cpModel->update(array('price_id' => $priceId), $sdf);
                } else {
                    $cpModel->create($sdf);
                }
            }
        }
        die(json_encode(array('rsp'=>'succ','msg'=>'保存成功')));
    }

}