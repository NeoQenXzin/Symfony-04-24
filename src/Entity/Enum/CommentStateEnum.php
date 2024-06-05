<?php

namespace App\Entity\Enum;

enum CommentStateEnum: string
{
    case Submitted = 'submitted';
    case Ham = 'ham';
    case PotentialSpam = 'potential_spam';
    case Spam = 'spam';
    case Rejected = 'rejected';
    case Published = 'published';
}
