<?php

namespace IntuitiveApp\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use IntuitiveApp\Robot\Robot;

/**
 * Command control
 */
class RobotCommand extends Command
{
    /**
     * @var float
     */
    private $totalTasksTime;

    /**
     * RobotCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Command configuration
     */
    protected function configure()
    {
        $this->setName('clean')
            ->setDescription('Robot for cleaninging.')
            ->setHelp('Robot for cleaninging that can charge itself.')
            ->addOption(
                'floor',
                null,
                InputOption::VALUE_REQUIRED,
                'Type of floor.'
            )
            ->addOption(
                'area',
                null,
                InputOption::VALUE_REQUIRED,
                'Area in meter squared.'
            );
    }

    /**
     * Execute command
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|null|void
     * @throws \Exception
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $result = $this->cleaning($input, $output);
        return is_int($result) ? $result : 0;
    }

    /**
     * cleaning Output and sleeping
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @throws \Exception
     */
    protected function cleaning(InputInterface $input, OutputInterface $output)
    {
        // Clear Screen and display result.
        $output->write(sprintf("\033\143"));

        // Display Output.
        $output->writeln([
            '<fg=yellow>___________________________________________</>',
            '<fg=yellow;options=bold>=========== Intuitive Robot App ===========</>',
            '<fg=yellow>___________________________________________</>',
            '',
        ]);

        $floor = $input->getOption('floor');
        $area = $input->getOption('area');
        $isFloorValid = $this->isFloorTypeValid($floor);
        $isAreaValid = $this->isAreaValid($area);
        $floorMessage = ($isFloorValid) ? "" : " - not valid";
        $areaMessage = ($isAreaValid) ? "" : " - not valid";

        if (empty($floorMessage) && empty($areaMessage)) {
            $output->writeln([
                '<info>Intuitive Robot App is working currently to clean ' . $area . ' Sq Mt. ' . $floor . ' floor area.</info>',
                '',
            ]);
            $output->writeln([
                '<info>Intuitive Robot App working log ...</info>',
                '',
            ]);
            $output->writeln('<fg=yellow;options=bold>===========================================</>');
        } else {
            if (!empty($floorMessage)) {
                $output->writeln("<error> Floor: " . $floor . ' ' . $floorMessage . '</error>');
            }
            if (!empty($areaMessage)) {
                $output->writeln("<error> Area: " . $area . '' . $areaMessage . '</error>');
            }
            $output->writeln('');
            $output->writeln('<error>Shut down Intuitive Robot App.</error>');
            $output->writeln('');
            $output->writeln('<fg=yellow;options=bold>===========================================</>');
        }

        // If Floor area and type is valid.
        if ($isFloorValid and $isAreaValid) {
            $robot = new Robot($input->getOption('floor'), floatval($input->getOption('area')));
            $tasks = $robot->run();
            $this->totalTasksTime = 0;
            foreach ($tasks as $taskType => $taskTime) {
                $output->writeln($taskType . ": " . $taskTime . "s");
                $this->totalTasksTime = $this->totalTasksTime + $taskTime;
                sleep(intval($taskTime));
            }
            // Display total time to complete the all tasks.
            $output->writeln('<fg=yellow;options=bold>===========================================</>');
            $output->writeln('<fg=yellow;options=bold>All tasks completed in ' . $this->totalTasksTime .  's </>');
            $output->writeln('<fg=yellow;options=bold>===========================================</>');
        }
    }

    /**
     * Check floor is valid, from floor types i.e. hard or carpet.
     *
     * @param $floorType
     *
     * @return bool
     */
    private function isFloorTypeValid($floorType)
    {
        if (array_key_exists($floorType, Robot::FLOOR_TYPES)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check area is valid, greater than Zero.
     *
     * @param $area
     *
     * @return bool
     */
    private function isAreaValid($area)
    {
        if (is_numeric($area) and $area > 0) {
            return true;
        } else {
            return false;
        }
    }
}
