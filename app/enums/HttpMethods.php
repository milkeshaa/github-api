<?php

namespace App\Enums;

enum HttpMethods: string
{
    case POST = 'post';
    case DELETE = 'delete';
    case GET = 'get';
}