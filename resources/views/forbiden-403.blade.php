<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Service System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <style>
        *,
        *:before,
        *:after {
            box-sizing: border-box;
        }

        html {
            height: 100%;
        }

        body {
            font-family: 'Raleway', sans-serif;
            background-color: #16a5cd;
            height: 100%;
            padding: 10px;
        }

        a {
            color: #FFFFFF !important;
            text-decoration: none;
        }

        a:hover {
            color: #054b9c !important;
            text-decoration: none;
        }

        .text-wrapper {
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .title {
            font-size: 5em;
            font-weight: 700;
            color: #ffffff;
        }

        .subtitle {
            font-size: 26px;
            font-weight: 700;
            color: #fdfdfd;
        }

        .isi {
            font-size: 18px;
            text-align: center;
            margin: 30px;
            padding: 20px;
            color: white;
        }

        .buttons {
            margin: 30px;
            font-weight: 700;
            border: 2px solid #003e9b;
            text-decoration: none;
            padding: 15px;
            text-transform: uppercase;
            color: #003e9b;
            border-radius: 26px;
            transition: all 0.2s ease-in-out;
            display: inline-block;

            .buttons:hover {
                background-color: #003e9b;
                color: white;
                transition: all 0.2s ease-in-out;
            }
        }

        .footer {
            font-size: 15px;
            font-weight: 600;
            color: #fdfdfd;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="text-wrapper">
        <div class="title" data-content="404">
            403 - ACCESS DENIED
        </div>
        <p class="subtitle">You don't have permission to access the resource.</p>
        <div class="buttons">
            <a class="button" href="{{ route('dashboard') }}">Go to homepage</a>
        </div>
        <div class="footer">
            &copy 2024 Lab Service System -
            By Zekindo Chemicals
        </div>
    </div>

</body>

</html>
