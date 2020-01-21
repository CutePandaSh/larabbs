<?php

use App\Models\Category;

return [
    'title' => '分类',
    'single' => '分类',
    'model' => Category::class,

    'action_permissions' => [
        'delete' => function () {
            return Auth::user()->hasRole('Founder');
        },
    ],

    'columns' => [
        'id' => [
            'title' => 'ID',
        ],

        'name' => [
            'title' => '名称',
            'sortable' => false,
        ],

        'description' => [
            'title' => '描述',
            'sortable' => false,
        ],

        'operation' => [
            'title' => '管理',
            'sortable' => false,
        ],
    ],

    'edit_fields' => [
        'name' => [
            'title' => '名称'
        ],

        'description' => [
            'title' => '描述',
            'type' => 'textarea',
        ],
    ],

    'filters' => [
        'id' => [
            'title' => '分类 ID',
        ],
        'name' => [
            'title' => '名称',
        ],
        'description' => [
            'title' => '描述'
        ],
    ],

    'rules' => [
        'name' => 'required|min:1|unique:categories,name'
    ],

    'messages' => [
        'name.unique' => '分类名在数据库中有重复，请使用其他名称',
        'name.min'    => '请确保名字至少一个字符以上'
    ],
];
