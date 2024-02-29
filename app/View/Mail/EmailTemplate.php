<?php

namespace app\View\Mail;

use app\App;
use app\Settings\AppSettings;
use app\View\Mail\LogTable\LogTableHead;
use app\View\Mail\LogTable\LogTableBody;
use app\View\ViewInterface;

/**
 *
 * Class EmailTemplate
 *
 * Class responsible for rendering email templates.
 *
 */
class EmailTemplate implements ViewInterface
{
    public function render(mixed $meta = null): string
    {
        $template = '<!DOCTYPE html>
            <html lang="de">
            <head>
            <title>' . PLUGIN_NAME . '</title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width">
            <style>
                /* CLIENT-SPECIFIC STYLES */
                #outlook a{padding:0;} /* Force Outlook to provide a "view in browser" message */
                .ReadMsgBody{width:100%;} .ExternalClass{width:100%;} /* Force Hotmail to display emails at full width */
                .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Force Hotmail to display normal line spacing */
                body, table, td, a{-webkit-text-size-adjust:100%; -ms-text-size-adjust:100%;} /* Prevent WebKit and Windows mobile changing default text sizes */
                table, td{mso-table-lspace:0; mso-table-rspace:0;} /* Remove spacing between tables in Outlook 2007 and up */
                img{-ms-interpolation-mode:bicubic;} /* Allow smoother rendering of resized image in Internet Explorer */
            
                /* RESET STYLES */
                body{margin:0; padding:0;}
                img{border:0; height:auto; line-height:100%; outline:none; text-decoration:none;}
                table{border-collapse:collapse !important;}
                body{height:100% !important; margin:0; padding:0; width:100% !important;}
            
                /* iOS BLUE LINKS */
                .appleBody a {color:#68440a; text-decoration: none;}
                .appleFooter a {color:#999999; text-decoration: none;}
            
                /* MOBILE STYLES */
                @media screen and (max-width: 525px) {
            
                    /* ALLOWS FOR FLUID TABLES */
                    table[class="wrapper"]{
                      width:100% !important;
                    }
            
                    /* ADJUSTS LAYOUT OF LOGO IMAGE */
                    td[class="logo"]{
                      text-align: left;
                      padding: 20px 0 20px 0 !important;
                    }
            
                    td[class="logo"] img{
                      margin:0 auto!important;
                    }
            
                    /* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */
                    td[class="mobile-hide"]{
                      display:none;}
            
                    img[class="mobile-hide"]{
                      display: none !important;
                    }
            
                    img[class="img-max"]{
                      max-width: 100% !important;
                      height:auto !important;
                    }
            
                    /* FULL-WIDTH TABLES */
                    table[class="responsive-table"]{
                      width:100%!important;
                    }
            
                    /* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */
                    td[class="padding"]{
                      padding: 10px 5% 10px 5% !important;
                    }
            
                    td[class="padding-copy"]{
                      padding: 10px 5% 10px 5% !important;
                      text-align: left;
                    }
            
                    td[class="padding-meta"]{
                      padding: 10px 5% 10px 5% !important;
                      text-align: left;
                    }
            
                    td[class="no-pad"]{
                      padding: 20px 0 20px 0 !important;
                    }
            
                    td[class="no-padding"]{
                      padding: 0 !important;
                    }
            
                    td[class="section-padding"]{
                      padding: 50px 15px 50px 15px !important;
                    }
            
                    td[class="section-padding-bottom-image"]{
                      padding: 50px 15px 0 15px !important;
                    }
            
                    /* ADJUST BUTTONS ON MOBILE */
                    td[class="mobile-wrapper"]{
                        padding: 15px 5% 15px 5% !important;
                    }
            
                    table[class="mobile-button-container"]{
                        margin:0 auto;
                        width:100% !important;
                    }
            
                    a[class="mobile-button"]{
                        width:80% !important;
                        padding: 15px !important;
                        border: 0 !important;
                        font-size: 16px !important;
                    }                   
                }
            </style>
            </head>
                <body style="margin: 0; padding: 0;">
                
                <!-- HEADER -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%">            
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 20px 15px 20px 15px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="500" class="responsive-table">
                                <tr>
                                    <td align="left" style="font-size: 24px; color: #78d4ec; font-weight: 500; line-height: 30px; font-family: Helvetica, Arial, sans-serif;">
                                        ' . PLUGIN_NAME . '
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
              
                <!-- BODY -->
                <table>
                    <tr>
                        <td class="padding" style="padding: 20px 15px 20px 15px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="responsive-table">
                                <tr>
                                    <td>
                                        <p style="font-size: 16px; line-height: 24px; font-family: Helvetica, Arial, sans-serif; color: #767676;">
                                            Hallo <span style="font-weight: 500; color: #78d4ec">' . App::Setting()->read(App::make(AppSettings::class)->mail_recipient_setting) . '</span><br>
                                            anbei finden Sie den ' . PLUGIN_NAME . ' Report ihrer Homepage <a style="color: #78d4ec;" href="' . App::Url()->getBasepath() . '" target="_blank">' . home_url() . '</a>. <br>                                    
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                
                <br />
                <br />
                <br />
                
                <table class="error-logs" style="border-collapse: collapse; margin-top: 20px; margin-bottom: 50px;">
                    <thead>
                    ' . App::make(LogTableHead::class)->render() . '
                    </thead>
                    <tbody>
                    ' . App::make(LogTableBody::class)->render($meta) . '
                    </tbody>
                </table>          
                
                <br />
                <br />
                <br />
                
                <!-- FOOTER -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="font-size: 12px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color:#666666;">
                            <table border="0" cellpadding="0" cellspacing="0" width="500" class="responsive-table">
                                <tr>
                                    <td align="left"  style="padding: 0 15px 0 15px;">
                                        <p style="font-size: 16px; line-height: 24px; font-family: Helvetica, Arial, sans-serif; color: #767676;">   
                                            market port GmbH<br/>                                                
                                            <a style="color: #78d4ec" href="https://marketport.de">market port GmbH</a> <br />
                                            <a style="color: #78d4ec" href="mailto:info@marketport.de">info@marketport.de</a> <br />
                                            Splieterstrasse 27<br /> 
                                            48231 Warendorf <br /><br />
                                            Ansprechpartner: <br />
                                            Timothy Roth <br />
                                            <a style="color: #78d4ec" href="mailto:roth@marketport.de">roth@marketport.de</a> <br />                                            
                                       </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                </body>
            </html>';
        ?>
        <?php return $template;
    }
}
