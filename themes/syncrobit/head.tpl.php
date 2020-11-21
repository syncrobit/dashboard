<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Helium HotSpot Manager" name="description" />
    <meta content="Georgica" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <title>{{SB_CORE::getSetting(app_name)}}</title>

    <link rel="shortcut icon" href="{{SB_THEME::getResourcesImage(favicon.ico)}}">

    <link href="{{SB_THEME::getResourceCSS(bootstrap.min.css)}}" rel="stylesheet" type="text/css" />
    <link href="{{SB_THEME::getResourceCSS(icons.css)}}" rel="stylesheet" type="text/css" />
    <link href="{{SB_THEME::getResourceCSS(select2.min.css)}}" rel="stylesheet" type="text/css" />
    <link href="{{SB_THEME::getResourceCSS(fonts.css)}}" rel="stylesheet" type="text/css" />
    <link href="{{SB_THEME::getResourceCSS(jnoty.min.css)}}" rel="stylesheet" type="text/css" />
    {{SB_THEME::getDynmaicCSS(<?=$_GET['page'];?>)}}
    
    <link href="{{SB_THEME::getResourceCSS(style.css)}}" rel="stylesheet" type="text/css" />

    <script type="text/javascript"> var baseUri = '/ajax/'; </script>

</head>


<body class="fixed-left">
