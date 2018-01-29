<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 23.01.2018
 * Time: 09:13
 */
require "vendor/autoload.php";

$flag1 = new \HTL3R\Flags\Flags\RectangleFlag("London", 453, 6, 5, "blue", "UG"
);
$flag2 = new \HTL3R\Flags\Flags\RectangleFlag("Siebenburgen", 24.5, 2.0, 0.5, "#FFC8AB", "AL");

$flag3 = new \HTL3R\Flags\Flags\RectangleFlag("Astachan", 234, 4, 4, "green", "DZ"
);

if(isset($_GET['format'])){
    if($_GET['format'] == "json"){
        header("Content-Type: application/json");
        echo outputJSON($flag1, $flag2, $flag3);
    }else{
        echo outputHTML($flag1, $flag2, $flag3);
    }
}else{
    echo outputHTML($flag1, $flag2, $flag3);
}

function outputJSON($flag1, $flag2, $flag3) : string{
    $someArray = [
        [
            "name"   => $flag1->getName(),
            "price" => $flag1->getPrice(),
            "width" => $flag1->getWidth(),
            "height" => $flag1->getHeight(),
            "color" => $flag1->getColor(),
            "Lc" => $flag1->getLc()
        ],
        [
            "name"   => $flag2->getName(),
            "price" => $flag2->getPrice(),
            "width" => $flag2->getWidth(),
            "height" => $flag2->getHeight(),
            "color" => $flag2->getColor(),
            "Lc" => $flag2->getLc()
        ],
        [
            "name"   => $flag3->getName(),
            "price" => $flag3->getPrice(),
            "width" => $flag3->getWidth(),
            "height" => $flag3->getHeight(),
            "color" => $flag3->getColor(),
            "Lc" => $flag3->getLc()
        ]
    ];
    $someJSON = json_encode($someArray);
    return $someJSON;
    //return "{ \"name\":\"" . $flag1->getName() . "\" }";
}

function outputHTML($flag, $flag2, $flag3): string
{
    $valuesArray = [
        "flag1" => $flag,
        "flag2" => $flag2,
        "flag3" => $flag3
    ];

    // Initializing the View: rendering in Fluid takes place through a View instance
    // which contains a RenderingContext that in turn contains things like definitions
    // of template paths, instances of variable containers and similar.
    $view = new \TYPO3Fluid\Fluid\View\TemplateView();

    // TemplatePaths object: a subclass can be used if custom resolving is wanted.
    $paths = $view->getTemplatePaths();

    // Assigning the template path and filename to be rendered. Doing this overrides
    // resolving normally done by the TemplatePaths and directly renders this file.
    $paths->setTemplatePathAndFilename(__DIR__ . '/templates/Flaglisting.html');

    $view->assignMultiple($valuesArray);

    // Rendering the View: plain old rendering of single file, no bells and whistles.
    $output = $view->render();

    return $output;
}