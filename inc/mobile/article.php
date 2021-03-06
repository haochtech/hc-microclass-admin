<?php
/**
 * 文章公告
 * ============================================================================
 * 版权所有 2015-2018 智享团队，并保留所有权利。
 * 网站地址: https://www.zx-xcx.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件，未购买授权用户无论是否用于商业行为都是侵权行为！
 * 允许已购买用户对程序代码进行修改并在授权域名下使用，但是不允许对程序代码以
 * 任何形式任何目的进行二次发售，作者将依法保留追究法律责任的权力和最终解释权。
 * ============================================================================
 */
if((!$userAgent) || ($userAgent && !$comsetting['hidden_login'])){
	checkauth();
}

$aid = intval($_GPC['aid']);
$uid = $_W['member']['uid'];
if($uid && !$_GPC['uid']){
	header("Location:".$_W['siteurl'].'&uid='.$uid);
}

if($op=='display'){
	$aid = intval($_GPC['aid']);
	$article = pdo_fetch("SELECT * FROM " .tablename($this->table_article). " WHERE id=:id", array(':id'=>$aid));
	if(empty($article)){
		message("该文章公告不存在！", "", "error");
	}
	$title = $article['title'];

	if($article['is_vip']){
		$member_vip = pdo_fetch("SELECT level_id FROM " .tablename($this->table_member_vip). " WHERE uniacid=:uniacid AND uid=:uid AND validity>:validity LIMIT 1", array(':uniacid'=>$uniacid,':uid'=>$uid,':validity'=>time()));
		if(empty($member_vip)){
			message("您不是VIP用户，无权限访问该页面");
		}
	}

	/* 增加访问量 */
	pdo_update($this->table_article, array('view'=>$article['view']+1), array('uniacid'=>$uniacid,'id'=>$aid));

	/* 分享设置 */
	$sharelink = unserialize($comsetting['sharelink']);
	$article['desc'] = substr(strip_tags(htmlspecialchars_decode($article['content'])), 0, 240);
	$article['images'] = $article['images']?$article['images']:$sharelink['images'];
	$shareurl = $uid ? $_W['siteroot'] .'app/'. $this->createMobileUrl('article', array('aid'=>$aid,'uid'=>$uid)) : '';

}elseif($op=='list'){
	$title = $common['page_title']['article'] ? $common['page_title']['article'] : '全部公告';
	
	/* 文章分类 */
	$category_list = $site_common->getArticleCategory();
	
	$pindex =max(1,$_GPC['page']);
	$psize = 10;

	$condition = " uniacid=:uniacid AND isshow=:isshow ";
	$params = array(
		':uniacid'	=> $uniacid,
		':isshow'	=> 1,
	);
	if($_GPC['cate_id']){
		$condition .= " AND cate_id=:cate_id";
		$params[':cate_id'] = $_GPC['cate_id'];
	}

	/* 非VIP用户仅能查看非VIP公告 */
	$member_vip = pdo_fetch("SELECT level_id FROM " .tablename($this->table_member_vip). " WHERE uniacid=:uniacid AND uid=:uid AND validity>:validity LIMIT 1", array(':uniacid'=>$uniacid,':uid'=>$uid,':validity'=>time()));
	if(empty($member_vip)){
		$condition .= " AND is_vip=:is_vip";
		$params[':is_vip'] = 0;
	}

	$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_article) . " WHERE {$condition} ORDER BY displayorder DESC, id DESC  LIMIT " . ($pindex-1) * $psize . ',' . $psize, $params);
	foreach($list as $k=>$v){
		$v['images'] = $v['images'] ? $_W['attachurl'].$v['images'] : MODULE_URL.'template/mobile/default/images/nopic_350_350.png?v=3';
		$v['addtime'] = date("Y-m-d H:i:s", $v['addtime']);

		$list[$k] = $v;
	}

	if($_GPC['method']=='ajaxgetlist'){
		$this->resultJson($list);
	}
}

include $this->template("../mobile/{$template}/article");

?>