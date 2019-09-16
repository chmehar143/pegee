@extends('layouts.mail')
@section('content')
<!-- Main Email Body : BEGIN -->
<table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#ffffff">

    <!-- Full Width, Fluid Column : BEGIN -->
    <tr>
        <td style="padding: 4%; font-family: sans-serif; font-size: 15px; line-height: 1.3; color: #666666;">
            <!-- COPY -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="left" style="padding: 0px 0 0 0; font-size: 14px; line-height: 20px; font-family: sans-serif; color: #666666;" class="padding-copy">You received a message from : {{ $name }}</td>
                </tr>
                <tr>
                    <td align="left" style="padding: 20px 0 0 0; font-size: 14px; line-height: 20px; font-family:sans-serif; color: #666666;" class="padding-copy">Email: {{ $email }}</td>
                </tr>
                <tr>
                    <td align="left" style="padding: 20px 0 0 0; font-size: 14px; line-height: 20px; font-family:  sans-serif; color: #666666;" class="padding-copy">Subject: {{ $subject }}</td>
                </tr>
                <tr>
                    <td align="left" style="padding: 20px 0 0 0; font-size: 14px; line-height: 20px; font-family: sans-serif; color: #666666;" class="padding-copy">Message: {{ $bodyMessage }}</td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- Full Width, Fluid Column : END -->

</table>
<!-- Main Email Body : END -->
@endsection