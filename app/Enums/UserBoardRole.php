<?php

namespace App\Enums;

enum UserBoardRole:string
{
    case Owner = 'owner';
    case Member = 'member';
}
