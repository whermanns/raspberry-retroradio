<?php
defined('_RETRO_RADIO') or die ('Restricted access');

// Display errors: true / false
$_DISPLAY_ERRORS = false;


// User account data
// This account must be included in the 'audio' group
$_user = "retroradio";
$_password = "raspberry";


// Location of the streams.csv file
$_streams_csv = "streams.csv";
// $_streams_csv = "/freigabe/streams.csv";
// $_streams_csv = "/tmp/streams.csv";


// Folder for recordings
$_recordDir = "/freigabe/record";


// csv separator
$_csv_separator = ",";


// Original button sound of the Philips Sirius BD431A radio
// or Saba Donau f
// play when changing stations true/false
$_play_key_click = true;


// Language: auto, de, en, fr
$_lang = "auto";

