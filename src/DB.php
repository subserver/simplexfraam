<?php namespace SimplexFraam;

/**
 * Class DB
 * @package SimplexFraam
 *
 * Wrapper for LessSL instance.
 */
class DB
{
    private static $pdo = null;
    private static $lessql = null;
    private static $setupLambdas = [];

    public static function getInstance(){
        if (!self::$pdo || !self::$lessql) {
            self::$pdo = new \PDO("mysql:host=" . Config::get("db.host") . ";dbname=" . Config::get("db.name") . ";charset=" . Config::get("db.charset") . "", Config::get("db.user"), Config::get("db.pass"));
            self::$lessql = new \LessQL\Database(self::$pdo);

            foreach(self::$setupLambdas as $toExecute){
                call_user_func_array($toExecute, [&self::$lessql]);
            }
        }

        return self::$lessql;
    }

    /**
     * Add a setup lambda to the DB class. Called immediately after the lessql instance is made.
     *
     * @param $callable
     * @throws \Exception
     */
    public static function attachStatupLambda($callable){
        if(!is_callable($callable)){
            throw new \Exception("Passed non-callable lambda to SimplexFraam\\DB setup");
        }
        self::$setupLambdas[] = $callable;
    }
}