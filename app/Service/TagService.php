<?php

namespace App\Service;

class TagService
{
    public function randomColor(): string
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }
}
