<?php

uses('model' . DS . 'connection_manager');

class InstallerController extends AppController {
    var $uses = array();

    function beforeFilter() {
        if (file_exists(TMP.'installed.txt')) {
            echo 'Application already installed. Remove app/config/installed.txt to reinstall the application';
            exit();
        }
    }

    function index() {
    }

    function database() {
        $db = ConnectionManager::getDataSource('default');

        if(!$db->isConnected()) {
            echo 'Could not connect to database. Please check the settings in app/config/database.php and try again';
            exit();
        }

        $this->__executeSQLScript($db, CONFIGS.'sql'.DS.'app.sql');

        $this->redirect('/installer/thanks');
    }

    function thanks() {
        file_put_contents(CONFIGS.'installed.txt', date('Y-m-d, H:i:s'));
    }

    function __executeSQLScript($db, $fileName) {
        $statements = file_get_contents($fileName);
        $statements = explode(';', $statements);

        foreach ($statements as $statement) {
            if (trim($statement) != '') {
                $db->query($statement);
            }
        }
    }
}
