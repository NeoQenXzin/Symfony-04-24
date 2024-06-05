<?php

namespace App\Entity\Enum;

enum CommentStateEnum: string
{
    case Submitted = 'submitted';
    case Spam = 'spam';
    case Published = 'published';
}
