<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PROGECT NAME</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            background-size: 300% 300%;
            /*background-image: linear-gradient(-45deg, yellow 0%, yellow 25%, yellow 51%, #ff357f 100%);*/
            /*background-image: linear-gradient(-45deg, rgb(255,255,0), rgb(255,53,127));*/
            background-image: linear-gradient(-45deg, rgb(255,255,0), rgb(255, 174, 53));
            -webkit-animation: AnimateBG 20s ease infinite;
            animation: AnimateBG 20s ease infinite;
        }

        header {
            height: 100px;
            display: flex;
        }

        h1 {
            margin: auto;
        }

        main {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
        }

        .content {
            margin: 100px;
            /*background-color: rgba(255,255,255,0.3);*/
        }

        .content p {
            width: 100%;
            height: 100px;
        }

        @-webkit-keyframes AnimateBG {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes AnimateBG {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>PROGECT NAME</h1>
    </header>
    <main>
        <div class="content">
            <p>Людоед поймал туристов: "На первое-второе, рассчитайсь!".</p>
        </div>
    </main>
</body>
</html>
