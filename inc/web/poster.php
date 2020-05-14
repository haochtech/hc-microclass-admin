<?php
/**
 * 分销海报
 * ============================================================================
 * 版权所有 2015-2018 智享团队，并保留所有权利。
 * 网站地址: https://www.zx-xcx.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件，未购买授权用户无论是否用于商业行为都是侵权行为！
 * 允许已购买用户对程序代码进行修改并在授权域名下使用，但是不允许对程序代码以
 * 任何形式任何目的进行二次发售，作者将依法保留追究法律责任的权力和最终解释权。
 * ============================================================================
 */

if($op=='display'){
	
	include_once 'poster/display.php';

}elseif($op=='edit'){
	
	include_once 'poster/edit.php';

}elseif($op=='delete'){
	
	include_once 'poster/delete.php';

}elseif($op=='synPoster'){
	
	include_once 'poster/synPoster.php';

}


include $this->template('web/poster');

?>