<?php

namespace App\Traits;

trait DateTimeFormatTrait
{
    public function toArray()
    {
        $array = parent::toArray();

        foreach ($this->getDates() as $date) {
            if (isset($array[$date])) {
                $array[$date] = $this->$date->setTimezone('America/Belem')->toDateTimeString();
            }
        }

        return $array;
    }
}
