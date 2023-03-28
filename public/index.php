<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Src\Models\Anekdot;

$anekdot = new Anekdot();
$top10 = $anekdot->getTop();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PROJECT NAME</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: "Comic Sans MS", cursive, sans-serif;
        }

        body {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            background-size: 300% 300%;
            background-image: linear-gradient(-45deg, rgb(255,255,0), rgb(255, 174, 53));
            -webkit-animation: AnimateBG 10s ease infinite;
            animation: AnimateBG 10s ease infinite;
        }

        header {
            display: flex;
        }

        h1 {
            margin: auto;
            padding: 20px;
        }

        h3 {
            padding: 20px 0 40px;
        }

        main {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .content {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            row-gap: 20px;
        }

        .content p {
            max-width: 800px;
            height: fit-content;
            padding: 20px;
            border-radius: 20px;
            background-color: rgba(255, 255, 255, 0.3);
            margin: 0 5px;
            font-size: 21px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.6);
        }

        footer > p {
            margin: 100px;
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
        <h1>PROJECT NAME</h1>
    </header>
    <main>
        <div class="header">
            <h3>Топ-10 анекдотов:</h3>
        </div>
        <div class="content">
            <?php
                foreach ($top10 as $text) {
                    echo "<p>{$text}</p>";
                }
            ?>
        </div>
    </main>
    <footer>
        <p>Footer</p>
    </footer>
</body>
</html>
