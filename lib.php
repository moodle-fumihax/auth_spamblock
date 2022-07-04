<?php

defined("MOODLE_INTERNAL") || die();

function auth_spamblockbeta_extend_signup_form($mform){
    global $SESSION,$DB;
    $config = get_config("auth_spamblockbeta");
    
    if ($config->captcha==0){
        $token = $SESSION->logintoken["core_auth_login"]["token"];
        $answer = null;
        $nofirst = $DB->record_exists_sql("SELECT id FROM {auth_spamblockbeta} WHERE logintoken = \"$token\"");
        //フォームの再生成のみ（logintokenが変わらずにページの更新などがされた場合）がされたかどうかをチェック
        $nowans = $DB->get_record_sql("SELECT currentanswer,nextanswer FROM {auth_spamblockbeta} WHERE logintoken = \"$token\"");
        $donereforming = strcmp($nowans->currentanswer,$nowans->nextanswer);//値が0の場合は同じ文字列
        if(!$nofirst){//初回かどうか
            //答えを生成
            $alphabets = range("A","Z");
            for ($i=0;$i<5;$i++){
                $answer .= $alphabets[rand(0,count($alphabets)-1)];
            }
            //答えを格納
            //insert_record用のdataobjectの作成
            $obj = new stdClass();
            $obj->logintoken = $token;
            $obj->currentanswer = $answer;
            //次の分の答えも生成
            $answer = null;
            for ($i=0;$i<5;$i++){
                $answer .= $alphabets[rand(0,count($alphabets)-1)];
            }
            $obj->nextanswer = $answer;
            //レコードを挿入
            $DB->insert_record("auth_spamblockbeta",$obj,False);

        }else{
            //答えを生成
            $alphabets = range("A","Z");
            for ($i=0;$i<5;$i++){
                $answer .= $alphabets[rand(0,count($alphabets)-1)];
            }
            //答えを格納
            //insert_record用のdataobjectの作成
            //答えを更新
            //idを取得（update_recordに必要なため）
            $token = $SESSION->logintoken["core_auth_login"]["token"];
            $id = $DB->get_record_sql("SELECT id FROM {auth_spamblockbeta} WHERE logintoken = \"$token\"");
            $obj = new stdClass();
            $obj->id = $id->id;
            $obj->nextanswer = $answer;
            $DB->update_record("auth_spamblockbeta",$obj);

        }
        
        //要素追加
        $mform->addElement("header","CAPTCHA",new lang_string("auth_spamblockbetacaptchaheader","auth_spamblockbeta"));
        if(!$nofirst||$donereforming!=0){//初回もしくはページの再生成のみがされたかどうか
            $answer = $DB->get_record_sql("SELECT currentanswer FROM {auth_spamblockbeta} WHERE logintoken = \"$token\"");
            $mform->addElement("static","nolobot",new lang_string("auth_spamblockbetacaptchadescriptionbefore","auth_spamblockbeta").$answer->currentanswer.new lang_string("auth_spamblockbetacaptchadescriptionafter","auth_spamblockbeta"));
        }else{
            $answer = $DB->get_record_sql("SELECT nextanswer FROM {auth_spamblockbeta} WHERE logintoken = \"$token\"");
            $mform->addElement("static","nolobot",new lang_string("auth_spamblockbetacaptchadescriptionbefore","auth_spamblockbeta").$answer->nextanswer.new lang_string("auth_spamblockbetacaptchadescriptionafter","auth_spamblockbeta"));
        }
        $mform->addElement("text","useranswer",new lang_string("auth_spamblockbetacaptchafield","auth_spamblockbeta"));
        $mform->addRule("useranswer",get_string("required"), "required");
        $mform->setType("useranswer", PARAM_TEXT);
    } 
}

function auth_spamblockbeta_validate_extend_signup_form($data){
    global $SESSION,$DB;
    $config = get_config("auth_spamblockbeta");
    if ($config->captcha==0){
        $token = $SESSION->logintoken["core_auth_login"]["token"];
        $errors = array();
        //答えを取得
        $answer = $DB->get_record_sql("SELECT currentanswer,nextanswer FROM {auth_spamblockbeta} WHERE logintoken = \"$token\"");
        //ユーザの回答と比較
        if (strcmp($data["useranswer"],$answer->currentanswer) != 0){
            $errors["useranswer"] = new lang_string("auth_spamblockbetacaptchaanswererror","auth_spamblockbeta")."you:".$data["useranswer"]." ans:".$answer->currentanswer;
            //答えを更新
            //nextanswerの値をcurrentanswerに格納
            //idを取得（update_recordに必要なため）
            $token = $SESSION->logintoken["core_auth_login"]["token"];
            $id = $DB->get_record_sql("SELECT id FROM {auth_spamblockbeta} WHERE logintoken = \"$token\"");
            $obj = new stdClass();
            $obj->id = $id->id;
            $obj->currentanswer = $answer->nextanswer;
            $DB->update_record("auth_spamblockbeta",$obj);
        }
        return $errors;
    }
}