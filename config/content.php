<?php
return [
    /**
     * Tự động add các route
     */
    'add_route'   => true,
    /**
     * Khai báo middlewares cho các Controller
     */
    'middlewares' => [
        'frontend' => null,
        'backend'  => 'admin',
    ],
];
