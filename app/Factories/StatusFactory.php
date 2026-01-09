<?php

namespace App\Factories;

class StatusFactory
{
    public static function getBadge($status)
    {
        switch ($status) {
            case 'Pending':
                return '<span class="badge bg-warning text-dark">Pending</span>';
            case 'In Progress':
                return '<span class="badge bg-info text-dark">In Progress</span>';
            case 'Resolved':
                return '<span class="badge bg-success">Resolved</span>';
            default:
                return '<span class="badge bg-secondary">' . $status . '</span>';
        }
    }
}