<!DOCTYPE html>
<!-- Weblication&reg; CMS Version 13 -->
<!-- Copyright 2019 by Scholl Communications AG -->
<html lang="de" class="productselection">
<head>
    <title>Weblication&reg; Version 13 Installationsmaske</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />

    <script type="text/javascript">

            var isAbleToInstall = false;
            var isAbleToInstallButWithRestrictions = false;
            var selectedProduct = '';

            function tryToInstall(){
                if(document.getElementById('buttonInstall').className.indexOf('wButtonDisabled') == -1){
                    document.frmSetup.submit();
                    document.body.className = document.body.className + " installProgress"
                }
            }

            function selectProduct(productKey, product){
                selectedProduct = product;
                document.frmSetup.product.value = product;
                document.documentElement.className = 'weblication-' + productKey;
                updateMask();
            }

            function backToProductSelection(){
                selectedProduct = '';
                document.frmSetup.product.value = '';
                document.documentElement.className = 'productselection';
                updateMask();
            }

            function updateMask(){

                document.body.className = "";
                document.getElementById("blockLicense").style.display = "block";
                document.getElementById("restrictionText").style.display = "none";
                document.getElementById("errorTextPre").style.display = "none";
                document.getElementById("errorTextPost").style.display = "none";

                if(isAbleToInstallButWithRestrictions && document.frmSetup.product.value == 'send'){
                    document.body.className = "isNotAbleToInstall";
                    document.getElementById("blockLicense").style.display = "none";
                    document.getElementById("restrictionText").style.display = "none";
                    document.getElementById("errorTextPre").style.display = "block";
                    document.getElementById("errorTextPost").style.display = "block";
                    document.getElementById("errorTextPre").appendChild(document.getElementById("noexec"));
                }
                else if(isAbleToInstallButWithRestrictions){
                    document.body.className = "isAbleToInstallButWithRestrictions";
                    document.getElementById("blockLicense").style.display = "block";
                    document.getElementById("restrictionText").style.display = "block";
                    document.getElementsByTagName("IFRAME")[0].style.height = "140px";
                    document.getElementById("restrictionText").appendChild(document.getElementById("noexec"));
                }
                else if(isAbleToInstall){
                    document.body.className = "isAbleToInstall";
                    document.getElementById("blockLicense").style.display = "block";
                }
                else{
                    document.body.className = "isNotAbleToInstall";
                    document.getElementById("blockLicense").style.display = "none";
                    document.getElementById("restrictionText").style.display = "none";
                    document.getElementById("errorTextPre").style.display = "block";
                    document.getElementById("errorTextPost").style.display = "block";
                }

                if(document.documentElement.className.indexOf('productselection') != -1){
                    return false;
                }
            }


            function doServerCheck(){

                var errors = [];

        <?php

        $systemCalls = true;
        $missingFunctions = [];
        $disabled_functions_string = ini_get('disable_functions');

        if($disabled_functions_string !== false && !empty($disabled_functions_string)){
          $disabledFunctions = explode(',',$disabled_functions_string);
          if(in_array('exec',$disabledFunctions)) {
            $systemCalls = false;
            $missingFunctions[] = 'exec';
          }
          if(in_array('passthru',$disabledFunctions)){
            $systemCalls = false;
            $missingFunctions[] = 'passthru';
          }
        }


        if($systemCalls === true){

          $errors = array();

          if(file_exists($_SERVER['DOCUMENT_ROOT'].'/send')){
            $errors['sendIsInstallted'] = 'SEND ist bereits installiert';
          }

          exec('gpg --version',$gpgExec);
          if(count($gpgExec) !== 0){} else {
            $errors['gpg'] = 'GPG ist nicht installiert';
          }

          if(count($errors) > 0){
            foreach($errors as $errorKey => $error){
              print 'errors["'.$errorKey.'"] = "'.$error.'";'."\n";
            }
          } else {
            print 'errors = false;';
          }
        }

        else {
          $missingFunctionsString = implode(',',$missingFunctions);
          print 'errors["exec"] = "Systembefehle ('.$missingFunctionsString.') werden nicht unterstützt";';
        }

        ?>


                if(errors !== false){
                    missingModulesText = '<div>';
                    for(key in errors){
                        missingModulesText += '<div class="module">'+errors[key]+'</div>';
                    }
                    missingModulesText += '</div>';

                    document.getElementById("blockRequirements").style.display = "block";
                    document.getElementById("blockLicense").style.display = "none";
                    document.getElementById("restrictionText").style.display = "none";
                    document.getElementById("errorTextPre").style.display = "block";
                    document.getElementById("errorTextPost").style.display = "block";

                    document.getElementById("errorTextPre").innerHTML = document.getElementById("errorTextPre").innerHTML+missingModulesText;

                } else {
                    selectProduct('s', 'send');
                }

                return false;
            }

    </script>
    <style>

        html {height:100%;overflow:hidden;}
        body {height:100%;font-family:Arial,Helvetica;font-size:11px;line-height:17px;background:-webkit-radial-gradient(center, ellipse cover, #dbdbdb 0%,#bebebe 100%);background:-moz-radial-gradient(center, ellipse cover, #dbdbdb 0%,#bebebe 100%);background:-ms-radial-gradient(center, ellipse cover, #dbdbdb 0%,#bebebe 100%);-webkit-user-select:none;}
        a {color:#000000}

        #setupStatus {width:480px;height:60px;position:absolute;top:50%;left:50%;margin-top:160px;margin-left:-240px;text-align:center;line-height:19px}
        #blockSetup  {width:480px;height:600px;position:absolute;overflow:hidden;top:50%;left:50%;margin-top:-300px;margin-left:-240px;box-shadow:0 0 32px 8px rgba(0, 0, 0, 0.08);outline:solid 1px #cbcbcb;background-color:#f0f0f0;transition:top 0.3s ease-in-out,margin 0.3s ease-in-out}
        .installProgress #blockSetup  {height:294px;transition:all 0.3s 0.2s ease-in-out}
        #blockSetup:after             {content:'';position:absolute;width:100%;height:0%;top:0;background-color:#f0f0f0;opacity:0;transition:opacity 0.2s linear}
        #blockSetup.inProgress:after  {height:100%;opacity:0.7}

        #blockProductselection       {position:absolute;top:0;left:0;width:480px;height:600px;background-color:#ffffff;transition:height 0.3s ease-in-out}
        #blockProductselection > div {height:0;opacity:0;overflow:hidden;transition:opacity 0.0s ease-in-out,height 0.3s ease-in-out}

        .productselection #blockProductselection > div {cursor:pointer;}
        .productselection #blockProductselection > div:hover {background-color:#f6f6f6}

        .weblication-g #blockProductselection                         {box-sizing:border-box;height:160px;border-bottom:solid 1px #e0e0e0}
        .weblication-g #blockProductselection > div.productToSelect-g {height:159px;opacity:1}
        .weblication-g #blockProductselection > div.productToSelect-g > div:first-child:before {background-position:0 55px;transition:all 0.3s ease-in-out}
        .weblication-g #blockProductselection > div.productToSelect-a .productDescription {display:none}
        .weblication-g #blockProductselection > div.productToSelect-s .productDescription {display:none}
        .weblication-g #blockProductselection .buttonSelectProduct    {display:none}

        .weblication-c #blockProductselection                         {box-sizing:border-box;height:160px;border-bottom:solid 1px #e0e0e0}
        .weblication-c #blockProductselection > div.productToSelect-c {height:159px;opacity:1}
        .weblication-c #blockProductselection > div.productToSelect-c > div:first-child:before {background-position:0 56px;transition:all 0.3s ease-in-out}
        .weblication-c #blockProductselection > div.productToSelect-a .productDescription {display:none}
        .weblication-c #blockProductselection > div.productToSelect-s .productDescription {display:none}
        .weblication-c #blockProductselection .buttonSelectProduct    {display:none}

        .weblication-a #blockProductselection                         {box-sizing:border-box;height:160px;border-bottom:solid 1px #e0e0e0}
        .weblication-a #blockProductselection > div.productToSelect-a {height:159px;opacity:1}
        .weblication-a #blockProductselection > div.productToSelect-a > div:first-child:before {background-position:22px 88px;transition:all 0.3s ease-in-out}
        .weblication-a #blockProductselection > div.productToSelect-a .productDescription {}
        .weblication-a #blockProductselection > div.productToSelect-s .productDescription {display:none}
        .weblication-a #blockProductselection .buttonSelectProduct    {display:none}

        .weblication-s #blockProductselection                         {box-sizing:border-box;height:160px;border-bottom:solid 1px #e0e0e0}
        .weblication-s #blockProductselection > div.productToSelect-s {height:159px;opacity:1}
        .weblication-s #blockProductselection > div.productToSelect-s > div:first-child:before {background-position:22px 82px;transition:all 0.3s ease-in-out}
        .weblication-s #blockProductselection > div.productToSelect-s .productDescription {}
        .weblication-s #blockProductselection > div.productToSelect-a .productDescription {display:none}
        .weblication-s #blockProductselection .buttonSelectProduct    {display:none}

        .weblication-o #blockProductselection                         {box-sizing:border-box;height:160px;border-bottom:solid 1px #e0e0e0}
        .weblication-o #blockProductselection > div.productToSelect-o {height:159px;opacity:1}
        .weblication-o #blockProductselection > div.productToSelect-o > div:first-child:before {background-position:0 56px;transition:all 0.3s ease-in-out}
        .weblication-o #blockProductselection > div.productToSelect-a .productDescription {display:none}
        .weblication-o #blockProductselection > div.productToSelect-s .productDescription {display:none}
        .weblication-o #blockProductselection .buttonSelectProduct    {display:none}

        .productselection #blockProductselection {display:block}
        .productselection #blockProductselection > div {box-sizing:border-box;height:120px;opacity:1;position:relative;border-top:solid 1px #c0c0c0}
        .productselection #blockProductselection > div:first-child {border-top:none}

        #blockProductselection > div > div:first-child        {width:50%;height:100%;overflow:hidden}
        #blockProductselection > div > div:first-child:before {content:'';display:block;z-index:1;width:100%;height:100%;background-image:url('https://download.weblication.de/wDownloadServer/setup-styles/logo-g.svg');background-repeat:no-repeat;background-size:200px;background-position:0px 15px;border-bottom:solid 1px #e0e0e0}
        #blockProductselection > div.productToSelect-c > div:first-child:before {background-image:url('https://download.weblication.de/wDownloadServer/setup-styles/logo-c.svg');background-size:200px;background-position:0px bottom;border-bottom:solid 1px #e0e0e0}
        #blockProductselection > div.productToSelect-o > div:first-child:before {background-image:url('https://download.weblication.de/wDownloadServer/setup-styles/logo-o.svg');background-size:160px;background-position:0px bottom;border-bottom:solid 1px #e0e0e0}
        #blockProductselection > div.productToSelect-a > div:first-child:before {background-image:url('https://download.weblication.de/wDownloadServer/setup-styles/logo-a.svg');background-size:220px;background-position:22px 48px;border-bottom:solid 1px #e0e0e0}
        #blockProductselection > div.productToSelect-a .productDescription {position:absolute;margin:-34px 0 0 22px;color:#c0c0c0}

        #blockProductselection > div.productToSelect-s > div:first-child:before {background-image:url('https://download.weblication.de/wDownloadServer/setup-styles/logo-s.svg');background-size:160px;background-position:23px 42px;border-bottom:solid 1px #e0e0e0}
        #blockProductselection > div.productToSelect-s .productDescription {position:absolute;margin:-34px 0 0 22px;color:#c0c0c0}

        .buttonSelectProduct   {cursor:pointer;position:absolute;right:22px;bottom:22px;text-decoration:none;display:inline-block;font-size:13px;line-height:13px;cursor:pointer;font-weight:normal;color:#495c85;padding:6px 32px;border:solid 1px #495c85}
        .buttonSelectProduct * {color:#495c85}

        #iframeInstall {display:none}

        #blockProgress                  {position:absolute;top:180px;box-sizing:border-box;width:100%;font-size:13px;line-height:21px;color:#888888;padding:15px 30px;opacity:0;transition:opacity 0.3s 0.3s ease-in-out}
        .installProgress #blockProgress  {opacity:1}
        .productselection #blockProgress {display:none}
        #progressbar        {position:relative;margin-top:10px;width:100%;height:16px;}
        #progressbar:after  {position:absolute;content:'';display:block;height:16px;width:100%;background-color:#009E00;-webkit-animation: progressStatusUpdate linear 20s;-moz-animation: progressStatusUpdate linear 20s;-ms-animation: progressStatusUpdate linear 20s;animation: progressStatusUpdate linear 20s;}

        @-webkit-keyframes progressStatusUpdate {
            0% {width:0}
            100% {width:100%}
        }

        @-moz-keyframes progressStatusUpdate {
            0% {width:0}
            100% {width:100%}
        }

        @-ms-keyframes progressStatusUpdate {
            0% {width:0}
            100% {width:100%}
        }

        @keyframes progressStatusUpdate {
            0% {width:0}
            100% {width:100%}
        }

        .productselection  #blockLicense {top:590px}
        .installProgress  #blockLicense  {display:none !important}
        #blockLicense                    {padding:20px;height:396px;position:absolute;top:159px;overflow:hidden;transition:all 0.3s ease-in-out}

        #iframeLicense  {background-color:#ffffff;width:100%;height:calc(100% - 32px);box-sizing:border-box;border:solid 1px #e0e0e0;overflow:auto}
        .isAbleToInstallButWithRestrictions #iframeLicense {height:120px}

        #blockRequirements {display:none}
        .isNotAbleToInstall #blockRequirements {display:block}

        #blockRequirements {position:absolute;top:0;left:0;background-color:#ffffff;box-sizing:border-box;padding:20px;width:100%;height:100%;}

        #restrictionText {display:none;margin-bottom:20px;}

        #formSetup       {margin:160px 48px 40px 32px;}

        #checkboxAccept  {float:left;margin:16px 0 0 0;}
        #checkboxAccept label {display:inline-block;padding:0 3px 7px 3px;}
        #checkboxAccept label:hover {color:#333333}

        #buttonInstall   {float:right;margin:13px 0 0 0;position:relative;text-decoration:none;display:inline-block;font-size:11px;line-height:13px;cursor:pointer;font-weight:normal;color:#ffffff;padding:6px 32px;background-color:#495c85}
        #buttonInstall * {color:#ffffff}
        #buttonInstall.wButtonDisabled {opacity:0.3;cursor:default}

        #backToProductSelection {display:inline-block;cursor:pointer;color:#999999;height:20px;position:absolute;overflow:hidden;top:calc(50vh + 312px);left:50%;margin-left:-220px;cursor:pointer;opacity:1;transition:opacity 0.5s ease-in-out}
        #backToProductSelection:hover {color:#555555}
        .productselection #backToProductSelection,
        .installProgress #backToProductSelection  {opacity:0}

        .checkFunctionOk            {color:green}
        .checkFunctionFailed        {color:red}
        .checkFunctionRestricted    {color:#FF3300}
        .infoFunctionRestricted     {color:#FF6600}
        .infoFunctionRestricted > a {color:#923a00;text-decoration:underline}

    </style>
</head>

<body class="isNotAbleToInstall">

<?php

  define("VERSION", '000.013.000.001');

  $GLOBALS['isAbleToInstall']                    = 1;
  $GLOBALS['isAbleToInstallButWithRestrictions'] = 0;

  error_reporting(0); //error_reporting(E_ALL ^ E_NOTICE);

  $product = $_GET['product'];

  ini_set("max_execution_time", "240");
  //ini_set("memory_limit", "25M"); // 32M vorausgesetzt, mind. 25M sollten es sein

  if(file_exists($_SERVER['DOCUMENT_ROOT'].'/weblication')){
    print '<div style="margin:16px auto;width:800px">';
    print '<h1>Unter dieser Domain ist bereits eine Weblication&reg Version installiert!</h1>';
    print '<p>Sie können dieses Setup nur ausführen, wenn noch kein /weblication Verzeichnis existiert.</p>';
    print '</div>';
    exit;
  }

  else if(isset($_GET['action']) && $_GET['action'] == 'installwrc'){

    $url = 'https://downloadserver.weblication.de/index.php?action=downloadSystem&releaseVersion=13&releaseType=beta&host='.$_SERVER['HTTP_HOST'];
    $setupArchiveStr = wGetUrl($url);

    //print "<script type='text/javascript'>wShowMessagebox('installSystemProgress', 'Installation', 'Das System wird installiert', '', 'loading');</script>";

    $pathArchive = $_SERVER['DOCUMENT_ROOT'].'/wSetup_'.rand(1000, 9999).'.wrc';
    wWriteFile($pathArchive, $setupArchiveStr);
    $options = array();
    $options['compress']    = "gz";

    if(wUnpackArchiveWrc($pathArchive, $_SERVER['DOCUMENT_ROOT'], $options)){
      if (file_exists($pathArchive)){
        unlink($pathArchive);
      }
      if (file_exists($_SERVER['DOCUMENT_ROOT'].'/wSetup.php')){
        unlink($_SERVER['DOCUMENT_ROOT'].'/wSetup.php');
      }
      if (file_exists($_SERVER['DOCUMENT_ROOT'].'/wSetup_core.php')){
        unlink($_SERVER['DOCUMENT_ROOT'].'/wSetup_core.php');
      }
      if (file_exists($_SERVER['DOCUMENT_ROOT'].'/wSetup_grid.php')){
        unlink($_SERVER['DOCUMENT_ROOT'].'/wSetup_grid.php');
      }
      if (file_exists($_SERVER['DOCUMENT_ROOT'].'/wSetup_org.php')){
        unlink($_SERVER['DOCUMENT_ROOT'].'/wSetup_org.php');
      }

      if($product == 'grid'){
        print "<script>top.location.href = '/weblication/index.php?action=install&userName=admin&userPassword=admin&redirect=/weblication/grid5/scripts/wProjectmanager.php%3Faction=showBaseInstaller%26init=1';</script>";
      }
      else if($product == "core"){
        $licenseSource = '';

        $filesTmp = getFilesDir($_SERVER['DOCUMENT_ROOT'].'/weblication/grid5/default/license/core');
        foreach($filesTmp as $fileTmp){
          if(preg_match("/\.wlc$/", $fileTmp)){
            $licenseSource = $_SERVER['DOCUMENT_ROOT'].'/weblication/grid5/default/license/core/'.$fileTmp;
            continue;
          }
        }

        if($licenseSource != ''){
          $filesTmp = getFilesDir($_SERVER['DOCUMENT_ROOT'].'/weblication/grid5/default/license');
          foreach($filesTmp as $fileTmp){
            if(preg_match("/\.wlc$/", $fileTmp)){
              if (file_exists($_SERVER['DOCUMENT_ROOT'].'/weblication/grid5/default/license/'.$fileTmp)){
                unlink($_SERVER['DOCUMENT_ROOT'].'/weblication/grid5/default/license/'.$fileTmp);
              }
              $licenseDest = $_SERVER['DOCUMENT_ROOT'].'/weblication/grid5/default/license/'.preg_replace("/.*\//", "", $licenseSource);
              copy($licenseSource, $licenseDest);
            }
          }
        }
        print "<script>top.location.href = '/weblication/index.php?action=install&userName=admin&userPassword=admin&redirect=/weblication/grid5/scripts/wProjectmanager.php%3Faction=showBaseInstaller%26init=1';</script>";
      }
      else if($product == "agencyboard"){
        $licenseSource = '';

        $filesTmp = getFilesDir($_SERVER['DOCUMENT_ROOT'].'/weblication/grid5/default/license/agencyboard');
        foreach($filesTmp as $fileTmp){
          if(preg_match("/\.wlc$/", $fileTmp)){
            $licenseSource = $_SERVER['DOCUMENT_ROOT'].'/weblication/grid5/default/license/agencyboard/'.$fileTmp;
            continue;
          }
        }

        if($licenseSource != ''){
          $filesTmp = getFilesDir($_SERVER['DOCUMENT_ROOT'].'/weblication/grid5/default/license');
          foreach($filesTmp as $fileTmp){
            if(preg_match("/\.wlc$/", $fileTmp)){
              if (file_exists($_SERVER['DOCUMENT_ROOT'].'/weblication/grid5/default/license/'.$fileTmp)){
                unlink($_SERVER['DOCUMENT_ROOT'].'/weblication/grid5/default/license/'.$fileTmp);
              }              
              $licenseDest = $_SERVER['DOCUMENT_ROOT'].'/weblication/grid5/default/license/'.preg_replace("/.*\//", "", $licenseSource);
              copy($licenseSource, $licenseDest);
            }
          }
        }
        print "<script>top.location.href = '/weblication/index.php?userName=admin&userPassword=admin';</script>";
      }
      else if($product == 'send'){
        $licenseSource = '';

        $filesTmp = getFilesDir($_SERVER['DOCUMENT_ROOT'].'/weblication/grid5/default/license/send');
        foreach($filesTmp as $fileTmp){
          if(preg_match("/\.wlc$/", $fileTmp)){
            $licenseSource = $_SERVER['DOCUMENT_ROOT'].'/weblication/grid5/default/license/send/'.$fileTmp;
            continue;
          }
        }

        if($licenseSource != ''){
          $filesTmp = getFilesDir($_SERVER['DOCUMENT_ROOT'].'/weblication/grid5/default/license');
          foreach($filesTmp as $fileTmp){
            if(preg_match("/\.wlc$/", $fileTmp)){
              if (file_exists($_SERVER['DOCUMENT_ROOT'].'/weblication/grid5/default/license/'.$fileTmp)){
                unlink($_SERVER['DOCUMENT_ROOT'].'/weblication/grid5/default/license/'.$fileTmp);
              }
              $licenseDest = $_SERVER['DOCUMENT_ROOT'].'/weblication/grid5/default/license/'.preg_replace("/.*\//", "", $licenseSource);
              copy($licenseSource, $licenseDest);
            }
          }
        }
        installSend();

      }
      else if($product == "cloud"){
        $licenseSource = '';

        $filesTmp = getFilesDir($_SERVER['DOCUMENT_ROOT'].'/weblication/grid5/default/license/cloud');
        foreach($filesTmp as $fileTmp){
          if(preg_match("/\.wlc$/", $fileTmp)){
            $licenseSource = $_SERVER['DOCUMENT_ROOT'].'/weblication/grid5/default/license/cloud/'.$fileTmp;
            continue;
          }
        }

        if($licenseSource != ''){
          $filesTmp = getFilesDir($_SERVER['DOCUMENT_ROOT'].'/weblication/grid5/default/license');
          foreach($filesTmp as $fileTmp){
            if(preg_match("/\.wlc$/", $fileTmp)){
              if (file_exists($_SERVER['DOCUMENT_ROOT'].'/weblication/grid5/default/license/'.$fileTmp)){
                unlink($_SERVER['DOCUMENT_ROOT'].'/weblication/grid5/default/license/'.$fileTmp);
              }              $licenseDest = $_SERVER['DOCUMENT_ROOT'].'/weblication/grid5/default/license/'.preg_replace("/.*\//", "", $licenseSource);
              copy($licenseSource, $licenseDest);
            }
          }
        }
        print "<script>top.location.href = '/weblication/index.php?userName=admin&userPassword=admin&redirect=/cloud/index.php';</script>";
      }
    }
    exit;
  }


?>

<div id="blockSetup">
    <div id="blockProductselection">
        <div onclick="selectProduct('g', 'grid');" class="productToSelect-g"><div>Weblication&reg; GRID</div><div class="buttonSelectProduct">Auswählen</div></div>
        <div onclick="selectProduct('c', 'core');" class="productToSelect-c"><div>Weblication&reg; CORE</div><div class="buttonSelectProduct">Auswählen</div></div>
        <div onclick="selectProduct('a', 'agencyboard');" class="productToSelect-a"><div>Weblication&reg; Agenturboard</div><div class="productDescription">Plattform zum zentralen Updaten Ihrer Kundenprojekte</div><div class="buttonSelectProduct">Auswählen</div></div>
        <div onclick="selectProduct('o', 'cloud');" class="productToSelect-o"><div>Weblication&reg; Cloud</div><div class="buttonSelectProduct">Auswählen</div></div>
        <div onclick="doServerCheck();" class="productToSelect-s"><div>Weblication&reg; SEND</div><div class="productDescription">Daten verschlüsselt senden</div><div class="buttonSelectProduct">Auswählen</div></div>
    </div>
    <iframe id="iframeInstall" name="iframeInstall" src="about:blank"></iframe>
    <form name="frmSetup" action="" target="iframeInstall">
        <input type="hidden" name="redirect" value="" />
        <input type="hidden" name="product" value="" />
        <input type="hidden" name="action" value="installwrc" />

        <div id="blockProgress">
            <div>Die Installation wird durchgeführt.<br />Anschließend werden Sie zur Anmeldemaske weitergeleitet.</div>
            <div id="progressbar"></div>
        </div>
        <div id="blockLicense">
            <div id="restrictionText" class="infoFunctionRestricted">
                Diverse Voraussetzungen sind nicht erfüllt. Ggf. werden die bemängelten Module/Funktionen nicht benötigt, was Sie über die <a href="https://dev.weblication.de/dev/installation/systemvoraussetzungen-weblication.php" target="_blank" title="Entwicklerartikel">Systemvoraussetzungen</a> prüfen sollten. Eine Installation ist daher unter Vorbehalt möglich.
            </div>
            <iframe id="iframeLicense" src="https://download.weblication.de/wDownloadServer/license11_de.php"></iframe>
            <div id="checkboxAccept"><input type="checkbox" id="accept" name="accept" onClick="if(this.checked) document.getElementById('buttonInstall').className = 'wButtonDialog'; else document.getElementById('buttonInstall').className = 'wButtonDialog wButtonDisabled';"/><label for="accept">Ich akzeptiere die Lizenzvereinbarungen</label></div>
            <div id="buttonInstall" class="wButtonDialog wButtonDisabled" onclick="tryToInstall();"><span>Installieren</span></div>
        </div>

        <div id="blockRequirements">
            <div>

              <?php

                print "<div id=\"errorTextPre\" style=\"display:none;margin-bottom:14px;\">Eine Installation ist aus folgenden Gründen nicht möglich:</div>";

                $bodyStr = "";

                # Pruefung auf Betriebssystem
                if(getOs() == 'win' || getOs() == 'linux' || getOs() == 'freebsd'){
                }
                else{
                  $GLOBALS['isAbleToInstall'] = 0;
                  $bodyStr .= "os_not_supported ";
                  print "<div class=\"checkFunctionFailed\">Das Betriebssystem wird nicht unterstützt! (Server-Software: ".$_SERVER["SERVER_SOFTWARE"].")</div>";
                }

                # 19.12.2014: Webserver Litespeed wird inoffiziell vom Setup unterstützt
                # Pruefung auf Webserver
                if(preg_match("/(Apache|httpd|LiteSpeed)/i", $_SERVER["SERVER_SOFTWARE"])){
                }
                else{
                  $GLOBALS['isAbleToInstall'] = 0;
                  $bodyStr .= "webserver_not_supported ";
                  print "<div class=\"checkFunctionFailed\">Der Webserver wird nicht unterstützt! (Server-Software: ".$_SERVER["SERVER_SOFTWARE"].")</div>";
                }

                # Pruefung auf PHP Arbeitsspeicher (wegen php.ini Einstellung bei 1und1/Ionos (memory_limit: -1) bei Bedarf Prüfung rausnehmen)
                if(ini_get('memory_limit') == "" || preg_replace("/[^\d]+/", "", ini_get('memory_limit')) >= 40){
                }
                else{
                  $GLOBALS['isAbleToInstall'] = 0;
                  $bodyStr .= "memory ";
                  print "<div class=\"checkFunctionFailed\">Es wird nicht genügend Arbeitsspeicher zur Verfügung gestellt! <br />Erhöhen Sie den Arbeitsspeicher ('memory_limit') von ".ini_get('memory_limit')." auf mindestens 40M (besser 64M).</div>";
                }

                # Pruefung auf cURL
                if(function_exists("curl_init")){
                }
                else{
                  $GLOBALS['isAbleToInstall'] = 0;
                  $bodyStr .= "no_curl ";
                  print "<div class=\"checkFunctionFailed\">cURL ist nicht verfügbar.</div>";
                }

                # Pruefung auf Systembefehle
                if(!preg_match('/[,\s]exec[,\s+]/', ','.ini_get('disable_functions').',')){
                }
                else{
                  $GLOBALS['isAbleToInstallButWithRestrictions'] = 1;
                  $bodyStr .= "no_exec ";
                  print "<div id=\"noexec\" class=\"checkFunctionRestricted\">Systembefehle nicht verfügbar.</div>";
                }

                # Pruefung auf PHP JSON
                if(function_exists("json_encode")){
                }
                else{
                  $GLOBALS['isAbleToInstall'] = 0;
                  $bodyStr .= "no_json ";
                  print "<div class=\"checkFunctionFailed\">PHP JSON ist nicht verfügbar.</div>";
                }

                # Pruefung auf GD Lib v.2
                if(function_exists("gd_info")){
                  $info = gd_info();
                  if(substr_count($info["GD Version"], "2")){
                  }
                  else{
                    $GLOBALS['isAbleToInstall'] = 0;
                    $bodyStr .= "no_gd2 ";
                    print "<div class=\"checkFunctionFailed\">GD-Modul 2.x nicht verfügbar.</div>";
                  }
                }
                else{
                  $GLOBALS['isAbleToInstall'] = 0;
                  $bodyStr .= "no_gd2 ";
                  print "<div class=\"checkFunctionFailed\">GD-Modul 2.x nicht verfügbar.</div>";
                }

                # Pruefung auf ImageMagick
                $checkImageMagick = false; // auf true setzen, wenn auf ImageMagick geprueft werden soll
                $pathConvert = '';

                $status['ImageMagick'] = false;

                if(getOS() != 'win' && $checkImageMagick == true){
                  ob_start();
                  exec("type convert");
                  $pathConvert = ob_get_contents();
                  ob_end_clean();
                  if($pathConvert == ''){
                    //system('which convert', $pathConvert);
                    ob_start();
                    system("type convert");
                    $pathConvert = ob_get_contents();
                    ob_end_clean();
                  }
                  if($pathConvert == ''){
                    //system('which convert', $pathConvert);
                    ob_start();
                    exec("which convert");
                    $pathConvert = ob_get_contents();
                    ob_end_clean();
                  }
                  if($pathConvert == ''){
                    ob_start();
                    system('which convert', $pathConvert);
                    $pathConvert = ob_get_contents();
                    ob_end_clean();
                  }
                  if(preg_match('/\//', $pathConvert)){
                    $status['ImageMagickPath'] = preg_replace('/convert\s+is\s*/', '', $pathConvert);
                    //print "ImageMagick Pfad: ".$status['ImageMagickPath'];exit;
                  }
                  else{
                    $GLOBALS['isAbleToInstall'] = 0;
                    $bodyStr .= "no_imagemagick ";
                    print "<div class=\"checkFunctionFailed\">ImageMagick nicht verfügbar.</div>";
                  }
                }

                # Pruefung auf PHP-Version
                if(wCheckPhp()){

                }
                else{
                  $GLOBALS['isAbleToInstall'] = 0;
                  $bodyStr .= "php_version ";
                  print "<div class=\"checkFunctionFailed\">Die PHP-Version ist zu alt: ".phpversion().".</div>";
                }

                # Pruefung auf DOM XML
                if(wCheckDOMDocument()){
                }
                else{
                  $GLOBALS['isAbleToInstall'] = 0;
                  $bodyStr .= "extension_domxml ";
                  print "<div class=\"checkFunctionFailed\">Extension DOM XML aktiviert</div>";
                }

                # Pruefung auf XSLT
                if(wCheckXSLT()){
                }
                else{
                  $GLOBALS['isAbleToInstall'] = 0;
                  $bodyStr .= "no_xslt ";
                  print "<div class=\"checkFunctionFailed\">Keine XSLT-Unterstützung vorhanden</div>";
                }

                # Pruefung auf UTF-8 Unterstuetzung
                if(extension_loaded('mbstring')){
                }
                else{
                  $GLOBALS['isAbleToInstall'] = 0;
                  $bodyStr .= "no_mbstring ";
                  print "<div class=\"checkFunctionFailed\">Keine UTF-8-Unterstützung vorhanden (Modul mb_string)</div>";
                }

                # Pruefung auf Zlib
                if(extension_loaded('zlib')){
                }
                else{
                  $GLOBALS['isAbleToInstall'] = 0;
                  $bodyStr .= "no_zlib ";
                  print "<div class=\"checkFunctionFailed\">Keine ZLib-Unterstützung vorhanden</div>";
                }

                # Pruefung auf PDO
                if(wCheckPDO()){
                }
                else{
                  $GLOBALS['isAbleToInstall'] = 0;
                  $bodyStr .= "no_pdo ";
                  print "<div class=\"checkFunctionFailed\">Keine PDO-Unterstützung vorhanden</div>";
                }

                # Pruefung auf Berechtigungen
                if(wCheckPermissions()){
                }
                else{
                }

                print '<div id="errorTextPost" style="display:none;margin-top:14px;">';
                print 'Sofern Ihnen der <a href="http://weblik.de/wSetupInstallation" target="_blank" title="Entwicklerartikel">Artikel zur Problemlösung</a> nicht weiterhelfen konnte, können Sie nachfolgend ';
                //print '<a href="mailto:support@weblication.de?subject=Weblication Setup-Hilfe unter '.$_SERVER["HTTP_HOST"].' - '.$bodyStr.'">Hilfe anfordern</a>.';
                print '<a href="https://send.scholl.de/weblication/grid5/appsExtern/wSend/pages/form.php?profileID=support@weblication.de&subject=Weblication%20Setup-Hilfe%20unter%20'.$_SERVER["HTTP_HOST"].'%20-%20'.$bodyStr.'" target="_blank">Hilfe anfordern</a>.';
                print '</div>';

                if($GLOBALS['isAbleToInstallButWithRestrictions'] == 1 && $GLOBALS['isAbleToInstall'] != 0){
                  print '<script type="text/javascript">isAbleToInstallButWithRestrictions = true;updateMask()</script>';
                }
                else if($GLOBALS['isAbleToInstall'] == 1){
                  print '<script type="text/javascript">isAbleToInstall = true;updateMask()</script>';
                }
                else{
                  print '<script type="text/javascript">document.body.className = "isNotAbleToInstall";updateMask()</script>';
                }

              ?>
            </div>
        </div>
    </form>
</div>
<div id="backToProductSelection" onclick="backToProductSelection()">Zurück zur Auswahl</div>
</body>

</html>
<?php

  function wCheckPhp(){
    if(version_compare(phpversion(), '7.0.0', '>=') == 1){
      return true;
    }
    else{
      return false;
    }
  }

  function wCheckDOMDocument(){
    if(in_array('DOMDocument', get_declared_classes())){
      return true;
    }
    return false;
  }

  function wCheckXSLT(){
    if(in_array('XSLTProcessor', get_declared_classes())){
      return true;
    }
    return false;
  }

  function wCheckPDO(){
    if(in_array('PDO', get_declared_classes())){
      return true;
    }
    return false;
  }

  function wCheckPermissions(){

    $protocolSystemcheck = '<wSystemcheck>'."\n";

    $pathWriteFileRoot   = $_SERVER['DOCUMENT_ROOT'].'/wTest.txt';
    $stringWriteFileRoot = 'test';

    if(wWriteFile($pathWriteFileRoot, $stringWriteFileRoot)){
      $resultWriteFileRoot = '1';
      unlink($pathWriteFileRoot);
    }
    else{
      print "<div class=\"checkFunctionFailed\">Datei anlegen fehlgeschlagen</div>";
      $resultWriteFileRoot = '0';
      $GLOBALS['isAbleToInstall'] = 0;
    }

    $protocolSystemcheck .= ' <test name="writeFileRoot" result="'.$resultWriteFileRoot.'" />'."\n";

    $pathCreateDirRoot   = $_SERVER['DOCUMENT_ROOT'].'/wTest'.rand(1000, 9999);

    if(wCreateDir($pathCreateDirRoot, 0777)){
      $resultCreateDirRoot = '1';

      $pathWriteFileCreatedDir    = $pathCreateDirRoot.'/wTest.php';
      $stringWriteFileCreatedDir  = 'wTest';

      if(wWriteFile($pathWriteFileCreatedDir, $stringWriteFileCreatedDir)){
        $resultWriteFileCreatedDir = '1';
        unlink($pathWriteFileCreatedDir);
      }
      else{
        print "<div class=\"checkFunctionFailed\">Datei in angelegtes Verzeichnis anlegen fehlgeschlagen</div>";
        $resultWriteFileCreatedDir = '0';
        $GLOBALS['isAbleToInstall'] = 0;
      }
      rmdir($pathCreateDirRoot);
    }
    else{
      print "<div class=\"checkFunctionFailed\">Verzeichnis anlegen fehlgeschlagen</div>";
      $resultCreateDirRoot = '0';
      $GLOBALS['isAbleToInstall'] = 0;
    }

    $protocolSystemcheck .= ' <test name="createDirRoot" result="'.$resultCreateDirRoot.'" />'."\n";

    $protocolSystemcheck .= ' <test name="writeFileCreatedDir" result="'.$resultWriteFileCreatedDir.'" />'."\n";

    $urlCheckHTTPExtern = 'https://download.weblication.de/wSetup/checkHTTP.php';

    $resultStrCheckHTTPExtern = wGetUrl($urlCheckHTTPExtern);
    if($resultStrCheckHTTPExtern == "OK"){
      $resultCheckHTTPExtern = '1';
    }
    else{
      print "<div class=\"checkFunctionFailed\">HTTP-Verbindung zu externem Server fehlgeschlagen</div>";
      $resultCheckHTTPExtern = '0';
      $GLOBALS['isAbleToInstall'] = 0;
    }

    $protocolSystemcheck .= ' <test name="checkHTTPExtern" result="'.$resultCheckHTTPExtern.'" />'."\n";
    $protocolSystemcheck .= '<wSystemcheck>';
    return true;
  }

  function wCreateDir($path, $permissions){

    return mkdir($path, $permissions);
  }

  function wWriteFile($path, $string){

    $fh = @fopen($path, 'w');

    if(is_resource($fh)){
      @fwrite($fh, $string);
      clearstatcache();
      fclose($fh);
      return true;
    }
    else{
      return false;
    }
  }


  function wReadFile($path){

    $fh = @fopen($path, 'r');

    if($fh){
      $string = @fread($fh, filesize($path));
      fclose($fh);
      return $string;
    }
    else{
      return "";
    }
  }

  function getFilesDir($path){

    $filesDir = array();

    $dh = @opendir($path);
    if($dh){
      while(($fileName = readdir($dh)) !== false){
        if(!($fileName == '.' || $fileName == '..') && is_file($path.'/'.$fileName)){
          array_push($filesDir, $fileName);
        }
      }
      closedir($dh);
    }
    return $filesDir;
  }

  function wGetUrl($url){
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $result  = curl_exec($ch);
    curl_close ($ch);

    return $result;
  }

  function wUnzip($path, $dest){

    $cmd = "unzip -d $dest -o $path";

    unset($arrayRet);
    exec($cmd, $arrayRet, $retValue);
    if($retValue != 0){
      print "unzip error:CMD=\"$cmd\". $php_errormsg. ";
      return false;
    }
    else{
      return true;
    }
  }

  function getOS($mode = "s"){

    $os = php_uname($mode);

    if(preg_match("/^Linux/i", $os)){
      $os = "linux";
    }
    else if(preg_match("/^Windows/i", $os)){
      $os = "win";
    }
    else if(preg_match("/^FreeBSD/i", $os)){
      $os = "freebsd";
    }
    else if(preg_match("/^HP\-UX/i", $os)){
      $os = "hp-ux";
    }
    else{
      $os = "linux";
    }

    return $os;

  }

  function wUnpackArchiveWrc($fileWrc = NULL, $destPath = NULL, $options = NULL, $debug = FALSE) {

    $fh = fopen ($fileWrc, "r");
    $seek = ftell($fh);
    $firstLine = fgets($fh, 4096);
    if(!preg_match("/\xFF\xD2\x23\x93WRC\x99\s+.*\n/", $firstLine)){
      $errStr = "Isn't WRC file \"$fileWrc\"... $php_errormsg. ";
      return FALSE;
    }

    $buffer = "";
    while (!feof($fh)){
      $buffer .= fgets($fh, 4096);
      if(preg_match("/##__ARCHIVE_HEADER_END__##\n\n/", $buffer)){
        break;
      }
    }
    $seek = ftell($fh);
    $header = unserialize($buffer);
    unset($buffer);
    while (!feof($fh)){
      $buffer .= fgets($fh, 4096);
      if(preg_match("/".$header['dirsEnd']."\n/", $buffer)){
        break;
      }
    }
    $dirsStr = preg_replace("/".$header['dirsBegin']."(.*)".$header['dirsEnd']."\n/s", "$1", $buffer);
    $dirsStrUncompressed =  uncompressStr($dirsStr, $options);
    $dirs = unserialize($dirsStrUncompressed);
    unset($dirsStr);
    unset($dirsStrUncompressed);
    $dir = "";
    foreach($dirs as $dir){
      mkdir($destPath.$dir, 0755, 1);
    }
    unset($dir);
    unset($dirs);
    unset($dirStr);
    unset($buffer);
    $memoryLimit = preg_replace("/(\d+).*/", "$1", ini_get('memory_limit')) * 1000000;
    while (!feof($fh)){
      $buffer .= fgets($fh, 4096);
      if(preg_match("/".$header['chunkEnd']."\n/", $buffer)){
        $buffer = preg_replace("/".$header['chunkBegin']."(.*)".$header['chunkEnd']."\n/s", "$1", $buffer);
        $uncompressedStr = uncompressStr($buffer, $options);
        unset($buffer);
        preg_match_all("/".$header['fileBegin']."(.*)".$header['fileEnd']."/", $uncompressedStr, $matches);
        unset($uncompressedStr);
        if(count($matches[1] > 0)){
          foreach($matches[1] as $match){
            preg_match("/(.*?):(.*)/s", $match, $treffer);
            $path               = $treffer[1];
            $content        = $treffer[2];
            unset($treffer);
            $content = base64_decode($content);
            wWriteFile($destPath.$path, $content);
            unset($content);
            unset($match);
            unset($content);
          }
          unset($matches);
        }
      }
    }
    $seek = ftell($fh);
    fclose ($fh);
    return TRUE;
  }

  function uncompressStr($compressedStr = NULL, $options = FALSE, $debug = FALSE) {

    if($options['compress'] == "zip"){
      $errStr = "Method ".$options['compress']." not implemented... $php_errormsg. ";
      return FALSE;
    }
    if($options['compress'] == "gz"){
      $uncompressedStr = gzinflate($compressedStr);
    }

    if($uncompressedStr == FALSE){
      $errStr = "Can't decompress string... $php_errormsg. ";
      $return = FALSE;
    }
    unset($compressedStr);

    return $uncompressedStr;
  }

  function siteURLProtocol(){
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    return $protocol;
  }

	function installSend( $options = '' ) {

		if( file_exists( $_SERVER['DOCUMENT_ROOT'] . '/send' ) ) {
			print 'SEND ist bereits installiert';
			exit;
		}

		exec( 'tar --version', $tarExec );
		if( count( $tarExec ) !== 0 ) {
			$tar = true;
		}
		else {
			$tar = false;
		}

		exec( 'unzip -v', $unzipExec );
		if( count( $unzipExec ) !== 0 ) {
			$zip = true;
		}
		else {
			$zip = false;
		}

		$downloadFileType = 'tgz';
		if( $tar !== true ) {
			$downloadFileType = 'zip';
		}

		$downloadURL = 'https://downloadsend.weblication.de/downloadserver/dist/';
		$downloadDIR = 'distribution/';
		$downloadSCRIPT = 'checkVersion/';
		$installACTION = 'install';

		$installDIR = '/send/';
		$installTYPE = 'alpha';
		$installHOST = $_SERVER['HTTP_HOST'];


		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $downloadURL . $downloadDIR . $downloadSCRIPT );
		curl_setopt( $curl, CURLOPT_POST, 1 );
		curl_setopt( $curl, CURLOPT_POSTFIELDS, "action=checkVersion&type=" . $installTYPE );
		curl_setopt( $curl, CURLOPT_HEADER, 0 );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
		$latestVersion = curl_exec( $curl );
		curl_close( $curl );

		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $downloadURL . $downloadDIR . $downloadSCRIPT );
		curl_setopt( $curl, CURLOPT_POST, 1 );
		curl_setopt( $curl, CURLOPT_POSTFIELDS, "action=downloadVersion&type=" . $installTYPE . "&fileType=" . $downloadFileType . "&installAction=" . $installACTION . "&installHOST=" . $installHOST );
		curl_setopt( $curl, CURLOPT_HEADER, 0 );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
		$downloadPath = curl_exec( $curl );
		curl_close( $curl );

		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $downloadURL . $downloadPath );
		curl_setopt( $curl, CURLOPT_POST, 0 );
		curl_setopt( $curl, CURLOPT_HEADER, 0 );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
		$installFileContent = curl_exec( $curl );
		curl_close( $curl );

		$filename = basename( $downloadPath );

		$tmpDir = $_SERVER['DOCUMENT_ROOT'] . '/send/tmp_install/';
		$installDir = $_SERVER['DOCUMENT_ROOT'] . $installDIR;
		if( !is_dir( $tmpDir ) ) {
			@mkdir( $tmpDir, 0755, true );
			@mkdir( $installDir, 0755, true );
		}

		file_put_contents( $tmpDir . $filename, $installFileContent );

		if( $tar === true ) {
			$unpackCMD = 'tar -xzf ' . $tmpDir . $filename . ' -C ' . $installDir;
		}
		else {
			$unpackCMD = 'unzip -qq ' . $tmpDir . $filename . ' -d ' . $installDir;
		}

		system( $unpackCMD );
		unlink( $tmpDir . $filename );


		include_once($installDir . 'application/config/bootstrap.php');
		try {
			$UpdaterFactory = new \wSend\factories\wSendUpdaterFactory();
			$Updater = $UpdaterFactory->getUpdater();
			$Updater->afterInstall( ['tmpDir' => $tmpDir, 'createRedirect' => true, 'initAdmin' => true, 'latestVersion' => $latestVersion] );
		}
		catch ( \wSend\core\exceptions\wSendException $e ) {
			print "Es ist ein Fehler aufgetreten";
		}

		print "<script>top.location.href = '/send/';</script>";

	}

?>
