<?php

namespace IntuitiveApp\Floor;


use Exception;

/**
 * Model to get information about Area.
 */
class Area
{

    /**
     * @var float
     */
    private $metersSquaredArea;

    /**
     * @var float
     */
    private $metersSquaredCleaned;

    /**
     * Area constructor.
     *
     * @param double $metersSquaredArea
     */
    public function __construct(float $metersSquaredArea)
    {
        $this->metersSquaredArea = $metersSquaredArea;
        $this->metersSquaredCleaned = 0;
    }

    /**
     * Part of area clean.
     *
     * @param float $metersSquared
     *
     * @return float|int
     * @throws \Exception
     */
    public function clean(float $metersSquared): float
    {
        if ($metersSquared > $this->metersSquaredArea - $this->metersSquaredCleaned) {
            throw new Exception('Robot cleaning more area than it is possible.');
        } else {
            $this->metersSquaredCleaned += $metersSquared;
        }
        return $this->metersSquaredArea - $this->metersSquaredCleaned - $metersSquared;
    }

    /**
     * Not cleaned area.
     *
     * @return float
     */
    public function getMaxCleaningArea(): float
    {
        return $this->metersSquaredArea - $this->metersSquaredCleaned;
    }

    /**
     * Checked if the area is Cleaned or not.
     *
     * @return bool
     */
    public function isCleaned(): bool
    {
        return $this->metersSquaredCleaned >= $this->metersSquaredArea;
    }
}
