<?php
namespace App;
use JetBrains\PhpStorm\NoReturn;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TemplateWrapper;

class Template
{
     public Environment $twig;
    #[NoReturn] public function __construct()
    {
        //load template engine
        try {
            $loader = new FilesystemLoader(__DIR__ . '/../views');
            $this->twig = new Environment($loader, [
                'cache' => __DIR__ . "/../cache/views",
                'debug' => true
            ]);
            $this->twig->addGlobal('session', $_SESSION);
        }catch (\Exception $exception){
            die($exception->getMessage());
        }

    }
    public function load($template = 'customer.main') :  TemplateWrapper
    {
        $GLOBALS['twig'] = $this->twig;
        $file = str_replace('.',"/",$template);
        return $this->twig->load($file.'.twig');
    }
    public static function view($view, array $data = []): string
    {
        $class = new self;
        try {
            $template = $class->load($view);
            $output = $template->render($data);
            $_SESSION['errors'] = [];
            $_SESSION['success'] = [];
            return  $output;
        }catch (\Exception $exception){
            die($exception->getMessage());
        }

    }

}