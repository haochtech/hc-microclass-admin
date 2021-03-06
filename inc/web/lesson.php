<?php
/**
 * 课程管理
 * ============================================================================
 * 版权所有 2015-2018 智享团队，并保留所有权利。
 * 网站地址: https://www.zx-xcx.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件，未购买授权用户无论是否用于商业行为都是侵权行为！
 * 允许已购买用户对程序代码进行修改并在授权域名下使用，但是不允许对程序代码以
 * 任何形式任何目的进行二次发售，作者将依法保留追究法律责任的权力和最终解释权。
 * ============================================================================
 */

$we7_version = intval(IMS_VERSION) ? intval(IMS_VERSION) : 2;
if(empty($setting)){
	message("请先配置相关参数", $this->createWebUrl('setting'), "error");
}

$typeStatus = new TypeStatus();
$lessonStatusList = $typeStatus->lessonStatus();

$qcloudvod = unserialize($setting['qcloudvod']);
$newqcloudVod = new QcloudVod($qcloudvod['secret_id'], $qcloudvod['secret_key']);
$aliyun = unserialize($setting['aliyunvod']);
$aliyunVod = new AliyunVod($aliyun['region_id'],$aliyun['access_key_id'],$aliyun['access_key_secret']);

/* 课程属性 */
$lesson_attribute = $common['lesson_attribute'];
$attribute1 = pdo_fetchall("SELECT * FROM " .tablename($this->table_attribute). " WHERE uniacid=:uniacid AND attr_type=:attr_type ORDER BY displayorder DESC", array(':uniacid'=>$uniacid,':attr_type'=>'attribute1'));
$attribute2 = pdo_fetchall("SELECT * FROM " .tablename($this->table_attribute). " WHERE uniacid=:uniacid AND attr_type=:attr_type ORDER BY displayorder DESC", array(':uniacid'=>$uniacid,':attr_type'=>'attribute2'));

if ($op == 'display') {
	include_once 'lesson/display.php';

}elseif($op == 'postlesson') {
	include_once 'lesson/postlesson.php';

}elseif($op == 'viewsection'){
	include_once 'lesson/viewsection.php';

}elseif($op == 'postsection') {
	include_once 'lesson/postsection.php';

}elseif($op == 'sectionTitle') {
	include_once 'lesson/sectionTitle.php';

}elseif($op == 'postSectionTitle') {
	include_once 'lesson/postSectionTitle.php';

}elseif($op == 'addSectionToTitle') {
	include_once 'lesson/addSectionToTitle.php';

}elseif($op == 'delSectionTitle') {
	include_once 'lesson/delSectionTitle.php';

}elseif($op == 'attribute') {
	include_once 'lesson/attribute.php';

}elseif($op == 'addAttribute') {
	include_once 'lesson/addAttribute.php';

}elseif($op == 'delAttribute') {
	include_once 'lesson/delAttribute.php';

}elseif($op=='inform'){
	include_once 'lesson/inform.php';

}elseif($op == 'informStudent'){
	include_once 'lesson/informStudent.php';

}elseif($op == 'delete') {
	include_once 'lesson/delete.php';

}elseif($op=='record'){
	include_once 'lesson/record.php';

}elseif($op == 'studyDuration') {
	include_once 'lesson/studyDuration.php';

}elseif($op == 'studyDurationDetails') {
	include_once 'lesson/studyDurationDetails.php';

}elseif($op=='qrcode'){
	include_once 'lesson/qrcode.php';

}elseif($op=='updomain'){
	include_once 'lesson/updomain.php';

}elseif($op=='previewVideo'){
	include_once 'lesson/previewVideo.php';

}elseif($op == 'copylesson') {
	include_once 'lesson/copylesson.php';

}

include $this->template('web/lesson');


?>