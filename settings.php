<?php

defined("MOODLE_INTERNAL") || die;

$settings->add(new admin_setting_heading("auth_spamblockbeta/pluginname", "",
    new lang_string("auth_spamblockbetadescription", "auth_spamblockbeta")));

$options = array(
    new lang_string("yes"),
    new lang_string("no"),
);

$settings->add(new admin_setting_configselect("auth_spamblockbeta/captcha",
    new lang_string("auth_spamblockbetacaptcha","auth_spamblockbeta"),
    new lang_string("auth_spamblockbetacaptchaswitchdescription","auth_spamblockbeta"),
    0,$options,
));

