# Retroradio

Dieses Projekt realisiert ein Webradio auf Basis eines Raspberry Pi 3 oder 4. Dieser wird im headless-Modus, d.h. ohne Tastatur und Bildschirm betrieben. Er ist lediglich per WiFi mit dem heimischen LAN verbunden. Alle Funktionen des Webradios lassen sich mit Smartphone oder Notebook per Webbrowser steuern.


## Merkmale


* Lizenz: [cc by-sa](https://creativecommons.org/licenses/by-sa/4.0/deed.de)
* Unterstützte Hardware
  * Raspberry Pi
  * Rechner auf Basis von Debian, Ubuntu 
  * und ähnlichen Betriebssystemen
* Einfache Installation
* Webbasierte Bedienung
  * Steuerung über PC oder Smartphone
  * Automatischer Hell-Dunkel-Modus
* Senderanzahl praktisch nicht begrenzt
* Sender werden durch eine einfach strukturierte CSV-Datei bereitgestellt
* CSV-Datei importieren und exportieren
* Beispieldatei mit ca. 70 Radiostationen
* Senderliste nach eigenen Wünschen anpassbar
* Intuitive Senderwahl
  * Gruppe auswählen und Sender anklicken oder
  * einen Buchstaben in die Suchleiste eingeben und  Vorschlag auswählen
* Vom Sender bereitgestellte Informationen anzeigen
* Lokale bzw. im LAN gespeicherte Streams und Playlists abspielen
* Playlist automatisch erstellen
* Logarithmischer Lautstärkesteller
* Zwei Anzeigeschemas nach historischen Radios
  * Phillips Sirius BD431A
    * Diaschau des zerlegten, unrestaurierten Radios
  * Saba Donau F
    * Animation der Senderanzeige auf der Skala
* Original-Tastentöne beim Umschalten (abschaltbar) 
* Deutsch- oder englischsprachige Oberfläche
* Weitere Sprachen können leicht hinzugefügt werden
  * Z.B. die Datei `assets/lang/en.php` nach `assets/lang/fr.php` kopieren und diese anpassen
  * Sprache in der Datei `config.php` eintragen
* **NEU in Version 1.2**: Radiosstream aufnehmen
 
---


## Installationsbeschreibung

* Basis: Raspberry PI OS (64-bit), inkl. Desktop Environment oder ein Rechner mit Debian, Ubuntu, o. ä.
* SSH aktivieren
* WLAN-Zugriff einstellen
* Installation aktualisieren
* Im Router, bzw. Pihole eine feste IP-Adresse und einen Namen, bspw. `retroradio.wlan` zuordnen
  
```shell
sudo apt update
sudo apt upgrade
sudo reboot
```

Retroradio nutzt die Pakete `VLC` und `ffmpeg`.
Diese sind bereits in der Basisinstallation enthalten.

VLC und ffmpeg ggf. installieren:
```shell
sudo apt install vlc ffmpeg
```

* Benutzername: `retroradio`
* Passwort: `raspberry`

Benutzername und Passwort sind in der Datei `config.php` (s. unten)
ggf. anzupassen. Das Konto muss in den Gruppe `audio` enthalten sein.

---

### Ggf. Soundkarte konfigurieren, hier: Raspberry Pi DAC Pro

Infos s.:
[raspberrypi.com/products](https://raspberrypi.com/products)

bzw.: [raspberrypi.com/documentation/accessories/audio.html](https://www.raspberrypi.com/documentation/accessories/audio.html)

Konfiguration im Editor öffen:

```shell
sudo nano /boot/firmware/config.txt
```

Dort Paramter `dtparam=audio=on` auskommentieren

```conf
#dtparam=audio=on
```

ändern in

```conf
dtparam=audio=on
```

Datei speichern und Raspberry Pi rebooten.

---

### Notwendige Pakete installieren

Unbedingt erforderlich: `nginx`, `php-fpm`, `php-json`

```shell
sudo apt install nginx php-fpm php-json
```

#### Optionale Pakete installieren

Falls Samba gewünscht:

```shell
sudo apt install samba smbclient wsdd2
```

---

### Nginx einrichten

Nginx so konfigurieren, dass PHP funktioniert:

Datei `/etc/nginx/sites-available/default` editieren:

Die Zeilen

```conf
# Add index.php to the list if you are using PHP
index index.html index.htm index.nginx-debian.html;
```

in

```conf
# Add index.php to the list if you are using PHP
index index.html index.htm index.php;
```

ändern und im Abschnitt

```conf
# pass PHP scripts to FastCGI server
#
#location ~ \.php$ {
#   include snippets/fastcgi-php.conf;
#
#   # With php-fpm (or other unix sockets):
#   fastcgi_pass unix:/run/php/php7.4-fpm.sock;
#   # With php-cgi (or other tcp sockets):
#   fastcgi_pass 127.0.0.1:9000;
#}
```

PHP-fpm in der Version 8.2 einbinden.

```conf
# pass PHP scripts to FastCGI server
#
location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/run/php/php8.2-fpm.sock;
}
```

#### Aufräumen

```shell
sudo rm /var/www/html/index.nginx-debian.html
```

#### Nginx neu starten

```shell
sudo service nginx restart
```

---

### Ggf. Samba konfigurieren

#### Ordner für die Netzwerkfreigabe anlegen

```shell
sudo mkdir /freigabe
sudo mkdir /freigabe/Papierkorb
```
Im Ordner `/freigabe/Papierkorb` eine Datei namens `desktop.ini` erstellen:

```shell
sudo nano /freigabe/Papierkorb/desktop.ini
```
Inhalt der Datei `desktop.ini`:
```conf
[.ShellClassInfo]
IconFile=%SystemRoot%\system32\SHELL32.dll
IconIndex=32
IconResource=C:\WINDOWS\System32\SHELL32.dll,32
[ViewState]
Mode=
Vid=
FolderType=Generic
```
Berechtigung einstellen
```shell
sudo chmod 777 -R /freigabe
```

#### Freigabeordner in die Samba-Konfigurationsdatei eintragen

```shell
sudo nano /etc/samba/smb.conf
```

Folgende Zeilen ans Ende der Datei anhängen

```conf
[freigabe]
   comment = Freigabe
   create mask = 0777
   directory mask = 0777
   force create mode = 0766
   force directory mode = 0777
   guest ok = yes
   browseable = yes
   read only = no
   vfs objects = recycle
   recycle:exclude = *.tmp, *.bak
   recycle:keeptree = yes
   recycle:repository = Papierkorb
```

#### Sambabenutzer anlegen

```shell
# Konto retroradio anlegen und Passwort einrichten
sudo smbpasswd -a retroradio
```

Falls gewünscht, anonymen Zugang ohne Anmeldung einrichten. Dieser kann allerdings nicht von einem Windows-PC genutzt werden.

```shell
# Anonymen Zugriff einrichten
sudo smbpasswd -an nobody
```

#### Sambadienst neu starten

```shell
sudo service smbd restart
```

---

### Retroradio installieren

#### Paket in den Ordner /var/www/html entpacken



---

#### Retroradio konfigurieren

Die Datei `config.php`  befindet sich im Ordner `/var/www/html`.

Mögliche Anpassungen:

* Benutzernamen / Passwort anpassen
* Spracheinstellung ändern
* Fehleranzeige (de-)aktivieren
* Tastentöne ab-/einschalten
* Speicherort der Senderliste festlegen, Datei: `streams.csv`

##### Benutzernamen / Passwort anpassen

```conf
// User account data
// This account must be included
// in the 'audio' group
$_user = "retroradio";
$_password = "raspberry";
```

##### Sprache einstellen

```conf
// Language: auto, de, en, fr
$_lang = "auto";
```
##### Fehleranzeige de-/aktivieren

```conf
// Display errors: true / false
$_DISPLAY_ERRORS = true;
```

##### Tastentöne ab-/einschalten

```conf

// Original button sound of the
// Philips Sirius BD431A radio
// or Saba Donau f
// play when changing stations true/false
$_play_key_click = true;
```

##### Speicherort der Senderliste festlegen, Datei: `streams.csv`

```conf
// Location of the streams.csv file
$_streams_csv = "streams.csv";
// $_streams_csv = "/freigabe/streams.csv";
// $_streams_csv = "/tmp/streams.csv";
```

**Wichtig:** Das Konto des Webservers `www-data` muss
Lese- und Schreibrechte in diesem Ordner haben.

##### Zugriff auf Freigabeordner einrichten

Beispiel: Die Datei wurde im Ordner `/freigabe` abgelegt.

```shell
sudo chown www-data -R /freigabe
```

oder

```shell
sudo chmod 777 -R /freigabe
```

---

### Bedienung

* Aktive Lautsprecherboxen oder Verstärker an den Audioausgang anschließen
* Im Webbrowser die Seite `retroradio.wlan` aufrufen

Der Rest ist selbsterklärend. Einfach ausprobieren. 😀

---
Autor: _Walter Hermanns, 2025_
