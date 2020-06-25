<?php

declare(strict_types=1);

namespace App\Console\Command\User\Role;

use App\Model\User\Entity\User\Login;
use App\Model\User\Entity\User\Role;
use App\Model\User\Entity\User\UserRepository;
use App\Model\User\UseCase\User\Role\Change\Handler;
use Exception;
use LogicException;
use Symfony\Component\Console\Command\Command as ConsoleCommand;
use App\Model\User\UseCase\User\Role\Change\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ChangeCommand extends ConsoleCommand
{
    private ValidatorInterface $validator;
    private UserRepository $users;
    private Handler $handler;

    /**
     * ChangeCommand constructor.
     * @param ValidatorInterface $validator
     * @param UserRepository $users
     * @param Handler $handler
     */
    public function __construct(ValidatorInterface $validator, UserRepository $users, Handler $handler)
    {
        parent::__construct();
        $this->validator = $validator;
        $this->users = $users;
        $this->handler = $handler;
    }

    protected function configure(): void
    {
        $this
            ->setName('user:role:change')
            ->setDescription('Change user role');
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

        if (!$user = $this->users->findByLogin(new Login($login))) {
            throw new LogicException('User is not found.');
        }

        $command = new Command($user->getId()->getValue());

        $roles = [
            Role::USER,
            Role::MODERATOR,
            Role::CONTENT_MANAGER,
            Role::ADMIN
        ];

        $command->role = $helper->ask($input, $output, new ChoiceQuestion('Role', $roles, 0));

        $violations = $this->validator->validate($command);

        if ($violations->count()) {
            foreach ($violations as $violation) {
                $output->writeln('<error>' . $violation->getPropertyPath() . ': ' . $violation->getMessage() . '</error>');
            }

            return 1;
        }

        $this->handler->handle($command);

        $output->writeln('<info>Done!</info>');

        return 0;
    }
}