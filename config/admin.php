<?php

return [
    //后台用户使用的用户认证配置
    'auth' => [
        'role_list' => [
            'admin',
        ],
    ],

    //   | 在Form表单中的image和file类型的默认上传磁盘和目录设置，其中disk的配置会使用在
    //    | config/filesystem.php里面配置的一项disk
    'upload' => [

        // Disk in `config/filesystem.php`.
        'disk' => 'admin',

        // Image and file upload path under the disk above.
        'directory' => [
            'image' => 'images',
            'file' => 'files',
        ],
    ],


    'operation_log' => [

        // 是否开启日志记录、默认打开
        'enable' => true,

        /*
         * 允许记录请求日志的HTTP方法
         */
        'allowed_methods' => ['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH'],

        /*
         * 不需要被记录日志的url路径
         */
        'except' => [
            '/admin/upload'
        ],
    ],
];
