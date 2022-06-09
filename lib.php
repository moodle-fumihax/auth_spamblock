<?php

defined('MOODLE_INTERNAL') || die();

function auth_spamblockbeta_extend_signup_form($mform){
    $mform->addElement('static', 'injectedstatic', 'injected');
}