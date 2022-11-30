<?php use App\Models\User as User;

return [
    'general' => [
        'users.show' => [
            'type' => [User::MEMBER, User::REUNIST],
            ],
        ],
    ];