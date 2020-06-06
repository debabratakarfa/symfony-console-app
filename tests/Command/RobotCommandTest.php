<?php

namespace Tests\Command;

use IntuitiveApp\Command\RobotCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Output\Output;

final class RobotCommandTest extends TestCase
{

    /**
     * PHPUnit Test wrong inputs
     *
     * @throws \Exception
     */
    public function testWrongInputs()
    {
        $inputMock = $this->createMock(Input::class);
        $outputMock = $this->createMock(Output::class);
        // Methods
        $inputMock->expects($this->any())
            ->method('getOption')
            ->will($this->returnCallback([$this, 'getDataPerParameter']));
        $outputMock->expects($this->at(1))
            ->method("writeln")
            ->will($this->returnCallback([$this, "wrongFloorValue"]));
        $outputMock->expects($this->at(2))
            ->method("writeln")
            ->will($this->returnCallback([$this, "wrongAreaValue"]));
        $robotCommand = new RobotCommand();
        $robotCommand->run($inputMock, $outputMock);
    }

    /**
     * Unit test for area value.
     *
     * @param $areaMessage
     */
    public function wrongAreaValue(string $areaMessage)
    {
        $this->assertContains(" - not valid", $areaMessage);
    }

    /**
     * Unit test for  floor value
     *
     * @param $floorMessage
     */
    public function wrongFloorValue(string $floorMessage)
    {
        $this->assertContains(" - not valid", $floorMessage);
    }

    /**
     * Test values
     *
     * @return string
     */
    public function getDataPerParameter(): string
    {
        $args = func_get_args();
        if ($args[0] === "floor") {
            return "non carpet";
        } elseif ($args[0] === "area") {
            return "-20";
        }
    }

}
