<?php

    require_once __DIR__.'/vendor/autoload.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader, []);

    if(!file_exists('/input/config.json'))
    {
        throw new \InvalidArgumentException('config.json not found');
    }

    $config = json_decode(file_get_contents('/input/config.json'), true);

    //@TODO add checks for json schema (validate files are set, etc)

    $bannerPath = "/input/".$config['banner']['filename'];
    $logoPath = "/input/".$config['logo']['filename'];
    $iconPath = "/input/".$config['icon']['filename'];

    if(!file_exists($bannerPath)){
        throw new \InvalidArgumentException('banner image not provided.');
    }

    if(!file_exists($logoPath)){
        throw new \InvalidArgumentException('logo image not provided.');
    }

    if(!file_exists($iconPath)){
        throw new \InvalidArgumentException('icon image not provided.');
    }

    $banner = list($width, $height, $type, $attr) = getimagesize($bannerPath);
    $logo = list($width, $height, $type, $attr) = getimagesize($logoPath);
    $icon = list($width, $height, $type, $attr) = getimagesize($iconPath);


    $document = $config['document'];

    $svg = $twig->render('binder.twig', [
        'document' => $document,
        'images' => [
            'banner' => [
                "source" => "data:{$banner['mime']};charset=utf-8;base64,".base64_encode(file_get_contents($bannerPath)),
                "y" => $config['banner']['y']
            ],
            'logo' => [
                "source" => "data:{$logo['mime']};charset=utf-8;base64,".base64_encode(file_get_contents($logoPath)),
                "width" => $document['width'] * 0.2
            ],
            'icon' => [
                "source" => "data:{$icon['mime']};charset=utf-8;base64,".base64_encode(file_get_contents($iconPath)),
                "x" => $document['width'] * 0.91,
                "y" => 35,
                "width" => $document['height'] * 0.79
            ],
        ],
        "label" => [
            "text" => $config['label']['text'],
            "x" => $document['width'] * 0.97,
            "y" => ($document['height'] - 10)
        ]
    ]);

    file_put_contents('/output/image.svg', $svg);
    echo "Image saved to /output/image.svg";

//    echo $twig->render('index.twig', [
//        'image'=>$svg
//    ]);