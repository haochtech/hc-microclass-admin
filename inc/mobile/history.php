<?php
/**
 * 我的足迹
 * ============================================================================
 * 版权所有 2015-2018 智享团队，并保留所有权利。
 * 网站地址: https://www.zx-xcx.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件，未购买授权用户无论是否用于商业行为都是侵权行为！
 * 允许已购买用户对程序代码进行修改并在授权域名下使用，但是不允许对程序代码以
 * 任何形式任何目的进行二次发售，作者将依法保留追究法律责任的权力和最终解释权。
 * ============================================================================
 */

checkauth();
$uid = $_W['member']['uid'];
$already_study = $common['index_page']['studyNum'] ? $common['index_page']['studyNum'] : '人已学习';

$pindex =max(1,$_GPC['page']);
$psize = 10;

$condition = " b.uniacid=:uniacid AND b.uid=:uid ";
$params[':uniacid'] = $uniacid;
$params[':uid'] = $uid;

$lessonlist = pdo_fetchall("SELECT a.id,a.bookname,a.images,a.price,a.score,a.section_status,a.ico_name,a.buynum+a.virtual_buynum+a.vip_number AS buynum,a.visit_number, b.addtime FROM " .tablename($this->table_lesson_parent). " a LEFT JOIN " .tablename($this->table_lesson_history). " b ON a.id=b.lessonid WHERE {$condition} ORDER BY b.addtime DESC  LIMIT " . ($pindex-1) * $psize . ',' . $psize, $params);
foreach($lessonlist as $k=>$v){
	$v['addtime'] = date('Y-m-d H:i', $v['addtime']);
	$v['soncount'] = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename($this->table_lesson_son). " WHERE  parentid=:parentid", array(':parentid'=>$v['id']));
	if($v['price']>0){
		$v['buyTotal'] = $v['buynum'];
	}else{
		$v['buyTotal'] = $v['buynum'] + $v['visit_number'];
	}
	if($v['score']>0){
		$v['score_rate'] = $v['score']*100;
	}else{
		$v['score_rate'] = "";
	}

	$v['discount'] = $site_common->getLessonDiscount($v['id']);
	$v['price'] = round($v['price']*$v['discount'], 2);
	if($v['discount']<1 && !$v['ico_name']){
		$v['ico_name'] = 'ico-discount';
	}

	$lessonlist[$k] = $v;
}

if($op=='display'){
	$title = '我的足迹';

}elseif($op=='ajaxgetlist'){
	$this->resultJson($lessonlist);

}

include $this->template("../mobile/{$template}/history");
