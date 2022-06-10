<?php

defined("MOODLE_INTERNAL") || die();

function auth_spamblockbeta_extend_signup_form($mform){
    $mform->addElement("header","CAPTCHA","CAPTCHA認証");
    $mform->addElement("static","nolobot","ロボットでないならBを選択してください。");
    $answers = ["a"=>"A","b"=>"B","c"=>"C","d"=>"D"];
    $mform->addElement("select","capanswer","回答",$answers);
    $mform->addRule("capanswer",get_string("required"), "required");
}

function auth_spamblockbeta_validate_extend_signup_form($data){
    $errors = array();
    if ($data["capanswer"] != "b"){
        $errors["capanswer"] = "もう一度やり直してください";
    }
    return $errors;
}