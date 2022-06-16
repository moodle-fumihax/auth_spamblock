<?php

defined("MOODLE_INTERNAL") || die();

function auth_spamblockbeta_extend_signup_form($mform){
    $config = get_config("auth_spamblockbeta");
    if ($config->captcha==1){
        $mform->addElement("header","CAPTCHA",new lang_string("auth_spamblockbetacaptchaheader","auth_spamblockbeta"));
        $mform->addElement("static","nolobot",new lang_string("auth_spamblockbetacaptchadescription","auth_spamblockbeta"));
        $answers = ["a"=>"A","b"=>"B","c"=>"C","d"=>"D"];
        $mform->addElement("select","capanswer",new lang_string("auth_spamblockbetacaptchafield","auth_spamblockbeta"),$answers);
        $mform->addRule("capanswer",get_string("required"), "required");
    } 
}

function auth_spamblockbeta_validate_extend_signup_form($data){
    $config = get_config("auth_spamblockbeta");
    if ($config->captcha==1){
        $errors = array();
        if ($data["capanswer"] != "b"){
            $errors["capanswer"] = new lang_string("auth_spamblockbetacaptchaanswererror","auth_spamblockbeta");
        }
        return $errors;
    }
}