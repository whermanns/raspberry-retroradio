<?php
$url = $_GET['url'] ?? '';
$raw = $_GET['raw'] ?? 0;
$params = $_GET['ffprobe-params'] ?? "-v error -hide_banner -show_streams -show_format -of default=noprint_wrappers=1";

function getCodecInfos($url, $raw, $params) {
    $cmd = "/usr/bin/ffprobe";

    if (is_file($cmd)) {

        // Leerzeichen umwandeln
        $re = '/\ /m';
        $subst = "\\ ";
        $url = preg_replace($re, $subst, $url);

        // Infos mit ffprobe auslesen
        // Das Paket ffmpeg muss installiert sein
        // Parameterliste: s. https://ffmpeg.org/ffprobe.html
        // https://ottverse.com/ffprobe-comprehensive-tutorial-with-examples/

    
        exec("$cmd $params $url", $output, $result);

        $res = [];
        if ($result == 0) {
            if ($raw != 0) {
                $res['raw'] = $output;
            } else {
                for ($i = 0; $i < count($output); $i++) {
                    $item = explode("=", $output[$i]);
                    if ($item[0] == "bit_rate") {
                        if (is_numeric($item[1])) {
                            $res['Bitrate'] = $item[1] / 1000 . " kBit/s";
                        }
                    }
                    if ($item[0] == "TAG:title") {
                        $res['title'] = $item[1];
                    }
                    if ($item[0] == "TAG:artist") {
                        $res['artist'] = $item[1];
                    }
                    if ($item[0] == "TAG:composer") {
                        $res['composer'] = $item[1];
                    }
                    if ($item[0] == "TAG:album") {
                        $res['album'] = $item[1];
                    }
                    if ($item[0] == "TAG:date") {
                        $res['date'] = $item[1];
                    }
                    if ($item[0] == "TAG:genre") {
                        $res['genre'] = $item[1];
                    }
                    if ($item[0] == "TAG:icy-name") {
                        $res['Name'] = $item[1];
                    }
                    if ($item[0] == "TAG:icy-samplerate" || $item[0] == "sample_rate") {
                        $res['sample_rate'] = $item[1] . " Hz";
                    }
                    if ($item[0] == "TAG:StreamTitle") {
                        $res['Info'] = $item[1];
                    }
                    if ($item[0] == "description") {
                        $res['Beschreibung'] = $item[1];
                    }
                    if ($item[0] == "format_long_name") {
                        $res['Format'] = $item[1];
                    }
                    if ($item[0] == "TAG:icy-genre") {
                        $res['Genre'] = $item[1];
                    }
                    if ($item[0] == "channels") {
                        $res['channels'] = $item[1];
                    }
                    if ($item[0] == "duration") {
                        if (is_numeric($item[1])) {
                            $m = intdiv(intval($item[1]), 60);
                            $s = intval($item[1]) % 60;
                            if ($s < 10) {
                                $s = "0$s";
                            }
                            $res['duration'] = "$m:$s";
                        }
                    }
                    $res['URL'] = $url;
                }
            }

            $res['result'] = $result;
            return $res;

        } else {
            $res['result'] = 1;
            return $res;
        }
    }
}

if ($url != '') {
    echo json_encode(getCodecInfos($url, $raw, $params));
}
