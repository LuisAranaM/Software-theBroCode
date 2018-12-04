<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>Rubrik 404</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" href="{{ URL::asset('img/logo.png') }}">       
    <link href="https://fonts.googleapis.com/css?family=Catamaran" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://secure.surveymonkey.com/css/404br.css?rv=201712121119" media="all" />

</head>

<body>
    <div class="wrapper">

        <div class="error-message-wrapper">
            <h1 class="wds-type--page-title">¡Lo sentimos!</h1>
            <div class="error-message-container">
                <h2 class="wds-type--section-title">
                    No podemos encontrar la página que buscas.
                </h2>
                <p>
                    Verifica que la URL que ingresaste esté bien escrita. <br /> ¿Aún no sabes cómo llegar a la página que quieres? Tal vez podamos ayudarte:
                </p>

                <a href="/" class="error__logo">
                    <img src="{{ URL::asset('img/logo2.png') }}" alt="Logo Rubrik" />
                </a>


                
                <a href="{{route('login.index')}}" class="wds-button wds-button--upgrade wds-button--cta shadow">
                    Regresa a RubriK<span></span>
                </a>

            </div>
        </div>

    </div>
    <!-- 48  -->
</body>

</html>