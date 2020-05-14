<?php
/**
 * 获取课程评价列表
 * ============================================================================
 * 版权所有 2015-2018 智享团队，并保留所有权利。
 * 网站地址: https://www.zx-xcx.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件，未购买授权用户无论是否用于商业行为都是侵权行为！
 * 允许已购买用户对程序代码进行修改并在授权域名下使用，但是不允许对程序代码以
 * 任何形式任何目的进行二次发售，作者将依法保留追究法律责任的权力和最终解释权。
 * ============================================================================
 */
 
/* 课程id */
$id = intval($_GPC['id']);

$pindex =max(1,$_GPC['page']);
$psize = 10;

$evaluate_list = pdo_fetchall("SELECT a.lessonid,a.bookname,a.nickname,a.grade,a.content,a.reply,a.addtime, b.avatar FROM " .tablename($this->table_evaluate). " a LEFT JOIN " .tablename($this->table_mc_members). " b ON a.uid=b.uid WHERE a.lessonid=:lessonid AND a.status=:status ORDER BY a.addtime DESC, a.id DESC LIMIT " . ($pindex-1) * $psize . ',' . $psize, array('lessonid'=>$id,':status'=>1));
foreach($evaluate_list as $key=>$value){
	if($value['grade']==1){
		$evaluate_list[$key]['grade'] = "好评";
		$evaluate_list[$key]['grade_ico'] = MODULE_URL.'template/mobile/default/images/oc-h.png';
	}elseif($value['grade']==2){
		$evaluate_list[$key]['grade'] = "中评";
		$evaluate_list[$key]['grade_ico'] = MODULE_URL.'template/mobile/default/images/oc-z.png';
	}elseif($value['grade']==3){
		$evaluate_list[$key]['grade'] = "差评";
		$evaluate_list[$key]['grade_ico'] = MODULE_URL.'template/mobile/default/images/oc-c.png';
	}
	if($setting['show_evaluate_time']){
		$evaluate_list[$key]['addtime'] = date('Y-m-d', $value['addtime']);
	}else{
		$evaluate_list[$key]['addtime'] = '';
	}
	
	if(empty($value['avatar'])){
		$evaluate_list[$key]['avatar'] = MODULE_URL."template/mobile/{$template}/images/default_avatar.jpg";
	}else{
		$inc = strstr($value['avatar'], "http://") || strstr($value['avatar'], "https://");
		$evaluate_list[$key]['avatar'] = $inc ? $value['avatar'] : $_W['attachurl'].$value['avatar'];
	}
}

$this->resultJson($evaluate_list);