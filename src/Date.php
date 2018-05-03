<?php namespace SimplexFraam;

use DateTimeZone;

class Date extends \DateTime
{
    public function __construct($time = 'now', DateTimeZone $timezone = null)
    {
        parent::__construct($time, $timezone);
    }

    public function __toString()
    {
        return $this->format(Config::get("date.format"));
    }
}
