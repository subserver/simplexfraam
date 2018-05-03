<?php namespace SimplexFraam;

class Response extends \Symfony\Component\HttpFoundation\Response
{
    const RESPONSE_HTML = "html";
    const RESPONSE_JSON = "json";

    public $error = false;
    public $resposeFormat = self::RESPONSE_HTML;
    public $context = [];
    public $template = false;
    public $request = null;

    public function __construct($content = '', $status = 200, array $headers = array())
    {
        parent::__construct($content, $status, $headers);
        $this->template = Config::get("template.default");
    }

    public function error(Error $error){
        $this->error = $error;
        $this->setStatusCode($error->getResponseCode());
        $this->assign("error", $error);
        $this->template("error");
        return $this;
    }

    public static function sendTo($route, $context = []){
        return self::redirect(Router::generate($route, $context));
    }

    public static function redirect($url){
        return new \Symfony\Component\HttpFoundation\RedirectResponse($url);
    }

    public function setResponseFormat($format){
        $this->resposeFormat = $format;
    }

    public function generate(){
        if($this->resposeFormat == self::RESPONSE_HTML){
            $this->setContent(Template::render($this->template, $this->context));
        } elseif ($this->resposeFormat == self::RESPONSE_JSON){
            $this->setContent(json_encode($this->context));
        }
    }

    /**
     * @param $request
     *
     * @return Response $this
     */
    public function forRequest($request){
        $this->request = $request;
        return $this;
    }

    public function send($liveOn = false)
    {
        $this->generate();
        if($this->request){
            $this->prepare($this->request);
        }
        $r = parent::send();
        if($liveOn){
            return $r;
        } else {
            exit("\n");
        }
    }

    public function assign($key, $value){
        $this->context[$key] = $value;
    }

    public function template($templateName){
        $this->template = $templateName;
    }

}
