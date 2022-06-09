<?php
require_once($CFG->libdir."/formslib.php");
require_once($CFG->dirroot."/config.php");

class captcha_form extends moodleform {
    public function definition() {
        global $CFG;

        $capform = $this->_form;

        $capform->addElement("header","CAPTCHA","CAPTCHA認証");
        $capform->addElement("static","nolobot","ロボットでないならBを選択してください。");
        $answers = ["a"=>"A","b"=>"B","c"=>"C","d"=>"D"];
        $capform->addElement("select","type","answer",$answers);

        $this->add_action_buttons(false,"認証");
    }

    function validation($data, $files) {
        return array();
    }
}