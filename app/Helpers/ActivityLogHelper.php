<?php

namespace App\Helpers;

class ActivityLogHelper
{
    public static function getActivityBadgeColor($action)
    {
        $colors = [
            'create' => 'green',
            'update' => 'yellow',
            'delete' => 'red',
            'restore' => 'blue',
            'login' => 'blue',
            'logout' => 'gray',
            'failed_login' => 'red',
            'stock_in' => 'green',
            'stock_out' => 'yellow',
            'payment_received' => 'green',
        ];

        return $colors[$action] ?? 'blue';
    }

    public static function getActivityIcon($action)
    {
        $icons = [
            'create' => 'plus',
            'update' => 'edit',
            'delete' => 'trash',
            'restore' => 'trash-restore',
            'login' => 'sign-in-alt',
            'logout' => 'sign-out-alt',
            'failed_login' => 'exclamation-triangle',
            'stock_in' => 'arrow-down',
            'stock_out' => 'arrow-up',
            'payment_received' => 'dollar-sign',
        ];

        return $icons[$action] ?? 'info-circle';
    }
}
