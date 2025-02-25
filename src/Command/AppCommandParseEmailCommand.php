<?php

namespace App\Command;

use App\Controller\GMailController;
use App\Service\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpFoundation\Request;

#[AsCommand(
    name: 'AppCommandParseEmail',
    description: 'Add a short description for your command',
)]
class AppCommandParseEmailCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->note("Hello, Mykola");
        $controller = new GMailController();
        try {
            $mailsList = array_filter(json_decode(
                $controller->getMails(new Request([]))->getContent(),
                true
            )['data_list']['messages'] ?? [], fn($mail) => strtotime($mail['date']) > (time() - 60));

            foreach ($mailsList as &$email) {
                try {
                    $request = new Request();
                    $request->initialize(
                        $request->query->all(),
                        $request->request->all(),
                        $request->attributes->all(),
                        $request->cookies->all(),
                        $request->files->all(),
                        $request->server->all(),
                        ['email_id' => $email['id']]
                    );
                    $email = json_decode($controller->getMailDetails($request)->getContent())->data_list->message;
                    $email->date = new \DateTime($email->date);
                    $io->note(json_encode($email));
                } catch (\Exception $e) {
                    var_dump($e->getMessage());
                    die;
                }
            }
            unset($email);

            //HERE WE CAN DO ANYTHING WITH $mailsList
            //$mailsList[X]['body'] - body of email
            $io->note(count($mailsList));
            foreach($mailsList as $email){
                new MailService($email, $this->entityManager);
            }
        } catch (\Doctrine\DBAL\Exception|Exception|\Exception $e) {
            $io->note($e->getMessage());
        }

        $io->success('Command executed successfully');

        return Command::SUCCESS;
    }
}
