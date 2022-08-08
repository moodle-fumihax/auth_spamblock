<?php

defined("MOODLE_INTERNAL") || die;

$settings->add(new admin_setting_heading("auth_spamblockbeta/pluginname", "",
    new lang_string("auth_spamblockbetadescription", "auth_spamblockbeta")));

$answer_length_options = range(1,10);

$settings->add(new admin_setting_configselect("auth_spamblockbeta/answerlength",
    new lang_string("auth_spamblockbetaanswerlength","auth_spamblockbeta"),
    new lang_string("auth_spamblockbetaanswerlengthdescription","auth_spamblockbeta"),
    4,$answer_length_options
));

