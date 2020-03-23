<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Slim3 VueJs Starter</title>

    <link rel="shortcut icon" href="favicon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <style>
        body {
            margin: 50px 0 5px 0;
            padding: 0;
            width: 100%;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            text-align: center;
            color: #aaa;
            font-size: 18px;
        }
        h1 {
            color: #719e40;
            letter-spacing: -3px;
            font-family: 'Lato', sans-serif;
            font-size: 100px;
            font-weight: 200;
            margin-bottom: 0;
        }
        p {
            margin-bottom: 30px;
        }
        footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            font-size: 14px;
            color: silver;
        }
        .btn { width: 220px; }
    </style>
</head>
<body>
    <h1>Slim3 Vue.js2</h1>
    <p>
        <strong>Starter Sample</strong>: Restful API, Twig, Bootstrap 3
    </p>
    <p>
        <a class="btn btn-primary" href="/frontend/dist" target="_blank">
            Slim3 + Vue.js [Front Office]
        </a>
    </p>
    <p>
        <a class="btn btn-primary" href="/backend/" target="_blank">
            Slim3 + Twig [Back Office]
        </a>
    </p>
    <footer>
        <p>Author: Vincseize 2019-<?= date('Y'); ?></p>
        <p>
            Back-office based on:
            <a href="https://github.com/sarfraznawaz2005/slim3-skeleton" target="_blank">
                github.com/sarfraznawaz2005/slim3-skeleton
            </a>
        </p>
    </footer>
</body>
</html>
