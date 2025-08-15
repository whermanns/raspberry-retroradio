<?php
defined('_RETRO_RADIO') or die ('Restricted access');

/*
This class provides basic functions for CSV files.
* Set / read private variables
* Read channel list
* Output names of all channels
* Output lines of the CSV file grouped (default: 8 lines)
* Output URL count
* Output number of groups (default: number of channels / 8)

*/
class streamList
{
    // csv field separator
    private $separator = ",";

    // Number of stations per group
    private $lines = 8;

    // csv enclosing character
    private $enclosue = "\"";

    // Stations list 
    private $streamlist = [];


    // Read csv file, set field separator
    public function __construct($streams_csv, $separator = ",") {
        $this->separator = $separator;
        $streams = [];
        if (($h = fopen($streams_csv, "r")) !== FALSE) {
            while (($data = fgetcsv($h, 1000, $this->separator, $this->enclosue, "\\")) !== FALSE) {
                if (count($data) > 1) {
                    $key = trim($data[0]);
                    $val = trim($data[1]);
                    if ($key != "" && $val != "") {
                        array_push($streams, [$key , $val]);
                    }
                }
            }
            fclose($h);
        }

        $this->streamlist = $streams;
    }
    
    
    // Read stations list
    public function get_streamlist() {
        $res = "";
        for ($i = 0; $i < count($this->streamlist); $i++) {
            $res .= $this->streamlist[$i][0] . $this->separator . $this->streamlist[$i][1] . "\n";
        }
        return json_encode($res);
    }


    // Set variable
    public function set($var, $value) {
        if (in_array($var, ['separator','lines','enclosure'])) {
            $this->$var = $value;
        }
    }

    
    // Get variable
    public function get($var) {
        if (in_array($var,['separator','lines','enclosure'])) {
            return $this->$var;
        }
    }
    

    // Names of all radio stations
    public function get_station_names($streams_csv) {
        $res = [];
        for ($i = 0; $i < count($this->streamlist); $i++) {
            array_push($res, $this->streamlist[$i][0]);
        }
        return $res;
    }


    // $lines fields from the list of stream URLs
    public function get_grouped_streams($offset = 0) {
        $start = $offset * $this->lines;
        $end = $start + $this->lines;
        if ($end > count($this->streamlist)) {
            $end = count($this->streamlist);
        }
        $lines = [];
        for ($i = $start; $i < $end; $i++) {
            array_push($lines, $this->streamlist[$i]);
        }
        return json_encode($lines);
    }


    // Number of station groups = ( URLs / $lines )
    public function count_groups() {
        $cnt = count($this->streamlist);
        $groups = floor($cnt / $this->lines);
        if (($cnt % $this->lines) != 0) {
            $groups++;
        }
        return $groups;
    }
}
