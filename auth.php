<?php
defined("MOODLE_INTERNAL") || die();

require_once($CFG->libdir."/authlib.php");
require_once($CFG->dirroot."/config.php");

class auth_plugin_spamblockbeta extends auth_plugin_base{

    public function __construct() {
        $this->authtype = "spamblockbeta";
    }

    function user_login($username, $password) {
        global $CFG, $DB;
        if ($user = $DB->get_record("user", array("username"=>$username, "mnethostid"=>$CFG->mnet_localhost_id))) {
            return validate_internal_user_password($user, $password);
        }
        return false;
    }

    function user_signup($user, $notify = true){
        global $CFG, $DB;
        /*
        foreach ($CFG as $key => $val){
            echo "CFG[$key] =>".$val."<br>";
        }
        */
        /*
        foreach ($user as $key => $val){
            echo "user[$key] =>".$val."<br>";
        }
        */
        //$this->signup($user, $notify = true);
        echo "auth";
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
