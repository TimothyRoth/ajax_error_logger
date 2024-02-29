<?php

namespace holyApi\Ajax\WordPress;

use holyApi\Ajax\AjaxInterface;
use app\App;
use JsonException;


class Ajax implements AjaxInterface
{

    public function register(array $requests): void
    {
        foreach ($requests as $client_hook => $method) {
            add_action("wp_ajax_{$client_hook}", function () use ($method) {
                $method[0]->{$method[1]}();
            });
            add_action("wp_ajax_nopriv_{$client_hook}", function () use ($method) {
                $method[0]->{$method[1]}();
            });
        }
    }

    /**
     * @throws JsonException
     */
    public function respond(array $response): void
    {
        wp_die(json_encode($response, JSON_THROW_ON_ERROR));
    }


}