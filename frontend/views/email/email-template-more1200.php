<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$preUrl = Url::to('@web/',true);
$preUrl = explode('//', $preUrl);
$Urlhttp = $preUrl[0];
$Url = '';
$preUrl = explode('/', $preUrl[1]);
foreach($preUrl as $v){
	if($v != 'cpanel'){
		if($Url == ''){
			$Url .= $v;
		}else{
			$Url .= '/'.$v;
		}
	}
}
$Url = $Urlhttp.'//'.$Url;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>BORGES</title>
    
<style type="text/css">
      ReadMsgBody{ width: 100%;}
      .ExternalClass {width: 100%;}
      .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
      body {-webkit-text-size-adjust:100%; -ms-text-size-adjust:100%;margin:0 !important;}
      p { margin: 1em 0;}
      table td { border-collapse: collapse;}
      img {outline:0;}
      a img {border:none;}
      @-ms-viewport{ width: device-width;}
    </style>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Libre+Bodoni&family=Nunito&display=swap');
    @import url('https://fonts.googleapis.com/css?family=Raleway');
    @import url('https://fonts.googleapis.com/css2?family=Oxygen');
  @import url('https://fonts.googleapis.com/css2?family=Assistant');
  @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');
   
  @font-face {
    font-family: 'Nestle Script AR';
    src: url(https://dev-dig0031348-communications-nestle-panama.pantheonsite.io/themes/custom/nestle/fonts/NestleScript/NestleScriptAR-Regular.otf);
}

@font-face {
    font-family: 'Nestle Text';
    src: url(https://dev-dig0031348-communications-nestle-panama.pantheonsite.io/themes/custom/nestle/fonts/NestleText/Normal/NestleText/NestleText-Light.otf);
    font-stretch: normal;
    font-weight: normal;
}

@font-face {
    font-family: 'Nestle Text';
    src: url(https://dev-dig0031348-communications-nestle-panama.pantheonsite.io/themes/custom/nestle/fonts/NestleText/Normal/NestleText/NestleText-Bold.otf);
    font-stretch: normal;
    font-weight: bold;
}
  
</style>
<!-- outlook 2013 fix begin -->
    <!--[if gte mso 15]>
        <style type="text/css" media="all">
            /* Outlook 2013 Height Fix */
            body { font-size: 0; line-height: 0; }
            tr { font-size:1px; mso-line-height-alt:0; mso-margin-top-alt:1px; }
        </style>
 <![endif]-->
<!-- outlook 2013 fix end -->
<style type="text/css">
    [style*="Raleway"] {
        font-family: 'Raleway', Verdana, sans-serif !important
    }

  [style*="Oxygen"] {
       font-family: 'Oxygen', sans-serif !important
    }
  
    .normal-tipo {
        font-family: Verdana, Geneva, sans-serif !important;
    }

    table {
        border-collapse: collapse;
        margin: 0 auto;
    }

    body {
        margin: 0;
        padding: 0;
    }

    div,
    p,
    a,
    li,
    td {
        -webkit-text-size-adjust: none;
    }

    table {
        border-collapse: collapse !important;
    }

    .gradient-cta {
        background: -moz-linear-gradient(left, #00bfb3 0%, #009edf 100%);
        background: -webkit-linear-gradient(left, #00bfb3 0%, #009edf 100%);
        background: linear-gradient(to left, #00bfb3 0%, #009edf 100%);
        background: -ms-linear-gradient(left, #00bfb3 0%, #009edf 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#00bfb3', endColorstr='#009edf', GradientType=1);
    }

  .bgregalo{
  height: 69px;
      }
  
    @media only screen and (max-width: 600px) {
        .bgregalo{
  height: 46px;
      }
      
        .container {
            width: 95% !important;
        }

        .align-center {
            margin: 0 auto !important;
        }

        center {
            min-width: 0 !important;
        }

        .remove-mobile {
            width: 0px !important;
            display: none !important;
            height: 0px !important;
        }

        .remove-height {
            height: auto !important;
        }

        .destination-box-table {
            width: 100% !important;
        }

        .destination-box {
            width: 100% !important;
            display: inline-block !important;
        }

        .responsive-td {
            width: 100% !important;
            display: inline-block !important;
        }

        .scale-img {
            display: block;
            width: 100% !important;
            height: auto !important;
            border: 0 !important;
        }
        
        .text-center {
            text-align: center !important;
        }

        .text-footer {
            font-size: 27px !important;
        }
    }

    @media only screen and (max-width: 450px) {
        .destination-box-vertical {
            width: 100% !important;
            display: inline-block !important;
        }

       .bgregalo{
  height: 40px;
      }
      
        .table-center {
            margin: 0 auto !important;
        }

        .remove-mobile2 {
            width: 0px !important;
            display: none !important;
            height: 0px !important;
        }

        .text-center-vertical {
            text-align: center !important;
        }

        .mobiler2{
          font-size: 13px;
        }
        .titulo{
          font-size: 17px;
        }
    }
  @media screen and (min-width:600px) {
    .foot-mobile{
        display: none;
    }
    
  }
   @media screen and (max-width: 600px) {
    .mobiler {
        font-size: 16px;
      }
     .titulo{
     font-size: 20px;
     }
     
     .mobiler2{
        font-size: 15px;
     }
     .mobiler3{
        font-size: 14px;
     }
     .mobiler4{
        font-size: 10px;
     }
     
     .mobiler5{
       margin-top: -20px;
        font-size: 9px;
     }
     .mobiler6{
     
     font-size: 12px;}
     
     .mobiler7{
     
     font-size: 11px;}
     
     .mobiler8{
     
     font-size: 10.5px;}
     .espacio{
     line-height: 22px;
     }
     
     .logo{
        width:30% !important; 
        margin-bottom: 20px !important;
        padding-top: 20px !important;
     }
     .cont-redes{
        width:25%; display: flex; justify-content: space-between;
     }
     .textof{
        margin-top: 10px;
     }
     .textof2{
         margin-top: 10px; width:70%; margin-bottom:20px;
         line-height: 15px;
     }
     .desktop{
        display: none;
     }

        }

</style>
    <!--[if mso]>
      <style type="text/css">
          /* Begin Outlook Font Fix */
          body, table, td {
              font-family: Arial, Helvetica, sans-serif ;
              font-size:16px;
              color:#000000;
              line-height:1;
          }
          /* End Outlook Font Fix */
      </style>
    <![endif]-->
  </head>
  <body bgcolor="#ffffff" text="#000000" style="background-color: #ffffff; color: #000000; padding: 0px; -webkit-text-size-adjust:none; font-size: 16px; font-family:arial,helvetica,sans-serif;">
    <div style="max-width:1px;">
      <custom name="usermatch" type="tracking"/>
        <custom name="opencounter" type="tracking"/>
    </div>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
      <tr>
        <td align="center" valign="top">
          
        </td>
      </tr>
      <tr>
        <td align="center">
          <table cellspacing="0" cellpadding="0" border="0" width="600" class="container" align="center">
            <tr>
              <td>
                <table class="tb_properties border_style" style="background-color:#FFFFFF;" cellspacing="0" cellpadding="0" bgcolor="#ffffff" width="100%">
                  <tr>
                    <td align="center" valign="top">
                      <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                          <!-- added padding here -->
                          <td class="content_padding" >
                            <!-- end of comment -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tr> <!-- top slot -->
                                <td align="center" class="header" valign="top">
                                  <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tbody>
                                        <tr>
                                          <td align="left" valign="top">
                                            <table cellspacing="0" cellpadding="0" style="width:100%">
                                              <tbody>
                                              <tr>
                                                <td class="responsive-td" valign="top" style="width: 100%;">
                                                  <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="min-width: 100%; " class="stylingblock-content-wrapper"><tr><td class="stylingblock-content-wrapper camarker-inner"><!-- BLOCK VIEW ONLINE--><table align="center" bgcolor="#E11F1C" border="0" cellpadding="0" cellspacing="0" class="container" width="100%">
 
  <tr>
   <td>
    <table align="center" bgcolor="#E11F1C" border="0" cellpadding="0" cellspacing="0" style="width:100%;max-width:600px;">
     
      <tr>
       <td align="center" bgcolor="" style="font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:13px;font-weight:500;color:#fff">
       	<p style="display: none;">Hemos cumplido con los reembolsos, pero sigues participando por premios semanales.</p>
        &iquest;No puedes ver correctamente este email? <b><a href="%%view_email_url%%" style="font-weight:500;color:#fff;text-decoration:underline;" target="blank_"><b>Da click aqu&iacute;.</b></a></b></td></tr><tr height="13">
      </tr></table></td></tr></table></td></tr></table>
      
      <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="min-width: 100%; " class="stylingblock-content-wrapper"><tr><td class="stylingblock-content-wrapper camarker-inner"><table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%">
 
  <tr>
   <td>
    <!--LOGO-->
    <table align="center" bgcolor="#FAF8F2" border="0" cellpadding="0" cellspacing="0" class="container" style="width:100%;max-width:600px;">
     <tr height="20"></tr>
      <tr>
       <td width="225">
       </td><td width="150">
        <a alias="" conversion="false" data-linkto="http://" href="https://borges.es/?utm_source=newsletter&utm_medium=email&utm_campaign=SV&utm_id=BorgesSV" title=""><img alt="" data-assetid="137580" src="<?= $Url; ?>images/NL-C/Assets/logo_Borges 3.png" style="padding: 0px; text-align: center; height: auto; width: 100%; border: 0px;" width="1000"></a></td><td width="225">
       </td></tr></table></td></tr></table></td></tr></table>
       
       
       
       <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="min-width: 100%; " class="stylingblock-content-wrapper"><tr><td class="stylingblock-content-wrapper camarker-inner"><table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%">
 <!--IMAGEN 1-->
  <tr>
   <td>
    <table align="center" bgcolor="#FAF8F2" border="0" cellpadding="0" cellspacing="0" class="container" style="width:100%;max-width:600px;">
     
      <tr calss="remove-mobile" height="15">
      </tr><tr height="5">
      </tr><tr>
       <td width="600">
        <a alias="" conversion="false" data-linkto="http://" href="https://naturalmenteirresistibleborges.com/?utm_source=newsletter&utm_medium=email&utm_campaign=SV&utm_id=BorgesSV" title="">
          <img alt="" data-assetid="137585" src="<?= $Url; ?>images/NL-C/Assets/Captura de Pantalla 2022-01-17 a la(s) 8.58.20 a. m 2.png" style="padding: 0px; text-align: center; height: auto; width: 100%; border: 0px;" width="1000"></a></td></tr></table></td></tr></table></td></tr></table>
        
        <!--TITULO-->
        <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="min-width: 100%; " class="stylingblock-content-wrapper"><tr><td class="stylingblock-content-wrapper camarker-inner"><!-- BLOCK TEXT--><table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="100%">
 
  <tr>
   <td>
    <table align="center" bgcolor="#FAF8F2" border="0" cellpadding="0" cellspacing="0" class="container" style="width:100%;max-width:600px;">
     
      <tr>
       <td class="remove-mobile" height="10">
       </td></tr><tr>
       <td height="10">
       </td></tr><tr>
       <td width="10">
       </td><td align="center" bgcolor="" style="font-family : 'Libre Bodoni', Calibri,Helvetica, sans-serif; font-size:40px;line-height:normal;font-weight:700;color:#E11F1C;text-align:center; padding-top: 0px; padding-bottom: 0px;" width="400">
        <b class="titulo">¡Ya hemos reembolsado<br><span style="font-size: 120px;" ><span class="titulo">1200</span></span><br>
          unidades!
        </b></td><td width="10">
       </td></tr><tr>
       <td height="10">
       </td></tr></table></td></tr></table></td></tr></table>
       
       <!--texto 1-->
       <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="min-width: 100%; " class="stylingblock-content-wrapper"><tr><td class="stylingblock-content-wrapper camarker-inner">
        <!-- BLOCK TEXT--><table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="100%">
 
  <tr>
   <td>
    <table align="center" bgcolor="#FAF8F2" border="0" cellpadding="0" cellspacing="0" class="container" style="width:100%;max-width:600px;">
     
      <tr class="desktop">
       <td height="10">
       </td></tr><tr>
       <td width="10">
       </td><td align="center" bgcolor="" style="font-family: 'Montserrat',Calibri,Helvetica, sans-serif; font-size:18px;;font-weight:500;color:#000;text-align:center;" width="580">
        <span class="mobiler2" >

          <b> ¡Gracias por ingresar tu factura!</b><br><br>

          Ya hemos cumplido con el límite de reembolsos de la<br class="remove-mobile"> 
          promoción, pero por tu compra sigues participando <br class="remove-mobile"> 
          por premios semanales. <br>
          <span style="color: #E11F1C; "> <b>¡Puedes ser el ganador de una increíble experiencia! </b> </span>
        </span></td><td width="10">
       </td></tr><tr>
       <td height="10">
       </td></tr></table></td></tr></table></td></tr></table>

       <!--texto 1-->
       <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="min-width: 100%; " class="stylingblock-content-wrapper"><tr><td class="stylingblock-content-wrapper camarker-inner">
        <!-- BLOCK TEXT--><table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="100%">
 
  <tr>
   <td>
    <table align="center" bgcolor="#E11F1C" border="0" cellpadding="0" cellspacing="0" class="container" style="width:100%;max-width:600px;">
     
      <tr class="desktop">
       <td height="20">
       </td></tr><tr>
       <td width="10">
       </td><td align="center" bgcolor="" style="font-family: 'Montserrat',Calibri,Helvetica, sans-serif; font-size:18px;;font-weight:500;color:#fff;text-align:center;" width="580">
        <span class="mobiler2" >

          <b>Si eres escogido como ganador nos estaremos
          <br class="remove-mobile"> comunicando contigo vía e-mail.</b>
        </span></td><td width="10">
       </td></tr><tr>
       <td height="20">
       </td></tr></table></td></tr></table></td></tr></table>

<!--TITULO 2-->
<table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="min-width: 100%; " class="stylingblock-content-wrapper"><tr><td class="stylingblock-content-wrapper camarker-inner"><!-- BLOCK TEXT--><table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="100%">
 
  <tr>
   <td>
    <table align="center" bgcolor="#FAF8F2" border="0" cellpadding="0" cellspacing="0" class="container" style="width:100%;max-width:600px;">
     
      <tr>
       <td class="remove-mobile" height="10">
       </td></tr><tr>
       <td height="10">
       </td></tr><tr>
       <td width="10">
       </td><td align="center" bgcolor="" style="font-family : 'Libre Bodoni', Calibri,Helvetica, sans-serif; font-size:24px;line-height:normal;font-weight:700;color:#E11F1C;text-align:center; padding-top: 0px; padding-bottom: 0px;" width="400">
        <b class="titulo">Atento al sorteo ¡Mucha Suerte!
        </b></td><td width="10">
       </td></tr><tr>
       <td height="10">
       </td></tr></table></td></tr></table></td></tr></table>
       
       <!--Boton-->
       <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="min-width: 100%; " class="stylingblock-content-wrapper"><tr><td class="stylingblock-content-wrapper camarker-inner"><table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%">
 
  <tr>
   <td>
    <table align="center" bgcolor="#FAF8F2" border="0" cellpadding="0" cellspacing="0" class="container" style="width:100%;max-width:600px; padding: 0px;">
     
      <tr calss="remove-mobile" height="5">
      </tr><tr height="5">
      </tr><tr>
       <td width="200">
       </td><td width="200">
        <a alias="" conversion="false" data-linkto="http://" href="https://naturalmenteirresistibleborges.com/?utm_source=newsletter&utm_medium=email&utm_campaign=SV&utm_id=BorgesSV" title=""><img alt="" data-assetid="137578" src="<?= $Url; ?>images/NL-C/Assets/Group 51.png" style="padding: 0px; height: auto; width: 100%; text-align: center; border: 0px;" width="1000"></a></td><td width="200">
       </td></tr></table></td></tr></table></td></tr></table>
       
       <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="min-width: 100%; " class="stylingblock-content-wrapper">
        <tr>
          <td class="stylingblock-content-wrapper camarker-inner">
            <table width="100%" cellspacing="0" cellpadding="0" role="presentation" bgcolor="#FAF8F2">
              <tr>
                <td align="center">
                  <a alias="" conversion="false" data-linkto="http://" href="https://naturalmenteirresistibleborges.com/?utm_source=newsletter&utm_medium=email&utm_campaign=SV&utm_id=BorgesSV" title="">
                  <img data-assetid="137581" src="<?= $Url; ?>images/NL-C/Assets/Frame 2.png" alt="" width="817" style="display: block; padding: 0px; text-align: center; height: auto; width: 100%; border: 0px;"></a></td></tr></table></td></tr></table>
                                                </td>
                                              </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                    </tbody>
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td valign="top">
          
        </td>
      </tr>
    </table>
  </body>
</html>

