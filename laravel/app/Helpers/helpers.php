<?php

if (!function_exists('smartTimeFormat')) {
    function smartTimeFormat(\Carbon\Carbon $time): string
    {
        return $time->diffInDays(now()) < 1 ? $time->format('H:i') : $time->format('d M Y H:i');
    }
}
