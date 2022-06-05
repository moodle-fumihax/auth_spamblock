<?php
defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/authlib.php');
require_once($CFG->libdir.'/formslib.php');
require_once($CFG->dirroot.'/user/profile/lib.php');
require_once($CFG->dirroot . '/user/editlib.php');

class auth_plugin_spam_block_beta extends auth_plugin_base{
    

    function user_login($username, $password) {
        global $CFG, $DB;
        if ($user = $DB->get_record('user', array('username'=>$username, 'mnethostid'=>$CFG->mnet_localhost_id))) {
            return validate_internal_user_password($user, $password);
        }
        return false;
    }

    function user_signup($user, $notify = true){
        global $CFG, $DB;
        /*
        foreach ($user as $key => $val){
            echo "user[$key] =>".$val."<br>";
        }

        foreach ($CFG as $key => $val){
            echo "CFG[$key] =>".$val."<br>";
        }
        echo "スパムブロック通過";
        $this->signup($user, $notify = true);
      
        echo "<form action=<?php $this->signup($user,$notify) ?> method=\"post\">";
        echo "<button type=\"submit\">登録</button>";
        echo "</form>";
        */
        /*
        foreach ($CFG as $key => $val){
            echo "CFG[$key] =>".$val."<br>";
        }
        */

        $spamblockform = $this->_form;
        $spamblockform->addElement('header', 'anti_spam', get_string('antispam'), '');
        //$spamblockform->addElement('text', 'username',get_string('username'));

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