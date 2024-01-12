<?php

defined("MOODLE_INTERNAL") || die;

$settings->add(new admin_setting_heading("auth_spamblock/pluginname", "",
    new lang_string("auth_spamblockdescription", "auth_spamblock")));

$answer_length_options = range(1,10);

$settings->add(new admin_setting_configselect("auth_spamblock/answerlength",
    new lang_string("auth_spamblockanswerlength","auth_spamblock"),
    new lang_string("auth_spamblockanswerlengthdescription","auth_spamblock"),
    4,$answer_length_options
));

//性能試験用モードの追加
$options = array(
    new lang_string("no"),
    new lang_string("yes"),
);

$settings->add(new admin_setting_heading("auth_spamblock/performancetestheader", 
    new lang_string("auth_spamblockperformancetest","auth_spamblock"),
    new lang_string("auth_spamblockperformancetestdescription","auth_spamblock")));

$settings->add(new admin_setting_configselect("auth_spamblock/directaccess",
    new lang_string("auth_spamblockdirectaccess","auth_spamblock"),
    new lang_string("auth_spamblockdirectaccessdescription","auth_spamblock"),0,$options
));

$settings->add(new admin_setting_configselect("auth_spamblock/viewanswer",
    new lang_string("auth_spamblockviewanswer","auth_spamblock"),
    new lang_string("auth_spamblockviewanswerdescription","auth_spamblock"),0,$options
));

$settings->add(new admin_setting_configselect("auth_spamblock/nobreak",
    new lang_string("auth_spamblocknobreak","auth_spamblock"),
    new lang_string("auth_spamblocknobreakdescription","auth_spamblock"),0,$options
));

$settings->add(new admin_setting_configselect("auth_spamblock/nonoise",
    new lang_string("auth_spamblocknonoise","auth_spamblock"),
    new lang_string("auth_spamblocknonoisedescription","auth_spamblock"),0,$options
));

$settings->add(new admin_setting_configselect("auth_spamblock/norandomspace",
    new lang_string("auth_spamblocknorandomspace","auth_spamblock"),
    new lang_string("auth_spamblocknorandomspacedescription","auth_spamblock"),0,$options
));
