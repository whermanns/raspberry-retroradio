<?php
defined('_RETRO_RADIO') or die ('Restricted access');

class playStream {

    private $su, $recordDir;

    private $audioTypes = [".mp3", ".wav", ".aac", "flac", ".ogg", ".wma", ".m4a", "opus", ".mid", "midi", "ape"];


    public $loginOk = false;


    public function __construct($user, $password, $recordDir = "/tmp") {
        $this->su = "$password | su $user";
        $this->checkLogin($user);
        if (substr($recordDir, -1, 1) != "/") {
            $recordDir = "$recordDir/";
        }
        $this->recordDir = $recordDir;
    }

    private function killProcess($p) {
        if ($this->loginOk) {
            $pid = exec("pgrep $p");
            while ($pid != "") {
                exec("echo {$this->su} -c 'pkill $p'");
                $pid = exec("pgrep $p");
            }
        }
    }

    
    public function killVlc () {
        $this->killProcess("vlc");
    }

    public function killFFmpeg () {
        $this->killProcess("ffmpeg");
    }


    public function checkLogin($user) {
        $this->loginOk = shell_exec("echo {$this->su} -c 'ls -al /home/$user'") != NULL;
    }


    public function setVolume($vol) {
        exec("echo {$this->su} -c '/usr/bin/amixer set Master $vol%'");
    }



    public function playList($stream) {
        $playlist = "";
        if (substr($stream,-1,1) !="/") {
            $stream .= "/";
        }
        $plRetroradio = $stream ."retroradio.m3u";

        if (is_file($plRetroradio)) {
            $playlist = $plRetroradio;
        } else {
            $re = '/[{}|&#"%~:<>*\'?]/m';
            $files = scandir($stream);
            $audioFiles = [];
            $audioTypes = $this->audioTypes;
            for ($i = 0; $i < count($files); $i++) {
                if (substr($files[$i],0,1) != "." &&
                in_array(substr($files[$i],-4), $audioTypes)) {
                    preg_match_all($re, $files[$i], $matches, PREG_SET_ORDER);
                    if (count($matches) == 0) {
                        $audioFiles[] = $files[$i];
                    }
                }
                $playlist = implode("\n", $audioFiles) ."\n";
            }
            $playlistExists = false;
            if ($playlist != "") {
                try {
                    file_put_contents($plRetroradio, $playlist);
                    chmod ($plRetroradio, 0666);
                    $playlistExists = true;
                } catch (Exception $e) {
                    $playlistExists = false;
                    $alert_msg = lang("create_error");
                }
            } else {
                $alert_msg = lang("no_audio_files") . $stream;
            }
            if ($playlistExists) {
                $playlist = $plRetroradio;
            }
        }

        return $playlist;
    }

    private function localTime() {
        $timezone = trim(file_get_contents("/etc/timezone"));
        date_default_timezone_set('UTC');
        $new_date = new DateTime(date("Y-m-d h:i:s"));
        $new_date->setTimeZone(new DateTimeZone($timezone));
        return $new_date->format("ymd-his");
    }
    
    public function recordStream ($station , $stream = "") {
        if ($this->loginOk) {
            $this->killFfmpeg();
            if ($stream != "") {
                if (!is_dir($this->recordDir)) {
                    $cmnd = "echo {$this->su} -c 'mkdir -p {$this->recordDir}'";
                    exec($cmnd);

                }
                $cmnd = "echo {$this->su} -c 'chmod 0777 {$this->recordDir}'";
                
                $station = substr($station, 0, 5);
                $re = '/\s/m';
                $subst = "_";
                $station = preg_replace($re, $subst, $station);
                $fn = $this->recordDir . $station . "-" . $this->localTime() . ".mp3";
                $no_msg = "> /dev/null &";
                $cmnd = "echo {$this->su} -c 'ffmpeg -i $stream $fn $no_msg'";
                exec($cmnd);
                sleep(1);
                $cmnd = "echo {$this->su} -c 'chmod 0666 {$fn}'";
                exec($cmnd);
            }
        }
    }


    public function playStream ($stream, $vol = "1", $_audio_delay) {
        $this->killVlc();
        $cvlc = '/usr/bin/cvlc';

        // Local stream, escape spaces
        if (substr($stream,0,4) != "http") {

            if (is_dir($stream)) {
                $stream = $this->playList($stream);
            }
            if (!is_file($stream)) {
                return false;
            }
            $re = '/\ /m';
            $subst = "\\ ";
            $stream = preg_replace($re, $subst, $stream);

            // Do not play if file name contains special characters
            $re = '/[{}|&#"%~:<>*\'?]/m';
            preg_match_all($re, $stream, $matches, PREG_SET_ORDER);
            if (count($matches) > 0) {
                return false;
            }
        }

        if ($stream != "" && is_file($cvlc)) {

            // https://wiki.videolan.org/VLC_command-line_help/
            //  Volume (0 .. 8)
            //  Default:  "--gain 1";
            //
            // Disable video output
            // --no-video

            $params = "--gain " . $vol / 100 . " --no-video";

            // Delay audio when playing a TV stream
            if ($_audio_delay > 0 && substr($stream, -4) == "m3u8") {
                $params .= " --audio-desync $_audio_delay";
            }

            $no_msg = "> /dev/null &";

            // Play audio stream
/*
Some URLs (e.g. http://sc8.radiocaroline.net/;) end with a semicolon. This means that VLC no longer
is running as a background process and the web server displays the error 504 Gateway Time-out
error. Workaround: The semicolon is replaced by a colon.
*/
            if (substr($stream, -1, 1) == ";") {
                $stream = strtr($stream, ";" , ":");
            }

            // ffplay can't play playlists, but vlc can.
            //$cmnd = "echo {$this->su} -c 'ffplay -nodisp -volume $vol $stream $no_msg'";
            $cmnd = "echo {$this->su} -c '$cvlc $params $stream $no_msg'";

            if ($this->loginOk) {
                exec($cmnd, $output, $result);
            }
       } else {
            return false;
       }
       return true;
    }

}
