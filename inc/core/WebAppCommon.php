<?php

//decode by http://www.zx-xcx.com/
class WebAppCommon extends WeModuleWebapp
{
	public $table_aliyun_upload = "fy_lesson_aliyun_upload";
	public $table_aliyunoss_upload = "fy_lesson_aliyunoss_upload";
	public $table_article = "fy_lesson_article";
	public $table_banner = "fy_lesson_banner";
	public $table_blacklist = "fy_lesson_blacklist";
	public $table_cashlog = "fy_lesson_cashlog";
	public $table_category = "fy_lesson_category";
	public $table_lesson_collect = "fy_lesson_collect";
	public $table_commission_level = "fy_lesson_commission_level";
	public $table_commission_log = "fy_lesson_commission_log";
	public $table_commission_setting = "fy_lesson_commission_setting";
	public $table_coupon = "fy_lesson_coupon";
	public $table_discount = "fy_lesson_discount";
	public $table_discount_lesson = "fy_lesson_discount_lesson";
	public $table_evaluate = "fy_lesson_evaluate";
	public $table_evaluate_score = "fy_lesson_evaluate_score";
	public $table_lesson_history = "fy_lesson_history";
	public $table_index_module = "fy_lesson_index_module";
	public $table_inform = "fy_lesson_inform";
	public $table_inform_fans = "fy_lesson_inform_fans";
	public $table_recommend_junior = "fy_lesson_recommend_junior";
	public $table_recommend_activity = "fy_lesson_recommend_activity";
	public $table_market = "fy_lesson_market";
	public $table_mcoupon = "fy_lesson_mcoupon";
	public $table_member = "fy_lesson_member";
	public $table_member_buyteacher = "fy_lesson_member_buyteacher";
	public $table_member_coupon = "fy_lesson_member_coupon";
	public $table_member_order = "fy_lesson_member_order";
	public $table_member_vip = "fy_lesson_member_vip";
	public $table_navigation = "fy_lesson_navigation";
	public $table_order = "fy_lesson_order";
	public $table_order_verify = "fy_lesson_order_verify";
	public $table_lesson_parent = "fy_lesson_parent";
	public $table_playrecord = "fy_lesson_playrecord";
	public $table_poster = "fy_lesson_poster";
	public $table_qcloudvod_upload = "fy_lesson_qcloudvod_upload";
	public $table_qcloud_upload = "fy_lesson_qcloud_upload";
	public $table_qiniu_upload = "fy_lesson_qiniu_upload";
	public $table_recommend = "fy_lesson_recommend";
	public $table_setting = "fy_lesson_setting";
	public $table_setting_pc = "fy_lesson_setting_pc";
	public $table_lesson_son = "fy_lesson_son";
	public $table_lesson_title = "fy_lesson_title";
	public $table_lesson_spec = "fy_lesson_spec";
	public $table_static = "fy_lesson_static";
	public $table_study_duration = "fy_lesson_study_duration";
	public $table_subscribe_msg = "fy_lesson_subscribe_msg";
	public $table_syslog = "fy_lesson_syslog";
	public $table_teacher = "fy_lesson_teacher";
	public $table_teacher_income = "fy_lesson_teacher_income";
	public $table_teacher_order = "fy_lesson_teacher_order";
	public $table_teacher_price = "fy_lesson_teacher_price";
	public $table_tplmessage = "fy_lesson_tplmessage";
	public $table_vip_level = "fy_lesson_vip_level";
	public $table_vipcard = "fy_lesson_vipcard";
	public $table_mc_members = "mc_members";
	public $table_fans = "mc_mapping_fans";
	public $table_core_paylog = "core_paylog";
	public $table_users = "users";
	public function getTopNavigation()
	{
		global $_W;
		$uniacid = $_W["uniacid"];
		$navigation = cache_load("fy_lesson_" . $uniacid . "_top_navigation_pc");
		if (empty($navigation)) {
			$navigation = pdo_fetchall("SELECT * FROM " . tablename($this->table_navigation) . " WHERE uniacid=:uniacid AND is_pc=:is_pc AND location=:location ORDER BY displayorder DESC, nav_id ASC", array(":uniacid" => $uniacid, ":is_pc" => 1, ":location" => 4));
			cache_write("fy_lesson_" . $uniacid . "_top_navigation_pc", $navigation);
		}
		return $navigation;
	}
	public function getMenuNavigation()
	{
		global $_W;
		$uniacid = $_W["uniacid"];
		$navigation = cache_load("fy_lesson_" . $uniacid . "_menu_navigation_pc");
		if (empty($navigation)) {
			$navigation = pdo_fetchall("SELECT * FROM " . tablename($this->table_navigation) . " WHERE uniacid=:uniacid AND is_pc=:is_pc AND location=:location ORDER BY displayorder DESC, nav_id ASC", array(":uniacid" => $uniacid, ":is_pc" => 1, ":location" => 2));
			foreach ($navigation as $k => $v) {
				$tmp_params = explode(".html", strtolower($v["url_link"]));
				$url_params = explode("/", $tmp_params[0]);
				$url_params = array_reverse($url_params);
				$navigation[$k]["action"] = $url_params[0];
			}
			cache_write("fy_lesson_" . $uniacid . "_menu_navigation_pc", $navigation);
		}
		return $navigation;
	}
	public function getNavCategory()
	{
		global $_W;
		$uniacid = $_W["uniacid"];
		$categorylist = cache_load("fy_lesson_" . $uniacid . "_categorylist");
		if (empty($categorylist)) {
			$categorylist = pdo_fetchall("SELECT * FROM " . tablename($this->table_category) . " WHERE uniacid=:uniacid AND parentid=:parentid AND search_show=:search_show ORDER BY displayorder DESC", array(":uniacid" => $uniacid, ":parentid" => 0, ":search_show" => 1));
			foreach ($categorylist as $k => $v) {
				$categorylist[$k]["child"] = pdo_fetchall("SELECT * FROM " . tablename($this->table_category) . " WHERE uniacid=:uniacid AND parentid=:parentid AND search_show=:search_show ORDER BY displayorder DESC", array(":uniacid" => $uniacid, ":parentid" => $v["id"], ":search_show" => 1));
			}
			cache_write("fy_lesson_" . $uniacid . "_categorylist", $categorylist);
		}
		return $categorylist;
	}
	public function getHotSearch($setting_pc)
	{
		$hot_search = explode("、", $setting_pc["hot_search"]);
		return array_filter($hot_search);
	}
	public function getIndexBanner()
	{
		global $_W;
		$uniacid = $_W["uniacid"];
		$banner = cache_load("fy_lesson_" . $uniacid . "_index_banner_pc");
		if (empty($banner)) {
			$banner = pdo_fetchall("SELECT * FROM " . tablename($this->table_banner) . " WHERE uniacid=:uniacid AND is_show=:is_show AND is_pc=:is_pc AND banner_type=:banner_type ORDER BY displayorder DESC, banner_id ASC", array(":uniacid" => $uniacid, ":is_show" => 1, ":is_pc" => 1, "banner_type" => 0));
			cache_write("fy_lesson_" . $uniacid . "_index_banner_pc", $banner);
		}
		return $banner;
	}
	public function getIndexArticelAdv()
	{
		global $_W;
		$uniacid = $_W["uniacid"];
		$notice_avd = cache_load("fy_lesson_" . $uniacid . "_index_notice_adv_pc");
		if (empty($notice_avd)) {
			$notice_avd = pdo_get($this->table_banner, array("uniacid" => $uniacid, "is_show" => 1, "is_pc" => 1, "banner_type" => 4));
			cache_write("fy_lesson_" . $uniacid . "_index_notice_adv_pc", $notice_avd);
		}
		return $notice_avd;
	}
	public function getIndexArticleList($limit = 4)
	{
		global $_W;
		$uniacid = $_W["uniacid"];
		$notice_litst = $this->readCommonCache("fy_lesson_" . $uniacid . "_index_article_pc");
		if (empty($notice_litst)) {
			$notice_litst = pdo_fetchall("SELECT * FROM " . tablename($this->table_article) . " WHERE uniacid=:uniacid AND commend=:commend AND isshow=:isshow ORDER BY displayorder DESC,id DESC LIMIT 0," . $limit, array(":uniacid" => $uniacid, ":commend" => 1, ":isshow" => 1));
			cache_write("fy_lesson_" . $uniacid . "_index_article_pc", $notice_litst);
		}
		return $notice_litst;
	}
	public function getIndexDiscountAdv($limit = 3)
	{
		global $_W;
		$uniacid = $_W["uniacid"];
		$discount_avd = cache_load("fy_lesson_" . $uniacid . "_index_discount_banner_pc");
		if (empty($discount_avd)) {
			$discount_avd = pdo_fetchall("SELECT * FROM " . tablename($this->table_banner) . " WHERE uniacid=:uniacid AND is_show=:is_show AND is_pc=:is_pc AND banner_type=:banner_type ORDER BY displayorder DESC, banner_id ASC LIMIT 0," . $limit, array(":uniacid" => $uniacid, ":is_show" => 1, ":is_pc" => 1, "banner_type" => 2));
			cache_write("fy_lesson_" . $uniacid . "_index_discount_banner_pc", $discount_avd);
		}
		return $discount_avd;
	}
	public function getIndexTeacherList($limit = 3)
	{
		global $_W;
		$uniacid = $_W["uniacid"];
		$rec_teacher = $this->readCommonCache("fy_lesson_" . $uniacid . "_recommend_teacher_pc");
		if (empty($rec_teacher)) {
			$rec_teacher = pdo_fetchall("SELECT * FROM " . tablename($this->table_teacher) . " WHERE uniacid=:uniacid AND status=:status AND is_recommend=:is_recommend ORDER BY displayorder DESC, id DESC LIMIT 0," . $limit, array(":uniacid" => $uniacid, ":status" => 1, ":is_recommend" => 1));
			foreach ($rec_teacher as $k => $v) {
				$v["total"] = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->table_lesson_parent) . " WHERE uniacid=:uniacid AND teacherid=:teacherid AND status=:status ", array(":uniacid" => $uniacid, ":teacherid" => $v["id"], ":status" => 1));
				$v["teacherdes"] = $v["digest"] ? explode("\n", $v["digest"]) : explode("\n", strip_tags(htmlspecialchars_decode($v["teacherdes"])));
				$rec_teacher[$k] = $v;
			}
			cache_write("fy_lesson_" . $uniacid . "_recommend_teacher_pc", $rec_teacher);
		}
		return $rec_teacher;
	}
	public function getIndexNewLesson($limit = 4)
	{
		global $_W;
		$uniacid = $_W["uniacid"];
		$newlesson = $this->readCommonCache("fy_lesson_" . $uniacid . "_index_new_lesson_pc");
		if (empty($newlesson)) {
			$newlesson = pdo_fetchall("SELECT id,bookname,price,images,buynum,virtual_buynum,vip_number,teacher_number,visit_number,section_status,teacherid,ico_name,update_time FROM " . tablename($this->table_lesson_parent) . " WHERE uniacid=:uniacid AND status=:status ORDER BY update_time DESC LIMIT 0,{$limit}", array(":uniacid" => $uniacid, ":status" => 1));
			foreach ($newlesson as $k => $v) {
				$v["tran_time"] = $this->tranTime($v["update_time"]);
				$v["section"] = pdo_fetch("SELECT title FROM " . tablename($this->table_lesson_son) . " WHERE parentid=:parentid AND status=:status ORDER BY id DESC LIMIT 0,1", array(":parentid" => $v["id"], ":status" => 1));
				$v["count"] = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->table_lesson_son) . " WHERE parentid=:parentid AND status=:status ", array(":parentid" => $v["id"], ":status" => 1));
				$v["teacher"] = pdo_get($this->table_teacher, array("uniacid" => $uniacid, "id" => $v["teacherid"]), array("teacher", "teacherphoto"));
				$v["study_number"] = $v["buynum"] + $v["virtual_buynum"] + $v["vip_number"] + $v["teacher_number"];
				if ($v["price"] == 0) {
					$v["study_number"] += $v["visit_number"];
				}
				$v["discount"] = $this->getLessonDiscount($v["id"]);
				if ($v["discount"] < 1) {
					$v["ico_name"] = $v["ico_name"] ? $v["ico_name"] : "ico-discount";
					$v["market_price"] = $v["price"];
				}
				$v["price"] = round($v["price"] * $v["discount"], 2);
				$newlesson[$k] = $v;
			}
			cache_write("fy_lesson_" . $uniacid . "_index_new_lesson_pc", $newlesson);
		}
		return $newlesson;
	}
	public function getIndexRecomendLesson()
	{
		global $_W;
		$uniacid = $_W["uniacid"];
		$list = $this->readCommonCache("fy_lesson_" . $uniacid . "_index_recommend_pc");
		if (empty($list)) {
			$list = pdo_fetchall("SELECT id AS recid,rec_name,icon,show_style,limit_number_pc FROM " . tablename($this->table_recommend) . " WHERE uniacid=:uniacid AND is_show=:is_show ORDER BY displayorder DESC,id DESC", array(":uniacid" => $uniacid, ":is_show" => 1));
			foreach ($list as $key => $rec) {
				$list[$key]["lesson"] = pdo_fetchall("SELECT * FROM " . tablename($this->table_lesson_parent) . " WHERE uniacid='{$uniacid}' AND status=1 AND (recommendid='{$rec["recid"]}' OR (recommendid LIKE '{$rec["recid"]},%') OR (recommendid LIKE '%,{$rec["recid"]}') OR (recommendid LIKE '%,{$rec["recid"]},%')) ORDER BY displayorder DESC, id DESC LIMIT 0," . $rec["limit_number_pc"]);
				foreach ($list[$key]["lesson"] as $k => $val) {
					$val["count"] = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->table_lesson_son) . " WHERE parentid=:parentid AND status=:status ", array(":parentid" => $val["id"], ":status" => 1));
					$val["descript"] = strip_tags(html_entity_decode($val["descript"]));
					$val["teacher"] = pdo_get($this->table_teacher, array("id" => $val["teacherid"]), array("teacher", "teacherphoto"));
					$val["study_number"] = $val["buynum"] + $val["virtual_buynum"] + $val["vip_number"] + $val["teacher_number"];
					if ($val["price"] == 0) {
						$val["study_number"] += $val["visit_number"];
					}
					$val["discount"] = $this->getLessonDiscount($val["id"]);
					if ($val["discount"] < 1) {
						$val["ico_name"] = $val["ico_name"] ? $val["ico_name"] : "ico-discount";
						$val["market_price"] = $val["price"];
					}
					$val["price"] = round($val["price"] * $val["discount"], 2);
					$list[$key]["lesson"][$k] = $val;
				}
				if (empty($list[$key]["lesson"])) {
					unset($list[$key]);
				}
			}
			cache_write("fy_lesson_" . $uniacid . "_index_recommend_pc", $list);
		}
		return $list;
	}
	public function getBottomNavigation($limit = 4)
	{
		global $_W;
		$uniacid = $_W["uniacid"];
		$navigation = cache_load("fy_lesson_" . $uniacid . "_bottom_navigation_pc");
		if (empty($navigation)) {
			$navigation = pdo_fetchall("SELECT * FROM " . tablename($this->table_navigation) . " WHERE uniacid=:uniacid AND is_pc=:is_pc AND location=:location ORDER BY displayorder DESC, nav_id ASC LIMIT 0," . $limit, array(":uniacid" => $uniacid, ":is_pc" => 1, ":location" => 1));
			cache_write("fy_lesson_" . $uniacid . "_bottom_navigation_pc", $navigation);
		}
		return $navigation;
	}
	public function getSelfNavigation()
	{
		global $_W;
		$uniacid = $_W["uniacid"];
		$navigation = cache_load("fy_lesson_" . $uniacid . "_self_navigation_pc");
		if (empty($navigation)) {
			$navigation = pdo_fetchall("SELECT * FROM " . tablename($this->table_navigation) . " WHERE uniacid=:uniacid AND is_pc=:is_pc AND location=:location ORDER BY displayorder DESC, nav_id ASC ", array(":uniacid" => $uniacid, ":is_pc" => 1, ":location" => 3));
			cache_write("fy_lesson_" . $uniacid . "_self_navigation_pc", $navigation);
		}
		return $navigation;
	}
	public function getLessonAudioBg()
	{
		global $_W;
		$uniacid = $_W["uniacid"];
		$audio_bg = cache_load("fy_lesson_" . $uniacid . "_lesson_audio_bg_pc");
		if (empty($audio_bg)) {
			$audio_bg = pdo_fetchall("SELECT * FROM " . tablename($this->table_banner) . " WHERE uniacid=:uniacid AND is_show=:is_show AND is_pc=:is_pc AND banner_type=:banner_type", array(":uniacid" => $uniacid, ":is_show" => 1, ":is_pc" => 1, "banner_type" => 11));
			cache_write("fy_lesson_" . $uniacid . "_lesson_audio_bg_pc", $audio_bg);
		}
		return $audio_bg;
	}
	public function getArticleAdv($limit = 4)
	{
		global $_W;
		$uniacid = $_W["uniacid"];
		$article_avd = cache_load("fy_lesson_" . $uniacid . "_article_avd_pc");
		if (empty($article_avd)) {
			$article_avd = pdo_fetchall("SELECT * FROM " . tablename($this->table_banner) . " WHERE uniacid=:uniacid AND is_show=:is_show AND is_pc=:is_pc AND banner_type=:banner_type ORDER BY displayorder DESC, banner_id ASC LIMIT 0," . $limit, array(":uniacid" => $uniacid, ":is_show" => 1, ":is_pc" => 1, "banner_type" => 12));
			cache_write("fy_lesson_" . $uniacid . "_article_avd_pc", $article_avd);
		}
		return $article_avd;
	}
	public function getLessonDiscount($lessonid)
	{
		global $_W;
		$discount_lesson = pdo_fetch("SELECT discount FROM " . tablename($this->table_discount_lesson) . " WHERE uniacid=:uniacid AND lesson_id=:lesson_id AND starttime<:time AND endtime>:time", array(":uniacid" => $_W["uniacid"], ":lesson_id" => $lessonid, ":time" => time()));
		$discount = $discount_lesson["discount"] ? $discount_lesson["discount"] * 0.01 : 1;
		return $discount;
	}
	function createAlipayUrl($params, $alipay = array(), $is_site_store = false)
	{
		global $_W;
		$tid = $params["uniontid"];
		$set = array();
		$set["service"] = "alipay.wap.create.direct.pay.by.user";
		$set["partner"] = $alipay["partner"];
		$set["_input_charset"] = "utf-8";
		$set["sign_type"] = "MD5";
		$set["notify_url"] = $_W["siteroot"] . "payment/alipay/notify.php";
		$set["return_url"] = $_W["siteroot"] . $_W["uniacid"] . "/mylesson.html?lessonid=" . $params["goodsid"] . "&ispay=1";
		$set["out_trade_no"] = $tid;
		$set["subject"] = $params["title"];
		$set["total_fee"] = $params["fee"];
		$set["seller_id"] = $alipay["account"];
		$set["payment_type"] = 1;
		$set["body"] = $is_site_store ? "site_store" : $_W["uniacid"];
		if ($params["service"] == "create_direct_pay_by_user") {
			$set["service"] = "create_direct_pay_by_user";
			$set["seller_id"] = $alipay["partner"];
		} else {
			$set["app_pay"] = "Y";
		}
		$prepares = array();
		foreach ($set as $key => $value) {
			if ($key != "sign" && $key != "sign_type") {
				$prepares[] = "{$key}={$value}";
			}
		}
		sort($prepares);
		$string = implode("&", $prepares);
		$string .= $alipay["secret"];
		$set["sign"] = md5($string);
		$response = ihttp_request("https://mapi.alipay.com/gateway.do?" . http_build_query($set, '', "&"), array(), array("CURLOPT_FOLLOWLOCATION" => 0));
		if (empty($response["headers"]["Location"])) {
			exit(iconv("gbk", "utf-8", $response["content"]));
			return;
		}
		return array("url" => $response["headers"]["Location"]);
	}
	public function readCommonCache($name)
	{
		global $_W;
		$data = cache_load($name);
		$update_time = intval(cache_load("update_time_" . $_W["uniacid"]));
		if (empty($data) || time() > $update_time) {
			if (time() > $update_time) {
				cache_write("update_time_" . $_W["uniacid"], time() + 30);
			}
			return false;
		} else {
			return $data;
		}
	}
	public function createPayLog($params)
	{
		global $_W;
		if (!is_array($params) || empty($params["module"]) || empty($params["tid"]) || empty($params["fee"]) || empty($params["type"])) {
			return error(-1, "参数错误");
		}
		$log = pdo_get("core_paylog", array("tid" => $params["tid"], "uniacid" => $_W["uniacid"], "module" => $params["tid"]));
		if (!empty($log)) {
			return $log["plid"];
		}
		$moduleid = pdo_fetchcolumn("SELECT mid FROM " . tablename("modules") . " WHERE name = :name", array(":name" => $params["module"]));
		$moduleid = empty($moduleid) ? "000000" : sprintf("%06d", $moduleid);
		$data = array("uniacid" => $_W["uniacid"], "acid" => $_W["acid"], "openid" => $params["openid"], "module" => $params["module"], "fee" => $params["fee"], "card_fee" => $params["card_fee"], "tid" => $params["tid"], "type" => $params["type"], "uniontid" => date("YmdHis") . $moduleid . random(8, 1), "status" => 0, "is_usecard" => 0, "card_id" => 0, "encrypt_code" => '');
		if (!pdo_insert("core_paylog", $data)) {
			message("支付接口繁忙，请稍候重试");
		}
		$plid = pdo_insertid();
		$data["plid"] = $plid;
		return $data;
	}
	public function tranTime($time)
	{
		$rtime = date("m-d H:i", $time);
		$htime = date("H:i", $time);
		$time = time() - $time;
		if ($time < 60) {
			$str = "刚刚";
		} elseif ($time < 60 * 60) {
			$min = floor($time / 60);
			$str = $min . "分钟前";
		} elseif ($time < 60 * 60 * 24) {
			$h = floor($time / (60 * 60));
			$str = $h . "小时前";
		} elseif ($time < 60 * 60 * 24 * 3) {
			$d = floor($time / (60 * 60 * 24));
			if ($d == 1) {
				$str = "昨天";
			} else {
				$str = "前天";
			}
		} else {
			$str = $rtime;
		}
		return $str;
	}
	public function isMobile()
	{
		if (isset($_SERVER["HTTP_X_WAP_PROFILE"])) {
			return true;
		}
		if (isset($_SERVER["HTTP_VIA"])) {
			return stristr($_SERVER["HTTP_VIA"], "wap") ? true : false;
		}
		if (isset($_SERVER["HTTP_USER_AGENT"])) {
			$clientkeywords = array("nokia", "sony", "ericsson", "mot", "samsung", "htc", "sgh", "lg", "sharp", "sie-", "philips", "panasonic", "alcatel", "lenovo", "iphone", "ipod", "blackberry", "meizu", "android", "netfront", "symbian", "ucweb", "windowsce", "palm", "operamini", "operamobi", "openwave", "nexusone", "cldc", "midp", "wap", "mobile");
			if (preg_match("/(" . implode("|", $clientkeywords) . ")/i", strtolower($_SERVER["HTTP_USER_AGENT"]))) {
				return true;
			}
		}
		if (isset($_SERVER["HTTP_ACCEPT"])) {
			if (strpos($_SERVER["HTTP_ACCEPT"], "vnd.wap.wml") !== false && (strpos($_SERVER["HTTP_ACCEPT"], "text/html") === false || strpos($_SERVER["HTTP_ACCEPT"], "vnd.wap.wml") < strpos($_SERVER["HTTP_ACCEPT"], "text/html"))) {
				return true;
			}
		}
		return false;
	}
	public function pagination($tcount, $pindex, $psize = 10, $url = '', $context = array("before" => 3, "after" => 3))
	{
		global $_W;
		$pdata = array("tcount" => 0, "tpage" => 0, "cindex" => 0, "findex" => 0, "pindex" => 0, "nindex" => 0, "lindex" => 0, "options" => '');
		$pdata["tcount"] = $tcount;
		$pdata["tpage"] = ceil($tcount / $psize);
		if ($pdata["tpage"] <= 1) {
			return '';
		}
		$cindex = $pindex;
		$cindex = min($cindex, $pdata["tpage"]);
		$cindex = max($cindex, 1);
		$pdata["cindex"] = $cindex;
		$pdata["findex"] = 1;
		$pdata["pindex"] = $cindex > 1 ? $cindex - 1 : 1;
		$pdata["nindex"] = $cindex < $pdata["tpage"] ? $cindex + 1 : $pdata["tpage"];
		$pdata["lindex"] = $pdata["tpage"];
		if ($url) {
			$pdata["faa"] = "href=\"?" . str_replace("*", $pdata["findex"], $url) . "\"";
			$pdata["paa"] = "href=\"?" . str_replace("*", $pdata["pindex"], $url) . "\"";
			$pdata["naa"] = "href=\"?" . str_replace("*", $pdata["nindex"], $url) . "\"";
			$pdata["laa"] = "href=\"?" . str_replace("*", $pdata["lindex"], $url) . "\"";
		} else {
			$_GET["page"] = $pdata["findex"];
			$pdata["faa"] = "href=\"" . $_W["script_name"] . "?" . http_build_query($_GET) . "\"";
			$_GET["page"] = $pdata["pindex"];
			$pdata["paa"] = "href=\"" . $_W["script_name"] . "?" . http_build_query($_GET) . "\"";
			$_GET["page"] = $pdata["nindex"];
			$pdata["naa"] = "href=\"" . $_W["script_name"] . "?" . http_build_query($_GET) . "\"";
			$_GET["page"] = $pdata["lindex"];
			$pdata["laa"] = "href=\"" . $_W["script_name"] . "?" . http_build_query($_GET) . "\"";
		}
		$html = "<ul class=\"hg-40 ql_pages m-auto text-c\">";
		if ($pdata["cindex"] > $pdata["tpage"] || $pdata["cindex"] == 1) {
			$html .= "<li><a class=\"end\">首页</a></li>";
			$html .= "<li><a class=\"end\">上一页</a></li>";
		} else {
			$html .= "<li><a " . $pdata["faa"] . ">首页</a></li>";
			$html .= "<li><a " . $pdata["paa"] . ">上一页</a></li>";
		}
		if ($context["after"] != 0 && $context["before"] != 0) {
			$range = array();
			$range["start"] = max(1, $pdata["cindex"] - $context["before"]);
			$range["end"] = min($pdata["tpage"], $pdata["cindex"] + $context["after"]);
			if ($range["end"] - $range["start"] < $context["before"] + $context["after"]) {
				$range["end"] = min($pdata["tpage"], $range["start"] + $context["before"] + $context["after"]);
				$range["start"] = max(1, $range["end"] - $context["before"] - $context["after"]);
			}
			for ($i = $range["start"]; $i <= $range["end"]; $i++) {
				if ($url) {
					$aa = "href=\"?" . str_replace("*", $i, $url) . "\"";
				} else {
					$_GET["page"] = $i;
					$aa = "href=\"?" . http_build_query($_GET) . "\"";
				}
				$html .= $i == $pdata["cindex"] ? "<li><a class=\"cur\">" . $i . "</a></li>" : "<li><a " . $aa . ">" . $i . "</a></li>";
			}
		}
		if ($pdata["cindex"] >= $pdata["tpage"]) {
			$html .= "<li><a class=\"end\">下一页</a></li>";
			$html .= "<li><a class=\"end\">尾页</a></li>";
		} else {
			$html .= "<li><a " . $pdata["naa"] . ">下一页</a></li>";
			$html .= "<li><a " . $pdata["laa"] . ">尾页</a></li>";
		}
		$html .= "</ul>";
		return $html;
	}
}