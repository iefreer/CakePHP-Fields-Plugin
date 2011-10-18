<?php
$config = array(
	'deals' => array(
		'actions' => array('index','test_index'),
		'fields' => array(
			'Deal'=>array('id','city_id','coupon_sold_count','start_time','end_time','deal_type','status'),
			'DealDetail'=>array('subject','description','coupon_note','currency_id','price','price_after_cut'),
			'DealImage'=>array('url','img_type'),
			'DealToVendorBranch'=>array('branch_id'),
		),
	),
);
?>