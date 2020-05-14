<?php
/**
 * PC端管理管理
 * ============================================================================
 * 版权所有 2015-2018 智享团队，并保留所有权利。
 * 网站地址: https://www.zx-xcx.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件，未购买授权用户无论是否用于商业行为都是侵权行为！
 * 允许已购买用户对程序代码进行修改并在授权域名下使用，但是不允许对程序代码以
 * 任何形式任何目的进行二次发售，作者将依法保留追究法律责任的权力和最终解释权。
 * ============================================================================
 */

$typeStatus = new TypeStatus();
$nav_location = $typeStatus->navigationLocation();  //导航位置 顶部、底部

if ($operation == 'display') {
	
	include_once 'pcmanage/display.php';

}elseif ($operation == 'navigation') {
	
	include_once 'pcmanage/navigation.php';

}elseif ($operation == 'addNav') {
	
	include_once 'pcmanage/addNav.php';

}elseif ($operation == 'delNav') {
	
	include_once 'pcmanage/delNav.php';

}

include $this->template('web/pcmanage');


?>