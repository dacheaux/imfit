<?php

namespace App\Traits;

use DateTimeInterface;

trait SerializesDates
{
    /**
     * Keep Laravel 6 date JSON format (Y-m-d H:i:s) instead of ISO-8601.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
