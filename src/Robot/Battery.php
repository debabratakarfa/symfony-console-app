<?php

namespace IntuitiveApp\Robot;


use Exception;

/**
 * Battery Information.
 */
class Battery
{

    /**
     * @var float
     */
    private $secondsPower;

    /**
     * @var float
     */
    private $secondsCharge;

    /**
     * @var float
     */
    private $capacity;

    /**
     * Battery constructor.
     *
     * @param float $secondsPower
     * @param float $secondsCharge
     */
    public function __construct(float $secondsPower, float $secondsCharge)
    {
        $this->secondsPower = $secondsPower;
        $this->secondsCharge = $secondsCharge;
        $this->capacity = 1;
    }

    /**
     * How long the Cleaning process can work with current battery capacity.
     *
     * @return float
     */
    public function getMaxWorkingTime(): float
    {
        return $this->secondsPower * $this->capacity;
    }

    /**
     * Charge the battery.
     *
     * @return float
     */
    public function charge(): float
    {
        $timeToCharge = $this->secondsCharge * (1 - $this->capacity);
        $this->capacity = 1;
        return $timeToCharge;
    }

    /**
     * Use the battery.
     *
     * @param float $seconds
     *
     * @throws \Exception
     */
    public function work(float $seconds)
    {
        if ($seconds <= $this->getMaxWorkingTime()) {
            $this->capacity = 1 - ($seconds / $this->secondsPower);
        } else {
            throw new Exception('Battery does not have capacity.');
        }
    }
}
