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
        'payment_canceled' => 'Đơn hàng đã hủy',
        'payment_failed'   => 'Thanh toán đơn hàng bị lỗi',
        'payment_success'  => 'Thanh toán Đơn hàng thành công',
    ],
];
