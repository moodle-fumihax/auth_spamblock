<?php
defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/authlib.php');
require_once($CFG->libdir.'/pagelib.php');
require_once($CFG->dirroot."/config.php");

class auth_plugin_spam_block_beta extends auth_plugin_base{
    

    function user_login($username, $password) {
        global $CFG, $DB;
        if ($user = $DB->get_record('user', array('username'=>$username, 'mnethostid'=>$CFG->mnet_localhost_id))) {
            return validate_internal_user_password($user, $password);
        }
        return false;
    }

    function user_signup($user, $notify = true){
        global $CFG, $DB ,$PAGE ,$OUTPUT;
        /*
        foreach ($CFG as $key => $val){
            echo "CFG[$key] =>".$val."<br>";
        }
        */
        require_once("CAPTCHA_form.php");
        $capform = new captcha_form(null);

        if($ans = $capform->get_data()){
            foreach ($ans as $key => $val){
                echo "ans[$key] =>".$val."<br>";
            }
            die();
            //$this->signup($user, $notify = true);
        }

        //ページを整える
        $PAGE->navbar->add("TEST");
        $PAGE->set_pagelayout("login");
        $PAGE->set_title("CAPTCHA");
        $PAGE->set_heading("CAPTCHA_PAGE");
        echo $OUTPUT->header();
        echo $OUTPUT->box_start();
        //フォーム表示
        $capform->display();
        echo $OUTPUT->box_end();

    }

    function signup($user, $notify = true){
        global $CFG, $DB;
        //既存のE-MAIL登録処理を呼ぶ
        require_once($CFG->dirroot."/auth/email/auth.php");
        $email_auth = new auth_plugin_email();
        return $email_auth->user_signup_with_confirmation($user, $notify);
    }
   
    function can_signup() {
        return true;
    }


}
?>