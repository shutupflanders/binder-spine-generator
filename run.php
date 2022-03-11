<?php

    require_once __DIR__.'/vendor/autoload.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader, [
    ]);

    $svg = $twig->render('binder.twig', [
        'width'=>"3508",
        'height'=>"295",
        'banner' => 'sword-shield-brilliant-stars-banner-arceus.jpg',
        'logo' => 'sword-shield-brilliant-stars-logo.png',
        'icon' => 'sword-shield-brilliant-stars-icon.png',
        'set_logo_y' => "-415",
        'set_name' => 'SWSH09'
    ]);

    file_put_contents('image.svg', $svg);

    echo $twig->render('index.twig', [
        'image'=>$svg
    ]);