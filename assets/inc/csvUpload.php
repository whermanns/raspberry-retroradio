<?php
defined('_RETRO_RADIO') or die ('Restricted access');

if (!empty($_FILES)) {

    
    if (is_writable($_uploadFolder)) {
        if ($_FILES['csvFn']['type'] == "text/csv") {
            if (!move_uploaded_file($_FILES['csvFn']['tmp_name'], $_uploadFn)) {
                $alert_msg = lang("import_failed");
            }
        } else {
            $alert_msg = lang("no_csv_file");
        }
        unset($_FILES);

        // Refresh page after import
        $sD->set("key", 0);
        $sD->set("group", 1);
        $sD->writeJson();
        header("Location: $_srv/index.php");
    } else {
        $alert_msg = lang("write_error") . $_uploadFolder;
    }
}
