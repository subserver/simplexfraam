<?php namespace SimplexFraam;

class Template
{

    /**
     * @var \Twig_Loader_Filesystem
     */
    public static $loader = null;

    /**
     * @var \Twig_Environment
     */
    public static $twig = null;

    /**
     * Initialise the twig instance if it is not already.
     *
     * @return \Twig_Environment|\Twig_Environment
     */
    public static function init(){
        if(!self::$loader | !self::$twig){
            self::$loader = new \Twig_Loader_Filesystem(__DIR__ . "/../app/templates");
            self::$twig = new \Twig_Environment(self::$loader, array(
                '.cache' => __DIR__ . "/../.cache/twig",
                'debug' => Config::get("debug")
            ));

            if(Config::get("debug")){
                self::$twig->addExtension(new \Twig_Extension_Debug());
            }

            self::$twig->addFunction(new \Twig_SimpleFunction("generate_url", function($routeName, $context = [], $params = []){
                return Router::generate($routeName, $context, $params);
            }));

            self::$twig->addFilter(new \Twig_SimpleFilter("preraw", function($input){
                return "<pre>" . $input . "</pre>";
            }, ['is_safe' => ['html']]));

            //add some global variables for twig.
            self::$twig->addGlobal("site", Config::get("site"));

        }
        return self::$twig;
    }

    /**
     * Get the twig instance.
     *
     * @return \Twig_Environment
     */
    public static function instance(){
        self::init();
        return self::$twig;
    }

    /**
     * @param $template string The template to render.
     * @param $context mixed The context to render with.
     *
     * @return string
     */
    public static function render($template, $context){
        self::init();
        return self::$twig->render($template . ".twig", $context);
    }


    /**
     * @param $twigFunction \Twig_Function The function to attach globally.
     */
    public static function attachGlobalFunction($twigFunction){
        self::$twig->addFunction($twigFunction);
    }

}
