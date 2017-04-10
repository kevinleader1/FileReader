<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>FileReader</title>
        <meta name="description" content="FileReader with Laravel + View.js"/>

        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    </head>
    <body>
        <div id="app">
            <file-reader></file-reader>
        </div>
        <script>
            // Récupération du tableau json lors d'un premier chargement des fichiers et des dossiers
            var repository = {!! $repertory !!} ;
        </script>
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>