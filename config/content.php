<?php
return [
    /**
     * Tự động add các route
     */
    'add_route'    => true,
    /**
     * Khai báo middlewares cho các Controller, KHÔNG CÓ ghi []
     */
    'middlewares'  => [
        'frontend' => [],
        'backend'  => 'role:admin',
    ],
    'guarded_item' => [
        'contact-us'       => 'Liên hệ',
        'terms-conditions' => 'Điều khoản & Điều kiện',
        'order-success'    => 'Đặt hàng thành công',
    ],
];
