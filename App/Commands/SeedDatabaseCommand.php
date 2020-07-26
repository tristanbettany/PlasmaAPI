<?php

declare(strict_types=1);

namespace App\Commands;

use App\Core\Helpers\Config;
use App\Core\Interfaces\SeederInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class SeedDatabaseCommand extends Command
{
    protected function configure() :void
    {
        $this
            ->setName('db:seed')
            ->setDescription('Seed Database')
        ;
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) :int {
        $seeds = Config::get('seeds');

        /** @var SeederInterface $seed */
        foreach ($seeds as $seed) {
            $seed::seed();
        }

        return 0;
    }
}