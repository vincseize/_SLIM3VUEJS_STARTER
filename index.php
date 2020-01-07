<!DOCTYPE html>
<html lang="fr">
    <head>     
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Slim3 VueJs Starter</title>
        <script src="https://code.jquery.com/jquery-3.1.1.js"
                integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA="
                crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <style>
            body {
                margin: 50px 0 0 0;
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
        </style>
    </head>
<body style="margin-bottom:5px;">
    <h1>Slim3 Vuejs2</h1>
    <div>a microframework for PHP</div>
    <p>&nbsp;</p>
    <div><b>Starter Sample</b> : Restful API, twig, bootstrap3</div>
    <p>&nbsp;</p>
    <input type="button" id="go_frontend" name="go_frontend"  
        class="btn btn-primary" 
        value="Slim3 VueJs [frontend]" 
        style="width:180px;" 
    >
    <p>&nbsp;</p>
    <input type="button" id="go_backend" name="go_backend"  
        class="btn btn-primary" 
        value="Slim3 twig [backend]" 
        style="width:180px;" 
    >
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <div style="position:absolute;bottom:0;width:100%;">
        <div>Author: Vincseize 2019</div>
        <div>Backend based on: https://github.com/sarfraznawaz2005/slim3-skeleton</div>
    </div>
</body>
</html>

<script>
$(document).ready(function(){
    $('#go_frontend').click(function(){
        // url = 'frontend/public/';
        url = 'frontend/dist/';
        window.open(''+url+'','_blank');
    });
    $('#go_backend').click(function(){
        url = 'backend/public';
        window.open(''+url+'','_blank');
    });
});
</script>












</body>
</html>