<?php
/**
 * 收藏课程/讲师
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

$ctype = intval($_GPC['ctype']); /* 收藏类型 */
$uid = $_W['member']['uid'];
$already_study = $common['index_page']['studyNum'] ? $common['index_page']['studyNum'] : '人已学习';

$pindex =max(1,$_GPC['page']);
$psize = 10;

$condition = " b.uniacid=:uniacid AND b.uid=:uid ";
$params[':uniacid'] = $uniacid;
$params[':uid'] = $uid;

if($ctype==1){
	$title = '我收藏的课程';
	$condition .= "  AND b.ctype=:ctype ";
	$params[':ctype'] = 1;
	
	$lessonlist = pdo_fetchall("SELECT a.id,a.bookname,a.images,a.price,a.score,a.ico_name,a.buynum,a.virtual_buynum,a.vip_number,a.teacher_number,a.section_status FROM " . tablename($this->table_lesson_parent) . " a LEFT JOIN " .tablename($this->table_lesson_collect). " b ON a.id=b.outid WHERE {$condition} ORDER BY b.addtime DESC  LIMIT " . ($pindex-1) * $psize . ',' . $psize, $params);
	foreach($lessonlist as $k=>$v){
		$v['soncount'] = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->table_lesson_son) . " WHERE parentid=:parentid", array(':parentid'=>$v['id']));
		if($v['price']>0){
			$v['buynum_total'] = $v['buynum'] + $v['virtual_buynum'] + $v['vip_number'] + $v['teacher_number'];
		}else{
			$v['buynum_total'] = $v['buynum'] + $v['virtual_buynum'] + $v['vip_number'] + $v['teacher_number'] + $v['visit_number'];
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

}elseif($ctype==2){
	$title = '我收藏的讲师';
	$condition .= "  AND b.ctype=:ctype ";
	$params[':ctype'] = 2;
	
	$teacherlist = pdo_fetchall("SELECT a.id,a.teacher,a.teacherdes,a.teacherphoto FROM " . tablename($this->table_teacher) . " a LEFT JOIN " .tablename($this->table_lesson_collect). " b ON a.id=b.outid WHERE {$condition} ORDER BY b.addtime DESC  LIMIT " . ($pindex-1) * $psize . ',' . $psize, $params);
	foreach($teacherlist as $k=>$v){
		$v['teacherdes'] = strip_tags(htmlspecialchars_decode($v['teacherdes']));
		$v['lessonCount'] = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename($this->table_lesson_parent). " WHERE teacherid=:teacherid AND status=:status", array(':teacherid'=>$v['id'], ':status'=>1));

		$teacherlist[$k] = $v;
	}
}

if($op=='ajaxgetlesson'){
	$this->resultJson($lessonlist);

}elseif($op=='ajaxgetteacher'){
	$this->resultJson($teacherlist);

}else{
	include $this->template("../mobile/{$template}/collect");

}
