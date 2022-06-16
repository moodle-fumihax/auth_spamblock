<?php

defined("MOODLE_INTERNAL") || die;

$settings->add(new admin_setting_heading("auth_spamblockbeta/pluginname", "",
    new lang_string("auth_spamblockbetadescription", "auth_spamblockbeta")));

$options = array(
    new lang_string("no"),
    new lang_string("yes"),
);

$settings->add(new admin_setting_configselect("auth_spamblockbeta/captcha",
    new lang_string("auth_spamblockbetacaptcha","auth_spamblockbeta"),
    "有効無効",0,$options
));

