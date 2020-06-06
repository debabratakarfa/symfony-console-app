<?php

namespace IntuitiveApp\Robot;


use IntuitiveApp\Floor\Area;
use IntuitiveApp\Floor\TypeSpeed;
use IntuitiveApp\Robot\Battery;

/**
 * Robot working model.
 */
class Robot
{

    /**
     * If Floor Types is Hard then it will clean 1 sq mt in a second.
     * If Floor Types is Carpet then it will clean 2 sq mt in a second.
     * @var array
     */
    const FLOOR_TYPES = ['hard' => 1, 'carpet' => 2];

    /**
     * If full charge, time Robot work.
     *
     * @var integer
     */
    const SECONDS_POWER = 60;

    /**
     * Time need to recharge 100% of Robot battery.
     *
     * @var integer
     */
    const SECONDS_CHARGE = 30;

    /**
     * @var FloorArea
     */
    private $floorArea;

    /**
     * @var FloorTypeSpeed
     */
    private $floorTypeSpeed;

    /**
     * @var BatteryPower
     */
    private $batteryPower;

    /**
     * Robot constructor.
     *
     * @param string $floorType
     * @param float $area
     */
    public function __construct(string $floorType, float $area)
    {
        $this->floorArea = new Area($area);
        $this->floorTypeSpeed = new TypeSpeed($this::FLOOR_TYPES[$floorType]);
        $this->batteryPower = new Battery($this::SECONDS_POWER, $this::SECONDS_CHARGE);
    }

    /**
     * Cleaning and Charging logic
     *
     * @return array
     * @throws \Exception
     */
    public function run(): array
    {
        $tasks = [];
        $i = 0;
        while (true) {
            [ $area, $cleaningTime] = $this->getCleaningAreaTime();

            // Cleaning
            $this->floorArea->clean($area);
            $this->batteryPower->work($cleaningTime);
            $tasks["cleaning_cycle_" . $i] = $cleaningTime;

            //Charging Now
            $timeToCharge = $this->batteryPower->charge();
            $tasks["battery_charging_cycle_" . $i] = $timeToCharge;
            if ($this->floorArea->isCleaned()) {
                break;
            }

            $i++;
        }
        return $tasks;
    }

    /**
     * Find the size of area and time need to clean that.
     *
     * @return array
     */
    private function getCleaningAreaTime()
    {
        $maxWorkingTime = $this->batteryPower->getMaxWorkingTime();
        $maxCleaningArea = $this->floorArea->getMaxCleaningArea();
        $areaToCleanInMaxTime = $this->floorTypeSpeed->getAreaForTime($maxWorkingTime);
        $maxCleaningAreaTime = $this->floorTypeSpeed->getTimeForArea($maxCleaningArea);
        $minArea = min($areaToCleanInMaxTime, $maxCleaningArea);
        $minCleaningTime = min($maxWorkingTime, $maxCleaningAreaTime);
        return [$minArea, $minCleaningTime];
    }
}
