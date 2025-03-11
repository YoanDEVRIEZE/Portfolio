<?php

namespace App\Command;

use App\Entity\Site;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'app:add-site',
    description: 'Ajout des paramètres du site',
)]
class AddSiteCommand extends Command
{
    private $recaptchaPublicKey;
    private $recaptchaSecretKey;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('api_recaptchaP', InputArgument::REQUIRED, 'Clé API public reCAPTCHA v3')
            ->addArgument('api_recaptchaS', InputArgument::REQUIRED, 'Clé API secret reCAPTCHA v3') 
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("Création des clés API reCAPTCHA v3...");

        $this->recaptchaPublicKey = $input->getArgument('api_recaptchaP');
        $this->recaptchaSecretKey = $input->getArgument('api_recaptchaS');        

        if (empty($this->recaptchaPublicKey)) {
            $output->writeln("Veuillez renseigner une clé publique API reCAPTCHA v3.");
            return Command::FAILURE;
        }

        if (empty($this->recaptchaSecretKey)) {
            $output->writeln("Veuillez renseigner une clé secrète API reCAPTCHA v3.");
            return Command::FAILURE;
        }

        $envPath = __DIR__ . '/../../.env';
        $envContent = file_get_contents($envPath);

        if (strpos($envContent, 'RECAPTCHA3_KEY=') !== false) {
            $envContent = preg_replace('/RECAPTCHA3_KEY=.*/', 'RECAPTCHA3_KEY="' . $this->recaptchaPublicKey.'"', $envContent);
        } else {
            $envContent .= '\nRECAPTCHA3_KEY="' . $this->recaptchaPublicKey.'"';
        }

        if (strpos($envContent, 'RECAPTCHA3_SECRET=') !== false) {
            $envContent = preg_replace('/RECAPTCHA3_SECRET=.*/', 'RECAPTCHA3_SECRET="' . $this->recaptchaSecretKey.'"', $envContent);
        } else {
            $envContent .= '\nRECAPTCHA3_SECRET="' . $this->recaptchaSecretKey.'"';
        }

        file_put_contents($envPath, $envContent);

        $output->writeln("Les clés public/secret reCAPTCHA v3 ont été enregistrées avec succès dans le fichier .env).");
        $output->writeln("Création des paramètres du site...");

        $site = new Site();
        $site->setTitle('Mon site');
        $site->setDescription('Description du site');
        $site->setKeywords(['mot-clé 1', 'mot-clé 2', 'mot-clé 3']);
        $site->setReseaudescription('Description pour les réseaux');
        $site->setUrl('https://monsite.fr');

        $this->entityManager->persist($site);
        $this->entityManager->flush();

        $output->writeln("Paramètres du site créés avec succès.");

        return Command::SUCCESS;
    }
}
