<?php

namespace Tests\Robot;


use IntuitiveApp\Robot\Robot;
use PHPUnit\Framework\TestCase;

final class RobotTest extends TestCase
{

    /**
     * @dataProvider getTestCleaningData
     *
     * @param $floorType
     * @param $area
     *
     * @param $expectedTasks
     *
     * @throws \Exception
     */
    public function testCleaning(string $floorType, float $area, array $expectedTasks)
    {
        $cleaningRobot = new Robot($floorType, $area);
        $tasks = $cleaningRobot->run();
        $this->assertSame($tasks, $expectedTasks);
    }

    /**
     * Provides data for testCleaning.
     *
     * @return array
     */
    public function getTestCleaningData(): array
    {
        return [
            "hard" => ["hard", 60.0, ["cleaning_cycle_0" => 60.0, "battery_charging_cycle_0" => 30.0]],
            "carpet" => ["carpet", 30.0, ["cleaning_cycle_0" => 15.0, "battery_charging_cycle_0" => 7.5]]
        ];
    }
}
