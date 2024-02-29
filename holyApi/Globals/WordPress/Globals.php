<?php

namespace holyApi\Globals\WordPress;

use holyApi\Globals\GlobalsInterface;

class Globals implements GlobalsInterface
{
    public function getPageID(): int
    {
        return get_the_ID();
    }

}