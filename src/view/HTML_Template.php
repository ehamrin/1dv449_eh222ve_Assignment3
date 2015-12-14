<?php


namespace view;


class HTML_Template
{
    public function Render($body){
        return <<<HTML
<head>
    <meta charset="utf-8">

    <title>Assignment 3</title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <meta name="author" content="Erik Hamrin">
    <meta name="viewport" content="width=device-width, initial-scale=1,  maximum-scale=1.0, user-scalable=false">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/styles.css?v=1.1">
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.css" />

</head>
<body>
<main>
    {$body}
</main>
<script src="/scripts/jquery.js"></script>
<script src="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.js"></script>
<script type="text/javascript" src="/scripts/scripts.js"></script>
</body>
</html>
HTML;

    }
}