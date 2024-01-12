<?php
function xmldb_auth_spamblock_upgrade($oldversion): bool {
    global $CFG, $DB;

    $dbman = $DB->get_manager(); // Loads ddl manager and xmldb classes.

    if ($oldversion < 2022061208) {

        // Define table auth_spamblock to be created.
        $table = new xmldb_table('auth_spamblock');

        // Adding fields to table auth_spamblock.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('logintoken', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
        $table->add_field('currentanswer', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
        $table->add_field('nextanswer', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);

        // Adding keys to table auth_spamblock.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Conditionally launch drop table for auth_spamblock.
        if ($dbman->table_exists($table)) {
            $dbman->drop_table($table);
        }
        // Conditionally launch create table for auth_spamblock.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Spamblock savepoint reached.
        upgrade_plugin_savepoint(true, 2022061208 , 'auth', 'spamblock');
    }


    return true;
}
