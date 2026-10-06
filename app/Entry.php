<?php

namespace App;

use Carbon\Carbon;

class Entry extends Model
{
    protected $table = 'entrances';

    protected $casts = [
        'entry_time' => 'datetime',
    ];

    protected $fillable = [ 'user_id', 'entry_time', 'type', 'payment_status', 'plan_status', 'message'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Parse admin/trainer filter datetimes (ISO or Serbian picker values).
     * Missing values default to the start/end of today so new scans stay visible.
     */
    public static function parseFilterRange($fromValue, $toValue)
    {
        $from = self::parseFilterDate($fromValue);
        $to = self::parseFilterDate($toValue);

        return [
            $from ?: Carbon::now()->copy()->startOfDay(),
            $to ?: Carbon::now()->copy()->endOfDay(),
        ];
    }

    public static function parseFilterDate($value)
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        $formats = [
            'Y-m-d H:i:s',
            'Y-m-d H:i',
            'd.m.Y H:i:s',
            'd.m.Y H:i',
            'd.m.Y. H:i:s',
            'd.m.Y. H:i',
        ];

        foreach ($formats as $format) {
            try {
                $parsed = Carbon::createFromFormat($format, $value);
                if ($parsed !== false) {
                    return $parsed;
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        try {
            return Carbon::parse($value);
        } catch (\Exception $e) {
            return null;
        }
    }
}
