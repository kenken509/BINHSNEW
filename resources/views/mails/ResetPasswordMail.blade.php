<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESET PASSWORD</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
        }

        .header {
            text-align: justify;
            padding-bottom: 20px;
            border-bottom:1px solid gray;
            margin-top:30px
        }

        .header a {
            font-size: 1.4em;
            color: #00466a;
            text-decoration: none;
            font-weight: 600;
        }

        .otp-box {
            background: #00466a;
            text-align: center;
            color: #fff;
            border-radius: 4px;
            margin: 0 auto;
            width: max-content;
            padding: 0 10px;
            font-size: 2em;
            margin-top: 20px;
        }

        .message {
            
            font-size: 1.1em;
            padding: 20px 0;
            text-align: justify; /* Added left alignment */
        }

        .footer {
            text-align: justify;
            padding-top: 20px;
        }

        .footer p {
            font-size: 0.8em;
            color: #aaa;
            font-weight: 300;
        }

        .reset-link{
            display:flex;
            justify-content: center;
            align-items: center;
            color:white !important;
            text-decoration:none;
            font-size:20px;
            padding:3px;
        }
        .regards{
            margin-top:30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="#">BINHS.NET</a>
        </div>
        <div class="message">
            <p>Hi,</p>
            <p>Please click the button below to reset your password.</p>
            <div class="otp-box">
                <a class="reset-link" target="_blank" href="{{$mailData['url']}}" >Click here to reset password</a>
            </div>
            
            <p class="regards">Regards,<br />Bulihan Integrated High School</p>
        </div>
        <hr>
        <div class="footer">
            <p>BINHS</p>
            <p>Old Bulihan Rd, Silang, 4118 Cavite</p>
            <p>Philippines</p>
        </div>
    </div>


</body>
</html>
