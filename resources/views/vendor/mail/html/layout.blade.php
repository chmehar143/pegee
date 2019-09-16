<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"> <!-- utf-8 works for most cases -->
        <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    </head>
    <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#fff" style="margin:0; padding:0; -webkit-text-size-adjust:none; -ms-text-size-adjust:none;">
        <table cellpadding="0" cellspacing="0" border="0" height="100%" width="100%" bgcolor="#fff" style="border-collapse:collapse;">
            <tr>
                <td>

                    <!-- Email wrapper : BEGIN -->
                    <table border="0" width="596" cellpadding="0" cellspacing="0" align="center" style="width:596px; margin: auto;border:2px solid #48cd4e" class="email-container">
                        <tr>
                            <td>

                                <!-- Logo + Links : BEGIN -->
                                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                    {{ $header or '' }}
                                </table>
                                <!-- Logo + Links : END -->

                                <!-- Main Email Body : BEGIN -->
                                <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#ffffff">

                                    <!-- Single Fluid Image, No Crop : BEGIN 
                                    <tr>
                                      <td valign="top" align="center">
                                        <img src="images/c4.jpg" alt="alt text" height="" width="100%" align="center" border="0" style="margin: auto;" class="fluid">
                                      </td>
                                    </tr>
                                    Single Fluid Image, No Crop : END -->

                                    <!-- Full Width, Fluid Column : BEGIN -->
                                    <tr>
                                        <td style="padding: 4%; font-family: sans-serif; font-size: 15px; line-height: 1.3; color: #666666;">
                                            <!-- COPY -->
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td align="left" style="padding: 0px 0 0 0; font-size: 14px; line-height: 20px; font-family: sans-serif; color: #666666;" class="padding-copy">
                                                        {{ Illuminate\Mail\Markdown::parse($slot) }}

                                                        {{ $subcopy or '' }}    
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <!-- Full Width, Fluid Column : END -->

                                </table>
                                <!-- Main Email Body : END -->

                            </td>
                        </tr>

                        <!-- Footer : BEGIN -->
                        {{ $footer or '' }}
                        <!-- Footer : END -->

                    </table>
                    <!-- Email wrapper : END -->

                </td>
            </tr>
        </table>
    </body>
</html>
