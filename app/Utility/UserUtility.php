<?php

declare(strict_types=1);

namespace Xetaravel\Utility;

use Carbon\Carbon;

class UserUtility
{
    /**
     * The array containing the XP needed for each level.
     *
     * PostWasSolvedEvent::class => 120,
     * ConversationWasCreatedEvent::class => 90,
     * PostWasCreatedEvent::class => 75
     *
     * @var array
     */
    protected static $levels = [
        0, //0
        400, //1
        800, //2
        1200, //3
        1600, //4
        2000, //5
        2400, //6
        2800, //7
        3200, //8
        3600, //9
        4000, //10
        4400, //11
        4800, //12
        5200, //13
        5600, //14
        6000, //15
        6400, //16
        6800, //17
        7200, //18
        7600, //19
        8000, //20
        8400, //21
        8800, //22
        9200, //23
        9600, //24
        10000, //25
        10400, //26
        10800, //27
        11200, //28
        11600, //29
        12000, //30
        12400, //31
        12800, //32
        13200, //33
        13600, //34
        14000, //35
        14400, //36
        14800, //37
        15200, //38
        15600, //39
        16000, //40
        16400, //41
        16800, //42
        17200, //43
        17600, //44
        18000, //45
        18400, //46
        18800, //47
        19200, //48
        19600, //49
        20000 //50
    ];

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
     * Get the level of a user with his experiences.
     *
     * @param int $userXP The XP of the user to get the level.
     *
     * @return array
     */
    public static function getLevel(int $userXP): array
    {
        $infos = [
            'previousLevelExperience' => 0,
            'previousLevel' => 0,
            'currentLevel' => 0,
            'currentLevelExperience' => 0,
            'currentUserExperience' => 0,
            'nextLevel' => 1,
            'experienceNeededNextLevel' => 400,
            'nextLevelExperience' => 400,
            'matchExactXPLevel' => false,
            'maxLevel' => false
        ];

        if ($userXP === 0) {
            return $infos;
        }

        for ($i = 0; $i < count(static::$levels); $i++) {
            // The XP of the user match the exact XP of the rank and there's another rank after this one.
            if ($userXP === static::$levels[$i] && isset(static::$levels[$i + 1])) {
                return array_merge($infos, [
                    'previousLevelExperience' => static::$levels[$i - 1],
                    'previousLevel' => $i - 1,
                    'currentLevel' => $i,
                    'currentLevelExperience' => static::$levels[$i],
                    'currentUserExperience' => $userXP,
                    'nextLevel' => $i + 1,
                    'experienceNeededNextLevel' => static::$levels[$i + 1] - $userXP,
                    'nextLevelExperience' => static::$levels[$i + 1],
                    'matchExactXPLevel' => true
                ]);
            }
            // If there's another rank after this one and the user XP is higher than the current rank.
            if (isset(static::$levels[$i + 1]) && $userXP > static::$levels[$i]) {
                // If the user XP is higher than the current rank but lower than the next rank.
                if ($userXP > static::$levels[$i] && $userXP < static::$levels[$i + 1]) {
                    return array_merge($infos, [
                        'previousLevelExperience' => static::$levels[$i],
                        'previousLevel' => $i === 0 ? 0 : $i - 1,
                        'currentLevel' => $i,
                        'currentLevelExperience' => static::$levels[$i],
                        'currentUserExperience' => $userXP,
                        'nextLevel' => $i + 1,
                        'experienceNeededNextLevel' => static::$levels[$i + 1] - $userXP,
                        'nextLevelExperience' => static::$levels[$i + 1]
                    ]);
                }
            } else {
                // The user has reached the max lvl
                return array_merge($infos, [
                    'previousLevelExperience' => static::$levels[$i],
                    'previousLevel' => $i === 0 ? 0 : $i - 1,
                    'currentLevel' => $i,
                    'currentLevelExperience' => static::$levels[$i],
                    'currentUserExperience' => $userXP,
                    'nextLevel' => 0,
                    'experienceNeededNextLevel' => 0,
                    'nextLevelExperience' => 0,
                    'matchExactXPLevel' => (static::$levels[$i] - $userXP) === 0 ? true : false,
                    'maxLevel' => true
                ]);
            }

        }
    }

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
