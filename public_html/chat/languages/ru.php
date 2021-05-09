<?php
$translit_table_general_ru =  array("a" => "�",
                                     "b" => "�",
                                     "d" => "�",
                                     "e" => "�",
                                     "f" => "�",
                                     "h" => "�",
                                     "g" => "�",
                                     "i" => "�",
                                     "j" => "�",
                                     "k" => "�",
                                     "l" => "�",
                                     "m" => "�",
                                     "n" => "�",
                                     "o" => "o",
                                     "p" => "�",
                                     "r" => "�",
                                     "s" => "�",
                                     "t" => "�",
                                     "u" => "�",
                                     "v" => "�",
                                     "w" => "�",
                                     "y" => "�",
                                     "'" => "�",
                                     "z" => "�"
                                     );

$translit_table_polysymbolic_ru =  array("shch"=>"�",
                                          "sch"=> "�",
                                          "tsh"=> "�",
                                          "ww"=> "�",
                                          "xh"=> "�",
                                          "ye" => "�",
                                          "kh" => "�",
                                          "ts" => "�",
                                          "tz" => "�",
                                          "ch" => "�",
                                          "sh" => "�",
                                          "zh" => "�",
                                          "yu" => "�",
                                          "ju" => "�",
                                          "ja" => "�",
                                          "ya" => "�",
                                          "ia" => "�"
                                         );
define("MAX_POLY_VAL_RU", 4);
define("MIN_POLY_VAL_RU", 2);

if (!defined("_TRANSLITE_RU_")):
define("_TRANSLITE_RU_", 1);

function translit_ru($msg) {
  global $translit_table_general_ru, $translit_table_polysymbolic_ru, $translit_table_start_ru;

  $word_arr = array();
  $word_arr = explode(" ", $msg);


  for($i = 0; $i < count($word_arr); $i++) {
  //first-letter check
  $word_arr[$i] = trim($word_arr[$i]);
  if(strlen($word_arr[$i]) == 0) continue;

  $lwr_test  = $word_arr[$i];
  $word_arr[$i] = strtolower($word_arr[$i]);

  if(strcmp($lwr_test, $word_arr[$i]) != 0) $IsMixedCase = true;
  else $IsMixedCase = false;

  //maybe smile?
  $a = substr($word_arr[$i], 0, 1);
  if($a == "*") continue;

  for($start_case = MAX_POLY_VAL_RU; $start_case >= MIN_POLY_VAL_RU; $start_case = $start_case -1) {
  reset($translit_table_polysymbolic_ru);
  while ($t_val = current($translit_table_polysymbolic_ru)) {
 $eng = key($translit_table_polysymbolic_ru);
  if(strlen($eng) ==  $start_case) $word_arr[$i] = str_replace($eng, $t_val, $word_arr[$i]);
 next($translit_table_polysymbolic_ru);
  }
  }
  //finally, "main" cycle
  reset($translit_table_general_ru);
  while ($t_val = current($translit_table_general_ru)) {
 $eng = key($translit_table_general_ru);
  $word_arr[$i] = str_replace($eng, $t_val, $word_arr[$i]);
 next($translit_table_general_ru);
  }

  if($IsMixedCase) $word_arr[$i] = UCFirst($word_arr[$i]);
  }
  return implode(" ", $word_arr);
}
endif;

// for rozmova skin
// for daemon - must be ' = ' ONLY
$w_usr_adm_link = "�������";
$w_roz_clear_pub_adm = "������ ��� ����� �� <b>~</b> � ����� ������. �����: <b>*</b>";
//

$w_invisibility = "�����������";
$w_guestbook = "��������";
$w_system_smile = "���������";
$w_favor_smile  = "�������";
$w_favor_yes = "��";
$w_favor_no  = "���";
$w_favor_add = "��������";
$w_favor_rem = "�������";
$w_info_tip  = "�������� ������� ������������ (����� ������� ��� ��� � ������, ��� � ������)";
$w_info_tip_err = "������� ����� ������� ��� ��� � ������, ��� � ������!";
$w_prv_tip = "������� � ������ [Control + Enter]";
$w_pub_tip = "������� � ����� [Enter]";
$w_enc_tip = "��������������";
$w_ext_tip = "����� (� ��� ����� ������ �� ���� :-))!";
$w_usr_all = "���";
$w_usr_all_link = "����";
$w_usr_adm = "������";
$w_usr_boys  = "�����";
$w_usr_boys_link  = "������";
$w_usr_girls = "�������";
$w_usr_girls_link = "��������";
$w_usr_they  = "���";
$w_usr_they_link  = "��";
$w_usr_clan  = "��� ����";
$w_usr_clan_link = "�����";
$w_usr_shaman = "������";
$w_usr_shaman_link = "�������";
$w_roz_who = "��� ����";
$w_roz_color = "����";
$w_roz_msg = "���������";
$w_roz_pvt_log  = "���� ��������";
$w_roz_marr  = "���� :-)";
$w_roz_family = "�������� ��������� � ����";
$w_roz_marr_man_yes = "����� ��";
$w_roz_marr_man_no  = "������";
$w_roz_marr_wom_yes = "������� ��";
$w_roz_marr_wom_no  = "�� �������";
$w_roz_marr_it_yes  = "������ ��";
$w_roz_marr_it_no = "�� ������";
$w_roz_custom_login = "����������� ��� ����� (<b>#</b> �������� ��� ������������)";
$w_roz_custom_logout  = "����� ��� ������ (<b>#</b> �������� ��� ������������)";
$w_roz_silence  = "��������";
$w_roz_announce = "����������";
$w_roz_silence_msg  = "<b>���������</b> �������� ��� �������� ���-���� �� <b>~ �����.</b> ����������� ��� ���� - ������� ���� �������� �� ������ ���.";
$w_roz_silence_remind = "��� ��������� �������� ���-���� ��� <b>~ ������!</b>";
$w_roz_similar  = "������� ���� (�����������)";
$w_roz_similar_search = "������ ������ ���� ���";
$w_roz_similar_hash_ip  = "� ����������� �� �������� � �� (�������� ��������� ��������)";
$w_roz_similar_hash = "� ���������� �� �������� (������ �����, ���� � ��� �� �������)";
$w_roz_similar_ip = "� ���������� �� (������������, �� �������� ��� ��� ���� � ��� �� �������)";
$w_roz_similar_online = "������ � ����";
$w_roz_browser_id = "�� ��������";
$w_roz_registered_at  = "������� ���������������";
$w_roz_similar_ref  = "����� �� ���� ����: ��� ������������������ ������������� ���������";
$w_roz_userdb = "���� ������ �������������";
$w_roz_common = "���� ������ ������";
$w_roz_from  = "������ �������";
$w_roz_till  = "����� �������";
$w_roz_hours = "����";
$w_roz_minutes  = "������";
$w_roz_seconds  = "�������";
$w_roz_chat_status  = "����������� ������ ������������";
$w_roz_moderator  = "��������� ����";
$w_roz_administrator  = "������������� ����";
$w_roz_room_for = "��� �������";
$w_roz_silenced_adm = "<b>~</b> ��������� �������� �� ���������� <b># �����.</b> �����: <b>*</b>";
$w_roz_ban_adm  = "<b>~</b> ������� �� <b># �����.</b> �����: <b>*</b>. ��� ����: <b>@</b>";
$w_roz_clear_pub  = "�������";
$w_roz_add_announce = "������� ����� ������� ����������!";
$w_roz_add_alert  = "������� ����� ������� ��� � �������� �������!";
$w_roz_add_clear  = "������� ����� ������� ���!";
$w_roz_add_silence  = "������� ����� ������� ��� � �������� � ���� ���������, �� ������� ����� ������� ��������!";
$w_roz_add_ban  = "������� ����� ������� ��� � �������� � ���� ���������, �� ������� ����� ������!";
$w_roz_reiting  = "������� (������� ����� ������� � ����)";
$w_roz_announce_stat  = "� ����� ����� �������� ����������. ����� <b>*.</b>";
$w_roz_warning_stat = "<b>~</b> ������� �������������� �� <b>*.</b>";
$w_roz_damn_cmd = "���������";
$w_roz_undamn_cmd = "������������";
$w_roz_damn_mess  = "<b>�����</b> ������� �������� ��� ����� <b>~!</b>";
$w_roz_undamn_mess  = "<b>�����</b> ���� ���� ��������� � �������� ��� ����� <b>~.</b>";
$w_roz_damn_mess_adm  = "<b>*</b> ������� �������� ��� ����� <b>~!</b>";
$w_roz_undamn_mess_adm  = "<b>*</b> ���� ���� ��������� � �������� ��� ����� <b>~.</b>";
$w_roz_damneds  = "���������";
$w_roz_priest = "����� ����";
$w_roz_rew_mess = "<b>�����</b> ������� ������ <b>~!</b>";
$w_roz_rew_mess_adm = "<b>*</b> ������� ������ <b>~!</b>";
$w_roz_reward_cmd = "���� ������";
$w_roz_reward = "��������";
$w_roz_personal_file  = "������ ���� ������������ :-)";
$w_roz_more_personal  = "������ ������";
$w_roz_add_personal = "�������� ������";
$w_roz_my_clan  = "��� ����";
$w_roz_clans = "�����";
$w_roz_clan_add_user  = "����� ��������� � ����";
$w_roz_clan_delete_user = "����� �������� �� �����";
$w_roz_clan_edit  = "����� ������������� �������� �����";
$w_roz_clan_edit_user = "����� ������������� ������������� ����-�������� ������������, ������� ������� � �����";
$w_roz_clan_add_clan  = "�������� ����";
$w_roz_clan_delete_clan = "������� ����";
$w_roz_clan_status  = "������ � �����";
$w_roz_clan_notfound  = "���� <b>~</b> �� ������!";
$w_roz_clan  = "����";
$w_roz_clan_status  = "������ � �����";
$w_roz_clan_name  = "��� �����";
$w_roz_clan_email = "E-Mail �������������� �����";
$w_roz_clan_url = "����������� ���-���� �����";
$w_roz_clan_avatar  = "������ ����� (��������� (�� 18�14)! ��� ������ �������������)";
$w_roz_clan_logo  = "������� ����� (��� ������� ������������)";
$w_roz_clan_border  = "����� �������������� ������ ����� ������ ��������?";
$w_roz_add_clan = "�������� ����";
$w_roz_remove_clan  = "������� ����";
$w_roz_clan_err_name  = "�� ������ ��� ����� ��� ���� � �������� ������ ��� ����������!";
$w_roz_clan_err_email = "E-Mail ������������!";
$w_roz_clan_err_http  = "URL ������������!";
$w_roz_clan_err_avatar  = "������ ����������! (������� �� ����� ��� 18 � 14 ���, <b><u>������ GIF!</u></b>)";
$w_roz_clan_err_logo  = "���� �������! (������� �� ����� ��� 200 � 200 ���, <b><u>GIF ��� JPG (���������� gif, jpg � jpeg)!</u></b>)";
$w_roz_clan_del_quest = "�� �������, ��� ������ ������� ���� <b>#</b>? (�������� ������ ��������!)";
$w_roz_yes = "��";
$w_roz_no  = "���";
$w_roz_shaman_alert = "<b>~</b> �������� �������������� �� <b>������</b>. �������: <b>#</b>";
$w_roz_clan_notfound = "����� ���� �� ������";
$w_roz_clan_edit_btn = "������������� ����";
$w_roz_style_start = "����������� ��� ������������ �����";
$w_roz_style_end = "����������� ��� ������������ �����";
$w_roz_style = "�����";
$w_roz_clan_edt_add_usr= "�������� ������������";
$w_roz_clan_edt_del_usr= "������� �� �����";
$w_roz_clan_edt_edt_usr= "������������� ������";
$w_roz_clan_edt_edt_cln= "�������� �����";
$w_roz_clan_user_exists= "���� ������������ ��� ������ � �����-�� ����!";
$w_roz_clan_common_entr= "<b>|| # �� ����� \"@\" ������ � �������.</b>";
$w_roz_clan_common_exit= "<b>|| # �� ����� \"@\" ������� �� �������.</b>";
$w_roz_clan_del_avatar = "������� ������";
$w_roz_clan_del_logo = "������� ����";
$w_roz_clan_cst_greet  = "����������� ��� ����� �� ����� (# ������ ���� � �������, @ ������ ����� �����)";
$w_roz_clan_cst_goodbye= "���������� ����� ��� ����� �� ����� (# ������ ���� � �������, @ ������ ����� �����)";
$w_roz_clan_exceeds_lim= "���������� ������������� � ����� ��������� #";
$w_roz_show_admin = "���������� ���� ��� �������������� � ������ �������������";
$w_roz_just_married = "<b>� ����� ������� ~ � # - ���� �����! ��� ����� ���������� ����! �������!!!</b>";
$w_roz_no_married = "<b>~ � # ��������� :-(</b>";
$w_roz_just_married_adm= "<b>~</b> � <b>#</b> - ���� �����! ����� <b>*</b>";
$w_roz_no_married_adm  = "<b>~</b> � <b>#</b> - ���������! ����� <b>*</b>";
$w_filter_tip = "������ [��������] - ������� ���, � ����� ������ �� ������ �������� ���������, ������������ ����� ���.";
$w_filter_tip_on = "������ [�������] - �������� ���, � ����� ������ �� ������ ��� ���������.";
$w_roz_marry_pan = "������";
$w_roz_unmarry_pan = "��������";
$w_roz_marry_who = "����";
$w_roz_marry_with = "�";
$w_roz_pause_tip = "��������� ��������� (���������) ���������";
$w_roz_pause_tip_on = "�������� ��������� (���������) ���������";
$w_roz_agreed = "� ���������� � ��������� �������";
$w_adm_level[ADM_VIEW_PRIVATE] = "������������� ��� �������";
$w_roz_clear_channels  = "��������";
$w_roz_clear_pub_all = "�������� ����� �����?";
$w_roz_clear_priv  = "�������� ������?";
$w_roz_profile = "�������";
$w_roz_show_for_moders = "���������� ����� ������ ���� � ������ '�����������'";
$w_roz_show_ip = "���������� ���� IP (���� ��� �����������)";
$w_roz_old_paste = "��������� ������������� ����� ���������� ����� (���-���� ����� ������� :))";
$w_roz_quaked_msg = "<b>*</b> ������ <b>~</b>";
$w_roz_chat_closed = "��������, ��� �������� ������!";
$w_roz_out_of_space = "�� ������� �������� ����� ���� ���������� ����� (< 10 �����). ����������, ��������� �� ���� � ����������� ������������� ����!";
$w_roz_translit = "��������";
$w_roz_need_cause = "������� ������� ��������!";
$w_roz_my_contributions= "���� ������ �������";
$w_roz_my_contrib_notes= "���� ������ ������� � ������������. �����, ����� ���, �� ������ �� �������, ������� ��������� ����� �������!";
$w_roz_new_message  = "��� ������ ����� ��������� ������! �������� ��� ����� � ";
$w_roz_offline_pm  = "������� PM";
$w_roz_user_banned  = "������������ ������� �� <b>#</b> �� <b>*</b>";
$w_roz_last_action_tim = "����� ������������ ��� � ���";
$w_roz_reduce_traffic  = "��������� �������, ������� ������";
$w_roz_quit  = "�����";
$w_roz_filter = "������";
$w_roz_pause = "�����";
$w_roz_user = "������������";

//user statuses
$w_roz_user_status[] = array("points" => 1000000, "status" => "��������");
$w_roz_user_status[] = array("points" => 500000, "status" => "�������� ���������");
$w_roz_user_status[] = array("points" => 200000, "status" => "�������� ��������� ���������");
$w_roz_user_status[] = array("points" => 150000, "status" => "��������� ���������");
$w_roz_user_status[] = array("points" => 100000, "status" => "���������");
$w_roz_user_status[] = array("points" => 50000, "status" => "������");
$w_roz_user_status[] = array("points" => 25000, "status" => "���������� ����������");
$w_roz_user_status[] = array("points" => 20000, "status" => "���������");
$w_roz_user_status[] = array("points" => 15000, "status" => "����������");
$w_roz_user_status[] = array("points" => 10000, "status" => "����������");
$w_roz_user_status[] = array("points" => 1000, "status" => "�����");

//new in ver > 0.20.31
$w_premoder_room = "��������, ��� ����-������������ �������. ��� �������� ���� ��������� ����� ����������� ���������������.";

$w_pr_noemail = "���������� ��������� ���� �� �-����, �.�. ������ ��� ��� ��������������� ��� �-���� ������.";
$w_pr_title = "����������� ������";
$w_pr_already_sent = "����������� ��� ���� ��������!";
$w_pr_mailtext = "����� �������� ��� ������ � ���� ~, ����������, �������� ����� #";
$w_pr_no_code = "��������, ������������ ��� ����������� ������!";

$w_admin_browserhash_kill = "���-���";
$w_admin_subnet_kill = "�������";
$w_adm_level[ADM_BAN_BY_BROWSERHASH] = "���-���";
$w_adm_level[ADM_BAN_BY_SUBNET] = "�������";



$w_sel_lang = "���� ����������";

if (!defined("_TRANSLITE_RU_")):
define("_TRANSLITE_RU_", 1);

function w_people_ru($num) {
  switch (substr($num,-1,1)) {
  case 2:
  case 3:
  case 4: $zap = "��������"; break;
  default: $zap = "�������"; break;
  }
  if ((substr($num,-2,1) == 1) && $num>10) {$zap = "�������";}
  return $zap;
}
endif;

$w_mail_used = "Email �����, ��������� ����, ��� ������������ � ����� ���� �������������";
$w_max_per_mail = "�� ���� E-Mail ����� �� ������ ���������������� ~ ���(�)";

//new in ver > 0.18.16
$w_regmail_body = "��� ��������� ������ ������ ~ � ���� \"*\", �������� ����� #";
$w_regmail_no_code = "��������, ������������ ��� ���������";
$w_regmail_activated = "��� ����� �����������, �� ������ ����� � ���";
$w_regmail_sent = "���������� �������� �� ��������� email-�����";
$w_regmail_enter_mail = "(�� �������� ������ � ����������� �� ��������� ������������ �� ���� �����)";
$w_already_registered = "��� ~ ��� ���������������.";
$w_registered_only = "��� �������� � '������� ������'. �� ������ ������������������ ����� ����� � ���!";

$w_impro_enter_code = "����������, ������� ��� ������� �� ������ �� ��������";
$w_impro_incorrect_code = "�� ����� �������� ���";

//new in ver > 0.16.08
$w_rules="�������";
$w_statistic = "����������";
$w_total_users = "����� �������������";
$w_last_registered = "��������� ~ ������������������";
$w_last_visit = "��������� �����";

$w_sure_user_delete = "�� ������� ��� ������ ������� ����� ������������??";
$w_user_deleted = "������������ ������";

$w_big_photo = "������� ���� (.gif ��� .jpeg, ����. ~ Bytes, * ����. ������� � # �������� �������)";
//it's redeclaration, so if you have lang-file from previous versions,
//don't forget to remove $w_big_photo from lines below

$w_style = "�����";
$w_bold = "����.";
$w_italic = "����.";
$w_underlined = "��������.";
$w_too_big_photo = "����, ������� �� ��������� ���������, ������� ������. ������������ ������ ~ ����, � ���� ���� * ����";
$w_too_big_photo_width = "����, ������� �� ��������� ���������, ������� ������. ������ ������ ���� ������ ~ ����., � � ������ ���� ������ * ����.";
$w_too_big_photo_height = "����, ������� �� ��������� ���������, ������� ������. ������ ������ ���� ������ ~ ����., � � ������ ���� ������ * ����.";
$w_too_big_avatar = "��������� ���� (������), ������� �� ��������� ���������, ������� ������.  ������������ ������ ~ ����, � ���� ���� * ����";

//new in ver>0.14.24
$w_adm_add_room = "�������� �������";
$w_adm_room_design = "����������������� ������ �������";
$w_edit = "�������������";
$w_room_name = "�������� �������";
$w_bot_name = "��� ���� ��� �������";
$w_list_of_rooms = "������ ������";
$w_set_topic_text = "* ������������� ����� �����: <hr><b><center>#</center></b><hr>";
$w_topic = "�����";
$w_adm_no_permission = "� ��� ��� ���� ��������� ��� ��������";
$w_adm_unban = "���BAN���";
$w_adm_banned_now = "������ ��������:";
$w_adm_nick_or_ip = "��� ��� ��-�����";
$w_adm_ban_until = "��";
$w_adm_cannot_ban_mod = "�� �� ������ �������� ������� ����������";
$w_adm_level[ADM_BAN] = "���";
$w_adm_level[ADM_IP_BAN] = "��� �� ip";
$w_adm_level[ADM_VIEW_IP] = "�������� ���������������� ip-�������";
$w_adm_level[ADM_UN_BAN] = "������ ���-�����";
$w_adm_level[ADM_BAN_MODERATORS] = "��� ������ �����������";
$w_adm_level[ADM_CHANGE_TOPIC] = "����� ������";
$w_adm_level[ADM_CREATE_ROOMS] = "�������� � ���������";
$w_adm_level[ADM_EDIT_USERS] = "�������������� ���������������� ������";

//new in ver >0.09.20
$w_web_indicator = "��������� ������������� ���-����������.";
$w_web_indicator_code = "����� ������������ ����� ~ ���������, ������ ���������� ��������� ����-��� � �������� ��� � ���� �������� ���������:";
$w_too_many = "��������, ������� ����� ������������� � ����.";
$w_too_many_from_ip = "��������, ������� ����� ������������� � ���� �������� � ������ ������";
$w_try_again_later = "���������� �������";
$w_in_room = "������ � �������";
$w_who_in_rooms = "�������";
$w_who_in_current_room = "��������� � ������ ����������� ������� �������";

//for hi-tech skin:
$w_clear_input_field = "�������� ���� �����";
$w_clear_whisper_field = "�������� ������";
$w_stop_scrolling = "������������� ����-���������";
$w_cont_scrolling = "��������� ����-���������";
$w_reload_main = "�������� ���� ���������";
$w_for_registered = "(������ ��� ������������������ �������������)";

//new in ver > 0.07.09a

//user statuses
$w_your_status = "��� ������";
$w_user_status[ONLINE] = "������";
$w_user_status[DISCONNECTED] = "��������";
$w_user_status[AWAY] = "����";
$w_user_status[NA] = "N/A";
$w_user_status[DND] = "�� ����������!";
$w_user_status['PRIVATE'] = "� �������";

$w_st_set = "����������";

//rooms
$w_select_room = "�������� �������";
$w_goto_room = "�������!";
// ~ -- usernick, * -- roomname
$w_goes_to_room = "~ ������ � ������� &quot;<b>*</b>&quot;";
$w_came_from_room = "~ �������� �� ������� &quot;<b>*</b>&quot;";

//message for the flood-checking mechanism
$w_flood = "����! (������������� ����������)";

$w_2ignor = "-���";
$w_2visible = "+���";

//end of new

$w_only_one_tail = "�� ������ ������������ ������ ���� ����������� � ����! ���������� �������� ����.";

//server

$w_server_restarting = "������ ��������� ���������������. ������� ������������ ������...";

//common
$w_banned = "�� ��������� �� ����";
$w_timeout = "����� ����� :-�";
$w_no_user = "��� ������ ������������ � ����!";
$w_title = "(��� Chat.bz)";
$w_copyright = "<center><br>VOC++ BSE <a href=\"http://mvoc.ru\">Mvoc.ru</a> | ������� ����� <a href=\"http://chat.bz\">Chat.bz</a></center>";
//welcome
$w_welcome = "Voodoo chat";
$w_enter_login_nick = "������� ��� ���";
$w_login = "(��� ������ ���� ������ �� 3 �� 15 ��������<br> � ����� ��������� ����� ����������� �������� � ���� _)";
$w_login_button = "&nbsp;Login&nbsp;";
$w_select_design = "������ ����";
$w_select_type = "��� ����";
$w_chat_type["tail"] = "�����������";
$w_chat_type["php_tail"] = "����������� �� ���";
$w_chat_type["reload"] = "������������, � �������������";
$w_chat_type["js_tail"] = "�������� ������������ �� JS";

$w_whisper_to = "����-�� ������";

//bottom:
$w_whisper = "������";
$w_no_whisper = "�����";
$w_color = "����";
$w_say = "�������";
$w_logout = "�����";
$w_too_long = "������� ������� ���������!";
$w_whisper_out = "��� ������������, �������� ��������� ������";

//tail:
$mod_text = "And remember,<br>respect is everything!<br><br>";
$w_right_not_refresh = "��������! ��� ������ ����� �� ���������� 2 ������. ��� ����� ������ �� ������ ���������!!";
$w_try_to_press = "���������� ������ �����.";
$w_new_window = "������. �� �� ������ ��������� ����������� ����� ������. ���������� �������� ����.";
$w_disconnected = "��������, �� ��������� �� ����";
$w_unknown_user = "��� ������ ������������ � ����!";

//who
$w_show_photos = "���������� ����";
$w_dont_show_photos = "��������� ����";
$w_in_chat = "������ � ����";
$w_nobody_in = "������ ��� � ����";
$w_people = "people";

$w_info = "���������� � ";

//shower
$w_history = "�������";

//top
$w_help = "������";
$w_send_mes = "��������� ��������� �� �����";
$w_info_about = "��!";
$w_relogon = "���������";
$w_pictures = "��������";
$w_gun = "�������!";
$w_registration = "�����������";
$w_about_me = "�������";
$w_color_settings = "��������� �����";
$w_feedback = "�����������";

//alerter
$w_pub = "�����";
$w_messages = "���������";
$w_new = "���.";
$w_used = "����� ���.";

//i am
$w_personal_data = "���� ������������ ����������";
$w_show_data = "���������� ������ �� ���� ������ ��� �����������";
$w_surname = "�������";
$w_name = "���";
$w_birthday = "���� ��������";
$w_city = "�����";
$w_gender = "���";
$w_male = "���";
$w_female = "���";
$w_unknown = "����������";
$w_addit_info = "�������������� ����������";
$w_small_photo = "��������� ���� (40x40 pixels)";
$w_check_for_delete = "�������� ����� �������, ��� ������";
$w_other_photo = "�������� ���� ���� �� ������ �������� �������";
$w_email = "e-mail";
$w_homepage = "URL �������� ��������";
$w_icq = "ICQ UIN";
$w_if_wanna_change_password = "���� �� ������ �������� ��� ������, ������� ��� ��� ���� ����. ���� ��� -- �������� ���� ����� �������.";
$w_new_password = "����� ������";
$w_confirm_password = "������������� <i>������</i> ������";
$w_update = "��������";
$w_current_password = "����������, ������� ��� ������� ������ � ������� &quot;$w_update&quot; ����� �������� ���� ������";

//updateData
$w_incorrect_password = "������������ ������";
$w_pas_not_changed = "������ �� �������";
$w_pas_changed = "������ �������!";
$w_succ_updated = "���� ������ ������� ���������!";


//frameset
$w_enter_password = "���������� ������� ��� ������";
$w_incorrect_nick = "������������ ���!";
$w_try_again = "���������� ���";
$w_already_used = "���� ��� ��� ������������ � ����!";

//Robot words... ~ will replaced with user nick
$w_rob_name = "Robik";
$w_rob_login = "<b>|| <a style='text-decoration: underline' style='{cursor: pointer}' onClick=\"javascript:parent.Whisper('~');\">~</a> ������ � �������.</b>";
$w_rob_hb = "~&gt; <b>� ���� ��������!</b>";
$w_rob_logout = "~ ��������� � ���� � ������.";
$w_rob_idle = "~ ������ �� ������������ (�������).";


//fullinfo
$w_no_such_reg_user = "��������, �� ������ ����� ������������������ ������������";

//userinfo  ~ will replaced with user nick
$w_search_results = "���������� ������";
$w_select_nick = "�������� ���";
$w_enter_nick = "������� ��� ��� ������";
$w_search_comment = "(���� * ���������� ����� ���������� ����� ��������)";
$w_search_button = "������!";
$w_search_no_found = "~ �� ������";
$w_search = "����� �������������";

//snd
$w_message_text = "����� ���������";
$w_send = "���������";
$w_enter_nick_to_send = "��� ��������";
$w_user_wrote = "~ �������(�):";
$w_not_shure_in_nick = "���� �� �� ������ ��� �����, ���������� ����� (���� * ���������� ����� ���������� ����� ��������)";

//postMessage
$w_incorrec_nick_to_send = "������������ ��� ��������";
$w_message_sended = "���� ��������� ������� ��������";
$w_message_error = "������ ��� �������� ���������. ���� �������� ����������";
$w_back_to_send = "��������� � �������� ���������";

//meOp
// ~ - from User, * - time
$w_back_to_userboard = "��������� � ������ ���������";
$w_status = "&nbsp;";
$w_from = "��";
$w_subject = "����";
$w_no_subject = "��� ����";
$w_at_date = "����";
$w_from_line = "From ~, sended at *";
$w_date_format = "d/m/Y, H:i";
$w_answer = "��������";
$w_delete = "�������";
$w_del_checked = "������� ����������";
$w_stat[0] = " ";
$w_stat[1] = "<b>N</b>";
$w_stat[2] = "<b>R</b>";
$w_stat[3] = " ";

//pictures
$w_symbols = "�����";
$w_picture = "��������";
$w_about_smiles = "
                <b>����������� ��������</b> ������� �� 4-� (��� �����) �������� - �����������������:
                <ol>
                 <li>����� (����� ����������). - &quot;<b>&gt;</b>&quot; ��� &quot;<b>&lt;</b>&quot;. ���� ��������� - ������� ��� ������
                 <li>����� (�����������) - &quot;<b>:</b>&quot; ��� &quot;<b>=</b>&quot; - ������� �����, &quot;<b>;</b>&quot; - ����������
                 <li>���. �� �������� ��� ���-����� ���, ������� ����� ����������... �� ���� ������� - ����� ������ &quot;<b>-</b>&quot;, &quot;<b>^</b>&quot; ��� &quot;<b>'</b>&quot;
                 <li>��� (�����������):
                  <ul>
                  <li>&quot;<b>)</b>&quot;, &quot;<b>D</b>&quot; ��� &quot;<b>]</b>&quot; - ������
                  <li>&quot;<b>(</b>&quot; - ����������� �������
                  <li>&quot;<b>|</b>&quot; - �����������... ���� ������ ������ ������ �� �������� ���� ��������� ������� :)
                  <li>&quot;<b>P</b>&quot; ��� &quot;<b>p</b>&quot; (� ������� � ���������� �����) - �������� ����
                  <li>&quot;<b>O</b>&quot; ��� &quot;<b>o</b>&quot; (� ������� � ���������� �����) - �������� �������� ���
                  </ul>
                </ol>
                �� ������ �������� �� �������� ����, ����� �������� �� ��� � ���� ���������
                ";

//admin
$w_no_admin_rights = "��� ���� ��������������";
$w_admin_action = "��������";
$w_admin_alert = "������������";
$w_admin_kill = "���������";
$w_admin_ip_kill = "��������� �� ip-������";
$w_admin_reason = "�������";
$w_admin_ban = "��BAN���";
$w_kill_list = "Kill list";
$w_admin_unban = "UnBan";
$w_alert_text = "<b>~</b> �������� �������������� �� <b>����������</b>. �������: <b>#</b>";
$w_kill_text = "<b>���������</b> ��������� <b>~</b> �� $. �������: <b>#</b>";
$w_kill_time = "��������� ��";

$w_times[0]["name"] = "1 ������";
$w_times[0]["value"] = 60;
$w_times[1]["name"] = "3 ������";
$w_times[1]["value"] = 180;
$w_times[2]["name"] = "5 �����";
$w_times[2]["value"] = 300;
$w_times[3]["name"] = "10 �����";
$w_times[3]["value"] = 600;
$w_times[4]["name"] = "1 ���";
$w_times[4]["value"] = 3600;
$w_times[5]["name"] = "5 �����";
$w_times[5]["value"] = 18000;
$w_times[6]["name"] = "�����";
$w_times[6]["value"] = 86400;
$w_times[7]["name"] = "������";
$w_times[7]["value"] = 604800;
$w_times[8]["name"] = "��������";
$w_times[8]["value"] = 315360002;

//leave
$w_leave = "<br>������� �� �������!<br><br><a href=\"index.php\">��������� � ���</a>";

//registration
//in the 'top' section $w_registration = "�����������";
$w_password = "������";
$w_reg_text = $w_login;
$w_password_mismatch = "<br>������ �� ���������";
$w_succesfull_reg = "<br>��� ��� ~ ������� ���������������.<br><b><font color=red>���� �� ���������� � ������ ������ � ����, ��� ����� ��������� � ����, ��� �� ��������� �������� � ����.</font></b>";
$w_reg_error = "<br>������ �� ����� �����������. ���������� ��� ��� �����.";

//feedback
$w_feed_headline = "�� ������ ��������� ��� ���� ���������:";
$w_feed_name = "�.�.�.";
$w_feed_message = "���� ���������";
$w_feed_sent_ok = "���� ��������� ������� ����������! �������!";
$w_feed_error = "��������� ������ ��� �������� ���������. ����������, ����������, ��� ��� �����.";

$registered_colors[0][0] = "��������";
$registered_colors[0][1] = "#800000";

$registered_colors[1][0] = "��������";
$registered_colors[1][1] = "#0066FF" ;

$registered_colors[2][0] = "�����";
$registered_colors[2][1] = "#d2b48c" ;

$registered_colors[3][0] = "�������";
$registered_colors[3][1] = "#008000" ;

$registered_colors[4][0] = "���������";
$registered_colors[4][1] = "#b22222" ;

$registered_colors[5][0] = "���������";
$registered_colors[5][1] = "#f08080" ;

$registered_colors[6][0] = "����������";
$registered_colors[6][1] = "#a52a2a" ;

$registered_colors[7][0] = "�������";
$registered_colors[7][1] = "#ff0000" ;

$registered_colors[8][0] = "�������";
$registered_colors[8][1] = "#DAA520";

$registered_colors[9][0] = "������";
$registered_colors[9][1] = "#fa8072" ;

$registered_colors[10][0] = "������� �����";
$registered_colors[10][1] = "#2e8b57" ;

$registered_colors[11][0] = "���������";
$registered_colors[11][1] = "#808000" ;

$registered_colors[12][0] = "���������";
$registered_colors[12][1] = "#ff8c00" ;

$registered_colors[13][0] = "�������";
$registered_colors[13][1] = "#da70d6" ;

$registered_colors[14][0] = "����";
$registered_colors[14][1] = "#cd853f" ;

$registered_colors[15][0] = "����������";
$registered_colors[15][1] = "#800080" ;

$registered_colors[16][0] = "�������";
$registered_colors[16][1] = "#ff1493" ;

$registered_colors[17][0] = "�����";
$registered_colors[17][1] = "#808080" ;

$registered_colors[18][0] = "�����";
$registered_colors[18][1] = "#0000ff" ;

$registered_colors[19][0] = "�����";
$registered_colors[19][1] = "#dda0dd" ;

$registered_colors[20][0] = "����������";
$registered_colors[20][1] = "#8a2be2" ;

$registered_colors[21][0] = "������";
$registered_colors[21][1] = "#ff00ff" ;

$registered_colors[22][0] = "���������";
$registered_colors[22][1] = "#008080" ;

$registered_colors[23][0] = "��������";
$registered_colors[23][1] = "#000000" ;

$registered_colors[24][0] = "����������";
$registered_colors[24][1] = "#d2691e" ;

$registered_colors[25][0] = "�����-�����";
$registered_colors[25][1] = "#000080" ;

$default_color = 23; #000000;
$highlighted_color = 7; #ff0000;

$w_roz_only_for_club = "��� ����, ��� �� �������� ������ � ����� �������, �� ������� ������ �������������� � �����, ����� ���� ������ � ������� \"<b>".$w_about_me."</b>\"";
$w_roz_not_in_club = "���� ��� �� ����������� � �����.";
$w_roz_not_allowed = "� ��� ��� ���� ������� � ��� �������!";
$w_enter_password_room = "��� ������� �������� �������. ������� ���";
$w_full_access = "���� ������ �� ���� ��������";
$w_money  = "������";
$w_membered_by = "������ ��� �� ������";
$w_classified_info = "��������� ���������� � ������������";
$w_info_browser  = "�������";
$w_info_os  = "������������ �������";
$w_info_user_agent = "������ USER_AGENT";
$w_grant_access  = "������������� ������������ ��� ������� �������";
$w_no_money = "�� ������� ������!";
$w_money_exchange  = "�������� ������ �� �������";
$w_exchange_tax  = "���� ������ (�������� � �������)";
$w_howmany_exchange  = "������� �������� �������";
$w_exchange_do = "��������!";
$w_no_credits  = "�� ������� �������!";
$w_security = "��������� �������������";
$w_security_warn = "������ �� ������� � ���������� �������������, ����� ��� �� <b>����� ���������, ��� ������ �� �������</b>! � ��������� ������ ��� ����� �������� ����������� ��� �� �� ������� ������ � ���� ����� ��� ���� �������!";
$w_limit_by_hash = "��������� ������� �� ����� ���������� � ���� (�������������)";
$w_limit_by_ip = "��������� IP (�������) �� ����� ���������� � ���� (�������������)";
$w_limit_by_cookie = "��������� cookie �� ����� ���������� � ���� (��� ���������)";
$w_limit_by_ip_only  = "(������ ��������) ��������� �������� � ��� <b>�������������</b> � ���� IP (��� ��������, ����������� ; ��� ����������)";
$w_security_error  = "��������� ������� ������������� ����. ���������� ������ ������� ���������� ������������� (�� �����!) � ����� �������.";
$w_security_error_ip = "�� �� ������ ����� � ��� � ����� IP-������, ��� ��� �� �� �������� ����������� ���������� �������.";
$w_roz_jail = "� ���! :)";
$w_jailed = "��� ������ � ���! ��������, ����� ���� ����...";
$w_roz_jailed_adm  = "<b>~</b> ������� � ��� �� <b># �����.</b> �����: <b>*</b>";
$w_jail_text = "<span class=ha><b>���������</b> ����� � ��� <b>~</b> �� $. �������: <b>#</b></span>";
$w_roz_jailed_mess = "������������ ������� � ��� �� ";
$w_roz_silenced_mess = "������������ ��������� �������� �� ";
$w_already_punished  = "������������ ��� �������!";
$w_private_sound = "����������� ���� ��� ��������� ���������� ��������� (������ Internet Explorer)";
$w_font_face = "����� ������� �������� ��������� ����";
$w_font_size = "������ ������ (% �� ��������)";
//Added by MisterX
$shop = "�������";
$shop_quantity = "����������";
$shop_quantity_unlimited = "�������������";
$shop_title = "��������";
$shop_price = "����";
$shop_vip = "������ ��� VIP";

$w_adm_user_add_clan = "~ ������� # � ���� ";
$w_adm_user_del_clan = "~ ������ # �� ����� ";
$w_adm_user_exchange = "�������� ~ ������� �� # �������� (���� $ ��������, ����� %)";
$w_adm_user_buy  = "������� ���� \"~\" �� # �������� (���� $ ��������, ����� %)";
$w_adm_user_present  = "�������� ���� \"~\" �� #";
$w_adm_user_transfer = "���� \"~\" �������� �� #";
$w_adm_user_present_from = "���� \"~\" �������� #";
$w_adm_user_transfer_from  = "���� \"~\" �������� # �� * ������(��) (���� $ ��������, ����� %)";
$w_adm_user_item_used  = "���� \"~\" ������������";
$w_adm_user_item_used_on = "���� \"~\" ������������ �� #";
$w_adm_user_item_removed = "���� \"~\" �������";
$w_adm_user_item_returned  = "���� \"~\" ���������� � ������� (���� $ ��������, ����� %)";

$w_shop_you_have = "� ��� ����";
$w_shop_other  = "������";
$w_shop_all = "���";
$w_shop_buy = "������";
$w_shop_present  = "��������";
$w_shop_delete = "�������";
$w_shop_transfer = "��������";
$w_shop_back = "�������";
$w_shop_category_empty = "� ���� ��������� ������� ���";
$w_shop_no_items = "���� ����� ��� ���������";
$w_shop_no_such_item = "������ ������ �� ����������";
$w_shop_no_present = "������� ������ �������� ��� ������������";
$w_shop_actions  = "�����������";
$w_shop_invisibility = "������ �����������";
$w_shop_invisibility_use = "������";

$w_money_transfer  = "��������� ������ ������� ������������ ��� � ����� �����...";
$w_money_transfer_note = "������, ��� �� ������� � ������ ����� ������������� ����� ����� # ������(��).";
$w_money_transfer_accept = "����������� �������";
$w_money_transfer_password = "����������, ������� ���� ���� ������ ��� ������������� ��������";
$w_money_transfer_destination  = "����������, ������� ��� ������������, �������� �� ������ ��������� ������ <i>���</i> ��������� ������� ��� ����.";
$w_money_transfer_amount = "����� (� ����� ������)";
$w_money_transfer_ok = "������� �������� �������!";
$w_adm_money_transfer_from = "# �������� ���������� � ~ (� ��� ���� $ ��������, ����� %)";
$w_adm_money_transfer  = "# �������� ���������� �� ~ (���� $ ��������, ����� %)";
$w_clan_treasury = "����� �����";
$w_adm_clan_penalty  = "# �������� ����� �� ���� ~ (���� $ ��������, ������ %)";
$w_adm_clan_rew  = "# �������� ��������� � ����� ��� ������� ��� ~ (���� $ ��������, ������ %)";
$w_adm_chaos = "����";
$w_adm_chaos_put = "<b>���������</b> �������� � ���� <b>~</b> �� # �����. �������: ";
$w_adm_chaos_adm = "<b>*</b> �������� � ���� <b>~</b> �� # �����. �������: ";
$w_user_chaos  = "�� ���������� � ����� �� ~. ��� ��������, ��� �� �� ������ ����������� ������� � ����� ������ (������ � ������), �� ������� �������������� � �������� � ������� ������.";
$w_roz_chaos_mess  = "������������ ��������� � ����� �� ";

$w_webcam_show = "��������� ������ ������������� �������� ����� ���������";
$w_webcam_note = "<b>�����:</b>��������� <b>WebcamXP</b> ������ ���� �����������, ���������������� � ��������, ��� �� ���� ������ ����� ������ ���.  �� ������ ������� ��������� � ����� <a href=http://www.webcamxp.com>http://www.webcamxp.com</a>";
$w_webcam_ip_note  = "<b>�����:</b> � ��� ������ ���� �������� IP-�����, ��� ��������, ��� �� ������ ���� ���������� � Internet ��������, <b>���</b> ������-������� ��� ��������� � �� ������������ ��������� ����.";
$w_webcam_ip = "IP ������ ����������:";
$w_webcam_suggest  = "������ �����, ��� IP ������ ���� ";
$w_webcam_port = "����� ����� ��� ����� ��������� (�� ��������� 8080):";
$w_webcam_no = "��������, �� �� �� ���������� �������� � Internet (�� ����������� ������-������, ������� ��� ��������� ����). �������� ��������� ���������� :-(";
$w_clear_nick_after  = "������� ����� ��������";
$w_add_features  = "�������������� �����������";
$w_about_user  = "������ ����������";
$w_security_opt  = "������������";
$w_items_opt = "�������";
$w_money_opt = "�������";
$w_webcam_opt  = "���-������";
$w_another_opt = "������";

$w_color_nick  = "������� ���";
$w_color_nick_note = "������� ��� ����� ��������� ���� ���, ����� �������. <b>�����:</b> ������������ ����������� ��� ������� ��� ����� ������!<font color=red><b>����� ����, ��� �� �������� ���� ����, ������� �� � ����������� � ���!</b></font>";
$w_color_nick_current  = "������������ ���";
$w_color_nick_sample = "�������";
$w_reffered_by = "������ �� ������ ��";
$w_adm_reffered_payment  = "�������� # ������ ��� �������������� �� ������ ~ (���� $ ������, ����� %)";
$w_adm_reffered_subject  = "�� �������� ��������������";
$w_adm_reffer_menu = "��������";
$w_adm_reffer_note = "� ���� ������ ����������� ������ � ������ ���������� -- ������, ������� �� ���������� � ���. ����� ������ �� ��� ��������� �������� �� ����� ~ �������, �� �������� ����������� ������������� ������� � ������� # ������ � *% ��������� �� ����� ������ �������� �������� ����� �������. ��� �� ���������� �������� � ���, ������ ����� ��� ������, ������� �������� ����.";
$w_adm_reffer_link = "���� ������";
$w_roz_points  = "�������";
$w_days = "����";
$w_clan_money_transfer = "������� ����� � ����� ����� �� ���� ������������";
$w_clan_money_transfer_cln = "# ������ �� ����� ����� ������� ~ �� ���� ������������ ! (���� $ ������ � �����, ����� %)";
$w_photo_reiting = "������";
$w_photo_reiting_do  = "������� ����";
$w_photo_reiting_do_not  = "�� ��� ���������� �� ��� ����������!";
$w_photo_reiting_vote  = "�������������";
$w_photo_reiting_take_part = "��������� ������� � �������� ����������";
$w_mod_remove_photo  = "������� ����������";
$w_mod_remove_photo_adm  = "���������� ������������ # ������ $";
$w_mod_remove_photo_user = "���� ���������� ���� ������� ����������� ��� �����, ��� ������������ �������� ����. ����������, � ���������� ���������� ������ ���� ����������. �� ������� ��������������, ��������� ����� ���������� -- ������� ����� ���� ������������!";
$w_mod_remove_photo_subj = "���� ���������� ���� �������";
$w_reg_seconds_left  = " ������ �������� �� ������ �����������. ����������, �������� ������� �� ��� ����� ;)";
$w_pass_secutity_time  = "������� ������������� ����������, ��� ����� �������� ������!";
$w_pass_secutity_note  = "������� ������ ������:".
                          "<ul><li>... ���� �� ����� 8 �������� � ������ ��� ������, ��� ������������� ������������� ���������� ���� ��� �������������� ��������;".
                          "<li>... �������� �� �������� �������� � ������� ���������, ���� � ������ ���������;".
                          "<li>... �� ���� ��������� ������, ��������������� ��� ����������;".
                          "<li>... �� ���� ������, ������, ������� �������� ��� ���� ����, ��� ����� ������������� � ����;".
                          "<li>... ������ ��������� ��� ���������������� �������.</ul>";
$w_pass_secutity_check = "������������ ���������� ��� � ������������� ������� ������";
$w_pass_secutity_alert = "��� ������ �������! ������� ���, ����������, � ����� �������!";
$w_chat_welcome_main = "����� ���������� � ��� ���!";
$w_chat_welcome_text = "���� ��� ��� ���������� � �� �������� ��������� �� ����� ���� ���, ��, ����������, � ���� ��������� ������ \"�����������\" -- ������� ������� ������ ����� ����.";
$w_chat_welcome_note = "��������� 1 ��� ��� �������� ������ ����";
$w_chat_go  = "� ���";
?>