<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 23.01.2018
 * Time: 09:13
 */
require "vendor/autoload.php";

$flag1 = new \HTL3R\Flags\Flags\RectangleFlag("Uganda", 453, 6, 5, "yellow", "ug"
);
$flag2 = new \HTL3R\Flags\Flags\RectangleFlag("Algerien", 24.5, 2.0, 0.5, "green", "al");

$flag3 = new \HTL3R\Flags\Flags\RectangleFlag("Österreich", 2364, 4, 4, "red", "at"
);

$flagArray = [
    "flag1" => $flag1,
    "flag2" => $flag2,
    "flag3" => $flag3
];

if(isset($_GET['format'])){
    if($_GET['format'] == "json"){
        header("Content-Type: application/json");
        echo outputJSON($flagArray);
    }else{
        echo outputHTML($flagArray);
    }
}else{
    echo outputHTML($flagArray);
}

function outputJSON($flagArray) : string{
    $array = array();
    foreach ($flagArray as $flags) {
        $array[] = [
            "name" => $flags->getName(),
            "price" => $flags->getPrice(),
            "width" => $flags->getWidth(),
            "height" => $flags->getHeight(),
            "color" => $flags->getColor(),
            "lc" => $flags->getLc()
        ];
    }

    $someJSON = json_encode($array);
    return $someJSON;
    //return "{ \"name\":\"" . $flag1->getName() . "\" }";
}

function outputHTML($flagArray): string
{

    // Initializing the View: rendering in Fluid takes place through a View instance
    // which contains a RenderingContext that in turn contains things like definitions
    // of template paths, instances of variable containers and similar.
    $view = new \TYPO3Fluid\Fluid\View\TemplateView();

    // TemplatePaths object: a subclass can be used if custom resolving is wanted.
    $paths = $view->getTemplatePaths();

    // Assigning the template path and filename to be rendered. Doing this overrides
    // resolving normally done by the TemplatePaths and directly renders this file.
    $paths->setTemplatePathAndFilename(__DIR__ . '/templates/Flaglisting.html');

    $view->assignMultiple($flagArray);

    // Rendering the View: plain old rendering of single file, no bells and whistles.
    $output = $view->render();

    return $output;
}