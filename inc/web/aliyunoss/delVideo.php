<?php

$id = intval($_GPC['id']);
$file = pdo_fetch("SELECT * FROM " .tablename($this->table_aliyunoss_upload). " WHERE uniacid=:uniacid AND id=:id", array(':uniacid'=>$uniacid, ':id'=>$id));
if(empty($file)){
	message("该文件不存在!", "", "error");
}

try {
	pdo_delete($this->table_aliyunoss_upload, array('id'=>$id));

	message("删除成功!", $this->createWebUrl('aliyunoss'), "success");
} catch (Exception $e) {
	message("删除失败，请稍候重试", "", "error");
}