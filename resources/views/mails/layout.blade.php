<!DOCTYPE html>

<html lang="{{ \str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">

</head>

<body style="margin-top: 0; margin-right: 0; margin-bottom: 0; margin-left: 0;padding-top: 0; padding-right: 0; padding-bottom: 0; padding-left: 0;
        font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif;">
    <table width="100%" border="0" cellspacing="10" cellpadding="0">
        <tr>
            <td align="center" valign="top" style="text-align:center; color: #555555;">
                <table border="0" cellspacing="0" cellpadding="0" style="margin-left: auto; margin-right: auto; background-color: #FCFCFC;" width="600">
                    <tr>
                        <!-- body content -->
                        <td align="center" valign="top" style="text-align: center; padding: 36px 66px 85px;">
                            @yield('content')
                        </td>
                    </tr>
                </table>
                <!-- footer -->
                <table border="0" cellspacing="0" cellpadding="0" style="margin-left: auto; margin-right: auto; background-color: #EEEEEE;" width="600">
                    <tr>
                        <td align="center" valign="top" style="text-align: center; padding: 36px 66px;">
                            @include('mails.components.footer')
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>