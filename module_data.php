<?php

defined($_ENV["伫\34"]["\240"]) or exit($_ENV["伫\34"]["\36\xed"]);
class fy_lessonv2Module extends WeModule
{
	public function settingsDisplay($settings)
	{
		global $_W, $_GPC;
		if (checksubmit()) {
			$dat = array("buynow_name" => trim($_GPC[$_ENV["伫\34"]["覎"]]), "buynow_link" => trim($_GPC[$_ENV["伫\34"][""]]), "study_name" => trim($_GPC[$_ENV["伫\34"][""]]), "study_link" => trim($_GPC[$_ENV["伫\34"]["\246\20"]]), "share_name" => trim($_GPC[$_ENV["伫\34"]["\27\252"]]), "service_url" => trim($_GPC[$_ENV["伫\34"]["鞄"]]), "tel" => trim($_GPC[$_ENV["伫\34"]["\0O"]]), "teacher_qq" => trim($_GPC[$_ENV["伫\34"]["塔"]]), "teacher_qqgroup" => trim($_GPC[$_ENV["伫\34"][".\4"]]), "teacher_qqlink" => trim($_GPC[$_ENV["伫\34"]["硪"]]), "teacher_qrcode" => trim($_GPC[$_ENV["伫\34"][""]]), "ucenter_bg" => $_GPC[$_ENV["伫\34"]["灐"]], "vip_bg" => $_GPC[$_ENV["伫\34"]["洏"]], "myteacher_bg" => $_GPC[$_ENV["伫\34"]["鄬"]], "teacher_bg" => $_GPC[$_ENV["伫\34"]["\x97\77"]], "index_slogan" => $_GPC[$_ENV["伫\34"]["\73\xad"]], "statis_code" => $_GPC[$_ENV["伫\34"]["嬨"]]);
			$this->saveSettings($dat);
			message($_ENV["伫\34"]["\xff\272"], refresh, $_ENV["伫\34"]["崤"]);
		}
		include $this->template($_ENV["伫\34"]["\135\200"]);
	}
}