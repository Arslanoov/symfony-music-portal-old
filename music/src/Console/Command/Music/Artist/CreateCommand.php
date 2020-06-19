<?php

declare(strict_types=1);

namespace App\Console\Command\Music\Artist;

use App\Model\Music\Entity\Artist\ArtistRepository;
use App\Model\Music\UseCase\Artist\Create\Handler;
use Exception;
use LogicException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CreateCommand extends Command
{
    private ArtistRepository $artists;
    private Handler $handler;

    /**
     * CreateCommand constructor.
     * @param ArtistRepository $artists
     * @param Handler $handler
     */
    public function __construct(ArtistRepository $artists, Handler $handler)
    {
        parent::__construct();
        $this->artists = $artists;
        $this->handler = $handler;
    }

    protected function configure(): void
    {
        $this
            ->setName('music:artist:create')
            ->setDescription('Creates artist');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $login = $helper->ask($input, $output, new Question('Login: '));

        if ($this->artists->hasByLogin($login)) {
            throw new LogicException('Artist is already exists.');
        }

        $command = new \App\Model\Music\UseCase\Artist\Create\Command(Uuid::uuid4()->toString(), $login);
        $this->handler->handle($command);

        $output->writeln('<info>Done!</info>');

        return 0;
    }
}