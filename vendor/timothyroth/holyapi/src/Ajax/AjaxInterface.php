<?php

namespace HolyApi\Ajax;

interface AjaxInterface
{
    public function register(array $requests): void;

    public function respond(array $response): void;
}