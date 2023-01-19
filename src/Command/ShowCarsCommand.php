<?php

namespace App\Command;

use App\Entity\Car;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


/** * @property UserPasswordHasherInterface $passwordHasher
 * @property EntityManagerInterface $entityManager
 */
#[AsCommand(
    name: 'showCars',
    description: 'Add a short description for your command',
)]
class ShowCarsCommand extends Command
{


    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {

        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {


        $car = $this->entityManager->getRepository(Car::class);
        foreach ($car->findAll() as $cars){

        $output->writeln('Id: '.$cars->getId());
        $output->writeln('CarBrand: '.$cars->getBrand());
        $output->writeln('CarPhoto: '.$cars->getPhoto());
        $output->writeln('CarModel: '.$cars->getModel());
        $output->writeln('CarDescription: '.$cars->getDescription());
        $output->writeln('CarColor: '.$cars->getColor());
        $output->writeln('CarPrice: '.$cars->getPrice());

        $output->writeln('-------------------------');

        }

            $io = new SymfonyStyle($input, $output);
            $io->success('THIS IS ALL INFO');

    return Command::SUCCESS;
}

}
