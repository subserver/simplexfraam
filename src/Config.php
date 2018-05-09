<?php namespace SimplexFraam;

class Config
{
    /**
     * @var \PHLAK\Config\Config
     */
    public static $config;

    /**
     * @var string
     */
    public static $simplexFraamConfig = __DIR__ . "/../settings/simplexFraam.config.json";
    public static $errorMessages = __DIR__ . "/../settings/errorMessages.json";
    public static $userConfig = __DIR__ . "/../settings/config.json";

    public function __construct(array $configArray, $configFilePath = null)
    {
        parent::__construct($configArray, $configFilePath);
    }

    /**
     * Get configuration setting.
     *
     * @param $path
     *
     * @return mixed
     */
    public static function get($path){
        self::checkConfig();
        return self::$config->get($path);
    }

    /**
     * Check if config item is set.
     *
     * @param $path
     *
     * @return bool
     */
    public static function has($path){
        self::checkConfig();
        return self::$config->has($path);
    }

    /**
     * Set a configuration setting.
     *
     * @param $path
     * @param $value
     *
     * @return object
     */
    public static function set($path, $value){
        self::checkConfig();
        return self::$config->set($path, $value);
    }

    /**
     * Check that the config is loaded.
     * If not loaded, then loads it.
     */
    private static function checkConfig(){
        if(!self::$config){
            self::load();
        }
    }

    /**
     * Load the config.
     *
     * @throws \PHLAK\Config\Exceptions\InvalidContextException
     */
    public static function load(){
        self::$config = new \PHLAK\Config\Config(self::$simplexFraamConfig);
        self::$config->load(self::$errorMessages, $prefix = null, $override = true);
        self::$config->load(self::$userConfig, $prefix = null, $override = true);
    }

    /**
     * Save config to disk.
     */
    public static function save(){
        file_put_contents(self::$userConfig, json_encode(self::$config, JSON_PRETTY_PRINT));
    }

    public static function loadConfigFile($path, $override = false){
        if(!self::$config){
            self::load();
        }
        self::$config->load($path, $override);
    }
}
