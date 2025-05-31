<?php
defined('_RETRO_RADIO') or die ('Restricted access');

// Determine authorization and ownership of the storage folder of the CSV file
$filePerms = substr(sprintf('%o',fileperms($_uploadFolder)), -3) ." ".
posix_getpwuid(fileowner($_uploadFolder))['name'] . ":" .
posix_getgrgid(filegroup($_uploadFolder))['name'] . " " . $_uploadFolder;

/*
Show menu
CSS Deklaratios -> _modal.scss
*/
?>
<div class='modal-dlg' id="exportModal">
    <div class="modal-content bg fg"><div class="closeD closeX">&times;</div>
        <h1><?php echo lang('export_list')?></h1>
        <hr>
        <div id="btnExport" class="dlg-img pointer"></div>
    </div>
</div>
<div class='modal-dlg' id="importModal">
    <div class="modal-content bg fg"><div class="closeD closeX">&times;</div>
        <h1><?php echo lang("import_list")?></h1>
        <hr>
        <br>
        <p class="center"><span class="warn"><?php echo lang("import_warn")?></span> 
        <form id="frmImport" method="post" enctype="multipart/form-data">
            <label id="drop" for="csvFn" class="dlg-img pointer"></label>
            <p><input class="hidden" type="file" name="csvFn" id="csvFn" accept=".csv">
            <p class="center"><input type="button" value="<?php echo lang("import_list")?>" id="btnImport" disabled name="btnImport">
        </form>
        <table class="tableImport">
            <tr><td class="name"><?php echo lang("web_server_account")?></td><td class="value">www-data</td></tr>
            <tr><td class="name"><?php echo lang("storage_folder")?></td><td class="value"><?php echo $filePerms;?></td></tr>
        </table>
        <p class="fs-80"><?php echo lang("storage_description")?></p>
    </div>
</div>
<div class='modal-dlg' id="helpModal">
    <div class="modal-content bg fg"><div class="closeD closeX">&times;</div>
<?php echo lang("help_page");?>
    </div>
</div>
<div class='modal-dlg' id="aboutModal">
    <div class="modal-content bg fg"><div class="closeD closeX">&times;</div>
<?php echo lang("about_page");?>
    </div>
</div>
<?php
  if ($key == 0) {
    $grayscale = "grayscale";
  } else {
    $grayscale = "";
  }
?>
<div id="menu-icon" class="shadow">
<?php
switch ($scheme) {
    case 0:
        echo "<img class='$grayscale' id='menuImg' src='assets/img/menu10.webp' alt='Menü'>\n";
        break;
    case 1:
        echo "<img class='$grayscale' id='menuImg' data-license='https://de.wikipedia.org/wiki/EM34#/media/Datei:EM34-Leuchtschirm.jpg' src='assets/img/menu11.webp' alt='Menü'>\n";
        break;
}
if (is_file("readme-".lang('lang').".html")) {
    $readme = "readme-".lang('lang').".html";
} else {
    $readme = "readme-en.html";
}

?>
</div>

<div id='menu-items' class="hidden fg bg">
    <a class='a block fg' id='btnMenuImport' href="javascript:"><?php echo lang("import_list")?></a>
    <a class='a block fg' id='btnMenuExport' href="javascript:"><?php echo lang("export_list")?></a>
    <hr>
    <a class='a block fg' id='btnMenuHelp' href="javascript:"><?php echo lang("help")?></a>
    <hr>
    <a class='a block fg' href='<?php echo $readme?>' target='_blank'><?php echo lang("install")?></a>
    <hr>
    <a class='a block fg' id='btnAbout' href="javascript:"><?php echo lang("about")?></a>
</div>
