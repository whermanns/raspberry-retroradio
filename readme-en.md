# Retro Radio


This project realizes a web radio based on a Raspberry Pi 3 or 4, which is operated in headless mode, i.e. without keyboard and screen. It is only connected to the home LAN via WiFi. All functions of the web radio can be controlled with a smartphone or notebook via a web browser.


## Features

* License: [cc by-sa](https://creativecommons.org/licenses/by-sa/4.0/deed.en)
* Supported Hardware
  * Raspberry Pi
  * Computers based on Debian, Ubuntu
  * and similar operating systems
* Easy installation
* Web-based operation
  * Control via PC or smartphone
  * Automatic light-dark mode
* Virtually unlimited number of stations
* Stations are provided via a simple structured CSV file
* Import and export CSV file
* Example file with approximately 70 radio stations
* Customizable station list
* Intuitive station selection
  * Select a group and click on a station or
  * Enter a letter in the search bar and select a suggestion
* Display information provided by the station
* Play local or LAN-stored streams and playlists
* Automatically create a playlist
* Logarithmic volume control
* Two display themes based on historical radios
  * Phillips Sirius BD431A
    * Slideshow of the disassembled, unrestored radio
  * Saba Donau F
    * Animation of the station display on the scale
* Original button sounds when switching (can be disabled)
* German or English user interface
* Additional languages can be easily added
  * E.g., copy `assets/lang/en.php` to `assets/lang/fr.php` and adapt it
  * Define the language in `config.php`

---

## Installation Guide

* Base system: Raspberry PI OS (64-bit), including Desktop Environment or a computer with Debian, Ubuntu, etc.
* Enable SSH
* Configure WLAN access
* Update the installation
* Assign a static IP address and a hostname, e.g., `retroradio.wlan`, in the router or Pi-hole
  
```shell
sudo apt update
sudo apt upgrade
sudo reboot
```

Retro Radio uses the packages `VLC` and `ffmpeg`.
These are already included in the base installation.

Install VLC and ffmpeg if necessary:
```shell
sudo apt install vlc ffmpeg
```

* Username: `retroradio`
* Password: `raspberry`

The username and password can be adjusted in the `config.php` file (see below).
The account must be included in the `audio` group.

---

### Configure Sound Card if Necessary, e.g., Raspberry Pi DAC Pro

More information:
[raspberrypi.com/products](https://raspberrypi.com/products)

or: [raspberrypi.com/documentation/accessories/audio.html](https://www.raspberrypi.com/documentation/accessories/audio.html)

Open configuration in the editor:

```shell
sudo nano /boot/firmware/config.txt
```

Comment out the parameter `dtparam=audio=on`

```conf
#dtparam=audio=on
```

Change it to

```conf
dtparam=audio=on
```

Save the file and reboot the Raspberry Pi.

---

### Install Required Packages

Mandatory: `nginx`, `php-fpm`, `php-json`

```shell
sudo apt install nginx php-fpm php-json
```

#### Install Optional Packages

If Samba is required:

```shell
sudo apt install samba smbclient wsdd2
```

---

### Configure Nginx

Configure Nginx to support PHP:

Edit the file `/etc/nginx/sites-available/default`:

Change the following lines

```conf
# Add index.php to the list if you are using PHP
index index.html index.htm index.nginx-debian.html;
```

to

```conf
# Add index.php to the list if you are using PHP
index index.html index.htm index.php;
```

In the section:

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

Include PHP-fpm version 8.2:

```conf
# pass PHP scripts to FastCGI server
#
location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/run/php/php8.2-fpm.sock;
}
```

#### Cleanup

```shell
sudo rm /var/www/html/index.nginx-debian.html
```

#### Restart Nginx

```shell
sudo service nginx restart
```

---

### Configure Samba if Necessary

#### Create Folder for Network Share

```shell
sudo mkdir /share
sudo mkdir /share/RecycleBin
```

Create a file named `desktop.ini` in the folder `/share/RecycleBin`:

```shell
sudo nano /share/RecycleBin/desktop.ini
```

Content of `desktop.ini`:
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

Set permissions
```shell
sudo chmod 777 -R /share
```

#### Add Share Folder to Samba Configuration File

```shell
sudo nano /etc/samba/smb.conf
```

Append the following lines to the end of the file

```conf
[share]
   comment = Share
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
   recycle:repository = RecycleBin
```

#### Create Samba User

```shell
# Create user retroradio and set password
sudo smbpasswd -a retroradio
```

If anonymous access is required (not usable from Windows PC):

```shell
# Enable anonymous access
sudo smbpasswd -an nobody
```

#### Restart Samba Service

```shell
sudo service smbd restart
```

---

### Install Retro Radio

#### Extract Package into `/var/www/html`

```shell
sudo tar vxf retroradio-yyyy-mm-dd.tar.gz -C /var/www/html
```

---

#### Configure Retro Radio

The `config.php` file is located in `/var/www/html`.

Possible adjustments:

* Adjust username/password
* Change language setting
* Enable/disable error messages
* Enable/disable button sounds
* Set location of station list file: `streams.csv`

##### Adjust Username / Password

```conf
// User account data
// This account must be included
// in the 'audio' group
$_user = "retroradio";
$_password = "raspberry";
```

##### Set Language

```conf
// Language: auto, de, en, fr
$_lang = "auto";
```

##### Enable/Disable Error Messages

```conf
// Display errors: true / false
$_DISPLAY_ERRORS = true;
```

##### Enable/Disable Button Sounds

```conf
// Original button sound of the 
// Philips Sirius BD431A radio
// or Saba Donau f
// play when changing stations true/false
$_play_key_click = true;
```

##### Set Location of Station List File `streams.csv`

```conf
// Location of the streams.csv file
$_streams_csv = "streams.csv";
// $_streams_csv = "/share/streams.csv";
// $_streams_csv = "/tmp/streams.csv";
```

**Important:** The web server account `www-data` must have read/write permissions for this folder.

##### Set up access to shared folders

Example: The file was stored in the `/share` folder.

```shell
sudo chown www-data -R /share
```

oder

```shell
sudo chmod 777 -R /share
```
---

### Operation

* Connect active speaker boxes or amplifier to the audio output
* Open the web page `retroradio.wlan` in a browser

The rest is self-explanatory. Just try it out. 😀

---
Author: _Walter Hermanns, 2025_

