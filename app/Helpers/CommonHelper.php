<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CommonHelper
{
    /**
     * Set alertMsg session
     *
     * @param   Request $request
     * @param   string  $type    MESSAGE_ERROR | MESSAGE_WARNING | MESSAGE_SUCCESS.
     * @param   string  $message
     * @return  void
     */
    public static function setMessage(Request $request, string $type, string $message)
    {
        $request->session()->put('alertMsg', view('components.messages', [
            'alertMsg' => true,
            'type' => $type,
            'message' => $message,
        ])->render());
    }

    /**
     * Get alertMsg session
     *
     * @param   Request $request
     * @return  string|null
     */
    public static function getMessage(Request $request): ?string
    {
        $message = null;
        if ($request->session()->has('alertMsg')) {
            $message = $request->session()->get('alertMsg');
            $request->session()->forget('alertMsg');
        }
        return $message;
    }

    /**
     * Format Price
     *
     * @param   mixed   $number
     * @param   string  $unit
     * @param   integer $decimal
     * @return  string|null
     */
    public static function formatPrice($number, string $unit = '', int $decimal = 0): ?string
    {
        if (empty($number)) {
            return 0;
        }

        return number_format(floor($number * 10 / 10), $decimal, '.', ',') . $unit;
    }

    /**
     * Format Time
     *
     * @param   string|null $timestamp
     * @param   string $format
     * @return  string|null
     */
    public static function formatTime(?string $timestamp, string $format = 'd/m/Y'): ?string
    {
        if (empty($timestamp)) {
            return null;
        }

        return Carbon::parse($timestamp)->format($format);
    }
}
