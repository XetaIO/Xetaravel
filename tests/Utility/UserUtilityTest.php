<?php
namespace Tests\Utility;

use Tests\TestCase;
use Xetaravel\Utility\UserUtility;

class UserUtilityTest extends TestCase
{
    /**
     * testGetLevel0XP method
     *
     * @return void
     */
    public function testGetLevel0XP(): void
    {
        $result = UserUtility::getLevel(0);

        $this->assertSame(
            [
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
            ],
            $result
        );
    }

    /**
     * testGetLevelMatchExactLevelXP method
     *
     * @return void
     */
    public function testGetLevelMatchExactLevelXP(): void
    {
        $result = UserUtility::getLevel(800);

        $this->assertSame(
            [
                'previousLevelExperience' => 400,
                'previousLevel' => 1,
                'currentLevel' => 2,
                'currentLevelExperience' => 800,
                'currentUserExperience' => 800,
                'nextLevel' => 3,
                'experienceNeededNextLevel' => 400,
                'nextLevelExperience' => 1200,
                'matchExactXPLevel' => true,
                'maxLevel' => false
            ],
            $result
        );
    }

    /**
     * testGetLevelMatchExactLevelXP method
     *
     * @return void
     */
    public function testGetLevelMidLevelXP(): void
    {
        $result = UserUtility::getLevel(1400);

        $this->assertSame(
            [
                'previousLevelExperience' => 1200,
                'previousLevel' => 2,
                'currentLevel' => 3,
                'currentLevelExperience' => 1200,
                'currentUserExperience' => 1400,
                'nextLevel' => 4,
                'experienceNeededNextLevel' => 200,
                'nextLevelExperience' => 1600,
                'matchExactXPLevel' => false,
                'maxLevel' => false
            ],
            $result
        );
    }

    /**
     * testGetLevelMaxLevelExactXP method
     *
     * @return void
     */
    public function testGetLevelMaxLevelExactXP(): void
    {
        $result = UserUtility::getLevel(20000);

        $this->assertSame(
            [
                'previousLevelExperience' => 20000,
                'previousLevel' => 49,
                'currentLevel' => 50,
                'currentLevelExperience' => 20000,
                'currentUserExperience' => 20000,
                'nextLevel' => 0,
                'experienceNeededNextLevel' => 0,
                'nextLevelExperience' => 0,
                'matchExactXPLevel' => true,
                'maxLevel' => true
            ],
            $result
        );
    }

    /**
     * testGetLevelMaxLevel method
     *
     * @return void
     */
    public function testGetLevelMaxLevel(): void
    {
        $result = UserUtility::getLevel(25000);

        $this->assertSame(
            [
                'previousLevelExperience' => 20000,
                'previousLevel' => 49,
                'currentLevel' => 50,
                'currentLevelExperience' => 20000,
                'currentUserExperience' => 25000,
                'nextLevel' => 0,
                'experienceNeededNextLevel' => 0,
                'nextLevelExperience' => 0,
                'matchExactXPLevel' => false,
                'maxLevel' => true
            ],
            $result
        );
    }
}
