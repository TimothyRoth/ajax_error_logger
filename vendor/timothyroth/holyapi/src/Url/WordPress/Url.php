<?php

namespace HolyApi\Url\WordPress;

use HolyApi\Url\UrlInterface;

class Url implements UrlInterface
{

    public function getBasepath(string $path = ''): string
    {
        return home_url($path);
    }

    public function getAdminBasepath(string $path = ''): string
    {
        return admin_url($path);
    }

    public function getTemplateUrl(string $path = ''): string
    {
        return get_template_directory_uri($path);
    }


}