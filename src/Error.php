<?php namespace SimplexFraam;

/**
 * Class Error
 *
 * @package SimplexFraam
 */
class Error
{
    use MagicCollector;
    protected $responeCode, $errorMessage;

    public function __construct($responseCode = 500, $errorMessage = "")
    {
        $this->responeCode = $responseCode;

        //If no error message, then try load a default error message.
        if (empty($errorMessage)) {
            $key = "error.message." . $responseCode;
            if (Config::has($key)) {
                $errorMessage = Config::get($key);
            }
        }
        $this->errorMessage = $errorMessage;
    }

    /**
     * Convert error to string.
     *
     * @return string
     */
    public function __toString()
    {
        return "Error: " . $this->responeCode . " (" . $this->errorMessage
            . ")";
    }

    /**
     * Generate JSON string from error.
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * Return assoc array representing error.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            "status" => $this->responeCode, "message" => $this->errorMessage
        ];
    }

    /**
     * Get Response Code
     *
     * @return int
     */
    public function getResponseCode(){
        return $this->responeCode;
    }

    /**
     * Get Error Message.
     *
     * @return mixed|string
     */
    public function getErrorMessage(){
        return $this->errorMessage;
    }

}
