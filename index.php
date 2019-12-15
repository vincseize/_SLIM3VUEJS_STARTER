<!DOCTYPE html>
<html lang="fr">
    <head>     
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- first -->
        <link href='frontend/public/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
        <!-- second -->
        <link href='frontend/public/css/styles_home.css' rel='stylesheet' type='text/css'>
        <link rel="shortcut icon" href="frontend/public/img/favicon.png">
        <script src='frontend/public/js/jquery.min.js'></script>
        <title>Slim3 Starter</title>
    </head>
<body>
    <h1>Slim3</h1>
    <div>a microframework for PHP</div>
    <p>&nbsp;</p>
    <div><b>Starter Sample</b>  : restful API, CRUD, twig, Bootstrap, Vuejs</div>
    <p>&nbsp;</p>
    <input type="button" id="go_frontend" name="go_frontend"  
        class="btn btn-primary" 
        value="Slim3 VueJs[frontend]"
    >
    <p>&nbsp;</p>
    <input type="button" id="go_backend" name="go_backend"  
        class="btn btn-primary" 
        value="Slim3 [backend]"
    >
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <div>Author: Vincseize 2019</div>
    <div>Based on: https://github.com/sarfraznawaz2005/slim3-skeleton</div>
</body>
</html>

<script>
$(document).ready(function(){
    $('#go_frontend').click(function(){
        url = 'frontend/public/';
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