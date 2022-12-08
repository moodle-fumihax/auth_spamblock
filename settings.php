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

//性能試験用モードの追加
$options = array(
    new lang_string("no"),
    new lang_string("yes"),
);

$settings->add(new admin_setting_heading("auth_spamblockbeta/performancetestheader", 
    new lang_string("auth_spamblockbetaperformancetest","auth_spamblockbeta"),
    new lang_string("auth_spamblockbetaperformancetestdescription","auth_spamblockbeta")));

$settings->add(new admin_setting_configselect("auth_spamblockbeta/directaccess",
    new lang_string("auth_spamblockbetadirectaccess","auth_spamblockbeta"),
    new lang_string("auth_spamblockbetadirectaccessdescription","auth_spamblockbeta"),0,$options
));

$settings->add(new admin_setting_configselect("auth_spamblockbeta/viewanswer",
    new lang_string("auth_spamblockbetaviewanswer","auth_spamblockbeta"),
    new lang_string("auth_spamblockbetaviewanswerdescription","auth_spamblockbeta"),0,$options
));

$settings->add(new admin_setting_configselect("auth_spamblockbeta/nobreak",
    new lang_string("auth_spamblockbetanobreak","auth_spamblockbeta"),
    new lang_string("auth_spamblockbetanobreakdescription","auth_spamblockbeta"),0,$options
));

$settings->add(new admin_setting_configselect("auth_spamblockbeta/nonoise",
    new lang_string("auth_spamblockbetanonoise","auth_spamblockbeta"),
    new lang_string("auth_spamblockbetanonoisedescription","auth_spamblockbeta"),0,$options
));

$settings->add(new admin_setting_configselect("auth_spamblockbeta/norandomspace",
    new lang_string("auth_spamblockbetanorandomspace","auth_spamblockbeta"),
    new lang_string("auth_spamblockbetanorandomspacedescription","auth_spamblockbeta"),0,$options
));