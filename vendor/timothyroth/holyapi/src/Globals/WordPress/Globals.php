<?php

namespace HolyApi\Globals\WordPress;

use HolyApi\Globals\GlobalsInterface;

class Globals implements GlobalsInterface
{
    public function getPageID(): int
    {
        return get_the_ID();
    }

}