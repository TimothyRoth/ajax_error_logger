<?php

namespace HolyApi\Url;

interface UrlInterface
{
    public function getBasepath(string $path = ''): string;

    public function getAdminBasepath(string $path = ''): string;

    public function getTemplateUrl(string $path = ''): string;
}