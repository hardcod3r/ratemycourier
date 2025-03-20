<?php
use Illuminate\Support\Facades\Hash;
return [
    'users' => [
        [
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password',
        ],
        [
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => 'password',
        ],
    ],
    'wrong_password' => 'wrong_password',
    'couriers' => [
        ['name' => 'DHL Express', 'description' => 'Fast delivery service'],
        ['name' => 'FedEx', 'description' => 'Reliable and cheap'],
        ['name' => 'UPS', 'description' => 'Best customer support'],
        ['name' => 'TNT', 'description' => 'Eco-friendly service'],
        ['name' => 'Aramex', 'description' => 'Express worldwide shipping'],
        ['name' => 'DPD', 'description' => 'Affordable prices'],
        ['name' => 'GLS', 'description' => '24/7 customer support'],
        ['name' => 'Hermes', 'description' => 'Quick and safe delivery'],
        ['name' => 'Royal Mail', 'description' => 'Local and international shipping'],
        ['name' => 'Chronopost', 'description' => 'High-quality service'],
    ],
    'per_page' => 5,
];
