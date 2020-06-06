<?php

namespace IntuitiveApp\Floor;


/**
 * Speed to clean the floor.
 */
class TypeSpeed
{

    /**
     * @var float
     */
    private $cleaningSpeed;

    /**
     * TypeSpeed constructor.
     *
     * @param float $cleaningSpeed
     */
    public function __construct(float $cleaningSpeed)
    {
        $this->cleaningSpeed = $cleaningSpeed;
    }

    /**
     * Area can be cleaned in time.
     *
     * @param float $seconds
     *
     * @return float
     */
    public function getAreaForTime(float $seconds): float
    {
        return $seconds * $this->cleaningSpeed;
    }

    /**
     * Time need to cleaning the area.
     *
     * @param float $metersSquaredArea
     *
     * @return float
     */
    public function getTimeForArea(float $metersSquaredArea): float
    {
        return $metersSquaredArea / $this->cleaningSpeed;
    }
}
