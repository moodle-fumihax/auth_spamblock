<?php

defined("MOODLE_INTERNAL") || die();

function auth_spamblock_extend_signup_form($mform){
    global $SESSION,$DB,$CFG;
    $config = get_config("auth_spamblock");

    //直接ログインページにアクセスすることを禁止
    if($config->directaccess == 0){
        if (!isset($_SERVER["HTTP_REFERER"])){
            $page = $CFG->wwwroot."/login/index.php";
            redirect($page);
        }
    }   
    //ここから答えの生成、描画処理
    $token = $SESSION->logintoken["core_auth_login"]["token"];
    $answer = null;
    $answer_length = intval($config->answerlength)+1;//答えの文字数設定
    $exists = $DB->record_exists_sql("SELECT id FROM {auth_spamblock} WHERE logintoken = \"$token\"");
    if(!$exists){//初アクセス（セッション）かどうか
        //答えを生成
        $alphabets = range("A","Z");
        for ($i=0;$i<$answer_length;$i++){
            $answer .= $alphabets[rand(0,count($alphabets)-1)];
        }
        //答えを格納
        //insert_record用のdataobjectの作成
        $obj = new stdClass();
        $obj->logintoken = $token;
        $obj->currentanswer = $answer;
        //次の分の答えも生成
        $obj->nextanswer = $answer;
        //レコードを挿入
        $DB->insert_record("auth_spamblock",$obj,False);
    //ページの再生成のみが行われたかどうか
    }elseif(strcmp($_SERVER["HTTP_REFERER"],$CFG->wwwroot."/login/signup.php?")!=0 && strcmp($_SERVER["HTTP_REFERER"],$CFG->wwwroot."/login/signup.php")!=0){
        //答えを生成
        $alphabets = range("A","Z");
        for ($i=0;$i<$answer_length;$i++){
            $answer .= $alphabets[rand(0,count($alphabets)-1)];
        }
        //答えを格納
        //update_record用のdataobjectの作成
        $obj = new stdClass();
        //idを取得（update_recordに必要なため）
        $id = $DB->get_record_sql("SELECT id FROM {auth_spamblock} WHERE logintoken = \"$token\"");
        $obj->id = $id->id;
        $obj->currentanswer = $answer;
        $obj->nextanswer = $answer;
        //答えを更新
        $DB->update_record("auth_spamblock",$obj);
    }else{
        //答えを生成
        $alphabets = range("A","Z");
        for ($i=0;$i<$answer_length;$i++){
            $answer .= $alphabets[rand(0,count($alphabets)-1)];
        }
        //答えを格納
        //update_record用のdataobjectの作成
        $obj = new stdClass();
        //idを取得（update_recordに必要なため）
        $id = $DB->get_record_sql("SELECT id FROM {auth_spamblock} WHERE logintoken = \"$token\""); 
        $obj->id = $id->id;
        $obj->nextanswer = $answer;
        //答えを更新
        $DB->update_record("auth_spamblock",$obj);
    }
    //画像生成処理
    $answer = $DB->get_record_sql("SELECT nextanswer FROM {auth_spamblock} WHERE logintoken = \"$token\"");
    $img = \auth_spamblock\gen_captcha::gen_image($answer->nextanswer,$config);
    $script = \auth_spamblock\gen_captcha::return_javascript();
    //要素追加
    $mform->addElement("header","CAPTCHA",new lang_string("auth_spamblockcaptchaheader","auth_spamblock"));
    $mform->addElement("static","nolobot","",new lang_string("auth_spamblockcaptchadescription","auth_spamblock"));
    $mform->addElement("html","<script type=\"text/javascript\">".$script."</script>");
    $mform->addElement("html","<img src=\"data:image/png;base64,".$img["base"]."\" cmanOMat=\"move\"><br><br>");
    $mform->addElement("html","<img src=\"data:image/png;base64,".$img["cover"]."\" cmanOMat=\"move\"><br><br>");
    $mform->addElement("text","useranswer",new lang_string("auth_spamblockcaptchafield","auth_spamblock"));
    $mform->addRule("useranswer",get_string("required"), "required");
    $mform->setType("useranswer", PARAM_TEXT);
    //性能試験のための表示
    if ($config->viewanswer == 1){
        $mform->addElement("static","answer",$answer->nextanswer);
    }
}

function auth_spamblock_validate_extend_signup_form($data){
    global $SESSION,$DB;
    $token = $SESSION->logintoken["core_auth_login"]["token"];
    $errors = array();
    //答えを取得
    $answer = $DB->get_record_sql("SELECT currentanswer,nextanswer FROM {auth_spamblock} WHERE logintoken = \"$token\"");
    //ユーザの回答と比較
    if (strcasecmp($data["useranswer"],$answer->currentanswer) != 0){//大文字小文字を区別しない
        //$errors["useranswer"] = new lang_string("auth_spamblockcaptchaanswererror","auth_spamblock")."you:".$data["useranswer"]." ans:".$answer->currentanswer;
        $errors["useranswer"] = new lang_string("auth_spamblockcaptchaanswererror","auth_spamblock");
        //答えを更新
        //nextanswerの値をcurrentanswerに格納
        //idを取得（update_recordに必要なため）
        $token = $SESSION->logintoken["core_auth_login"]["token"];
        $id = $DB->get_record_sql("SELECT id FROM {auth_spamblock} WHERE logintoken = \"$token\"");
        $obj = new stdClass();
        $obj->id = $id->id;
        $obj->currentanswer = $answer->nextanswer;
        $DB->update_record("auth_spamblock",$obj);
    }
    return $errors;
}
