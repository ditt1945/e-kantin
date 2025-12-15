<?php

namespace App\Helpers;

if (!function_exists('flashMessage')) {
    /**
     * Set a flash message
     */
    function flashMessage($type, $message)
    {
        session()->flash($type, $message);
    }
}

if (!function_exists('flashSuccess')) {
    /**
     * Set a success flash message
     */
    function flashSuccess($message)
    {
        session()->flash('success', $message);
    }
}

if (!function_exists('flashError')) {
    /**
     * Set an error flash message
     */
    function flashError($message)
    {
        session()->flash('error', $message);
    }
}

if (!function_exists('flashWarning')) {
    /**
     * Set a warning flash message
     */
    function flashWarning($message)
    {
        session()->flash('warning', $message);
    }
}

if (!function_exists('flashInfo')) {
    /**
     * Set an info flash message
     */
    function flashInfo($message)
    {
        session()->flash('info', $message);
    }
}

if (!function_exists('formatRupiah')) {
    /**
     * Format number to Rupiah
     */
    function formatRupiah($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}