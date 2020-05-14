<?php

defined('IN_IA') or exit('Access Denied');

class fy_lessonv2Module extends WeModule {

	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		if(checksubmit()) {
			$dat = array(
				'buynow_name' => trim($_GPC['buynow_name']),
				'buy_vip_name'=> trim($_GPC['buy_vip_name']),
				'buynow_link' => trim($_GPC['buynow_link']),
				'study_name'  => trim($_GPC['study_name']),
				'study_link'  => trim($_GPC['study_link']),

				'share_name'  => trim($_GPC['share_name']),
				'service_url' => trim($_GPC['service_url']),
				'tel'		  => trim($_GPC['tel']),
				'teacher_qq'  => trim($_GPC['teacher_qq']),
				'teacher_qqgroup' => trim($_GPC['teacher_qqgroup']),
				'teacher_qqlink'  => trim($_GPC['teacher_qqlink']),
				'teacher_qrcode'  => trim($_GPC['teacher_qrcode']),

				//即将废弃start
				'mylesson_bg'  => $_GPC['mylesson_bg'],
				'ucenter_bg'   => $_GPC['ucenter_bg'],
				'vip_bg'	   => $_GPC['vip_bg'],
				'vip_bg_pc'	   => $_GPC['vip_bg_pc'],
				'myteacher_bg' => $_GPC['myteacher_bg'],
				'teacher_bg'   => $_GPC['teacher_bg'],
				'teacher_bg_pc'=> $_GPC['teacher_bg_pc'],
				//即将废弃end

				'index_slogan' => $_GPC['index_slogan'],
				'statis_code'  => $_GPC['statis_code'],
			);
			$this->saveSettings($dat);
			message("保存成功", refresh, 'success');
		}

		include $this->template('web/settings');
	}

}

?>