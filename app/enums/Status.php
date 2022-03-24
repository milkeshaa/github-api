<?php

namespace App\Enums;

enum Status: string
{
    case FAILURE = 'failure';
    case SUCCESS = 'success';
}