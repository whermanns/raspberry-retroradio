<?php
defined('_RETRO_RADIO') or die ('Restricted access');

/*
  Saving and reading session data on a file basis
    
  File name: /tmp/retroradio.json

  The data is retained when the browser is closed

*/

class storeData {


    private $data = [];


    private $fn = "/tmp/retroradio.json";


    // Read or create data if not yet available
    public function __construct() {
        if (!is_file($this->fn)) {
            $this->data["scheme"] = 0;
            $this->data["volume"] = 30;
            $this->data["key"] = 0;
            $this->data["record"] = 0;
            $this->data["group"] = 1;
            file_put_contents($this->fn, json_encode($this->data));
        } else {
            $this->data = json_decode(file_get_contents($this->fn), true);
        }
    }


    // Set or update
    public function set($name, $value) {
        $this->data[$name] = $value;
    }


    // Read
    public function get($name) {
        if (isset($this->data[$name])) {
            $res = $this->data[$name];
        } else {
            $res = "";
        }
        return $res;
    }


    // Read data from $this->data
    public function getJson() {
        return json_encode($this->data);
    }

    // Read data from /tmp/retroradio.json
    public function readJson() {
        return file_get_contents($this->fn);
    }

    // Write data to /tmp/retroradio.json
    public function writeJson() {
        if ($this->getJson() != $this->readJson()) {
            file_put_contents($this->fn, $this->getJson());
        }
    }
}