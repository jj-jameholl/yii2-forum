<?php
return [
    'edit' => [
        'type' => 2,
        'description' => '编辑文章',
    ],
    'delete' => [
        'type' => 2,
        'description' => '删除文章',
    ],
    'admin' => [
        'type' => 1,
        'description' => '管理员',
        'children' => [
            'edit',
            'delete',
        ],
    ],
    'edit_self' => [
        'type' => 2,
        'description' => '编辑自己的文章',
        'ruleName' => 'isAuthor',
        'children' => [
            'edit',
        ],
    ],
    'delete_self' => [
        'type' => 2,
        'description' => '删除自己的文章',
        'ruleName' => 'isAuthor',
        'children' => [
            'delete',
        ],
    ],
    'author' => [
        'type' => 1,
        'description' => '作者',
        'children' => [
            'delete_self',
            'edit_self',
        ],
    ],
];
