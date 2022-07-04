<?php

defined("MOODLE_INTERNAL") || die();

function auth_spamblockbeta_extend_signup_form($mform){
    global $SESSION,$answer;
    $config = get_config("auth_spamblockbeta");
    
    if ($config->captcha==0){
        if($answer==null){
            //答えを生成
            $alphabets = range("A","Z");
            for ($i=0;$i<5;$i++){
                $answer .= $alphabets[rand(0,count($alphabets)-1)];
            }
        }
        //答えを設定
        //$SESSION->answer = $answer;
        //要素追加
        print_r($SESSION->logintoken);
        echo "<br>";
        echo $SESSION->logintoken["core_auth_login"]["token"];
        $mform->addElement("header","CAPTCHA",new lang_string("auth_spamblockbetacaptchaheader","auth_spamblockbeta"));
        $mform->addElement("static","nolobot",new lang_string("auth_spamblockbetacaptchadescriptionbefore","auth_spamblockbeta").$answer.new lang_string("auth_spamblockbetacaptchadescriptionafter","auth_spamblockbeta"));
        $mform->addElement("text","useranswer",new lang_string("auth_spamblockbetacaptchafield","auth_spamblockbeta"));
        $mform->addRule("useranswer",get_string("required"), "required");
        $mform->setType("useranswer", PARAM_TEXT);
    } 
}

function auth_spamblockbeta_validate_extend_signup_form($data){
    global $SESSION,$answer;
    $config = get_config("auth_spamblockbeta");
    if ($config->captcha==0){
        $errors = array();
        if (strcmp($data["useranswer"],$answer) != 0){
            $errors["useranswer"] = new lang_string("auth_spamblockbetacaptchaanswererror","auth_spamblockbeta")."you:".$data["useranswer"]." ans:".$answer;
        }
        //答えを生成
        $answer = null;
        $alphabets = range("A","Z");
        for ($i=0;$i<5;$i++){
            $answer .= $alphabets[rand(0,count($alphabets)-1)];
        }
        return $errors;
    }
}