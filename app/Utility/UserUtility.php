<?php
namespace Xetaravel\Utility;

use Carbon\Carbon;

class UserUtility
{
    /**
     * The prefix of the background images.
     *
     * @var string
     */
    protected static $prefix = 'images/profile/bg_profile_';

    /**
     * The extension of the background images.
     *
     * @var string
     */
    protected static $extension = '.jpg';

    /**
     * The days references with the images name.
     *
     * @var array
     */
    protected static $daysReferences = [
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
        '10' => '10',
        '11' => '11',
        '12' => '12',
        '13' => '13',
        '14' => '14',
        '15' => '15',
        '16' => '1',
        '17' => '2',
        '18' => '3',
        '19' => '4',
        '20' => '5',
        '21' => '6',
        '22' => '7',
        '23' => '8',
        '24' => '9',
        '25' => '10',
        '26' => '11',
        '27' => '12',
        '28' => '13',
        '29' => '14',
        '30' => '15',
        '31' => '1'
    ];

    /**
     * Get the profile background by the current day.
     *
     * @return string
     */
    public static function getProfileBackground()
    {
        $now = Carbon::now();
        $day = $now->day;

        if (isset(static::$daysReferences[$day])) {
            return static::$prefix . static::$daysReferences[$day] . static::$extension;
        }

        return static::$prefix . '1' . static::$extension;
    }
}
