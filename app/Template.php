<?php
namespace App;
use JetBrains\PhpStorm\NoReturn;

class Template
{
     public \Twig\Environment $twig;
    #[NoReturn] public function __construct()
    {
        //load template engine
        try {
            $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../views');
            $this->twig = new \Twig\Environment($loader, [
                'cache' => __DIR__ . "/../cache/views",
                'debug' => true
            ]);
        }catch (\Exception $exception){
            die($exception->getMessage());
        }

    }
    public function load($template = 'customer.main') :  \Twig\TemplateWrapper
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
            return $template->render($data);
        }catch (\Exception $exception){
            die($exception->getMessage());
        }

    }

}