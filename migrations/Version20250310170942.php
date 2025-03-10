<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250310170942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parcours CHANGE nom nom VARCHAR(100) NOT NULL, CHANGE poste poste VARCHAR(50) NOT NULL, CHANGE statut statut VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE projet CHANGE titre titre VARCHAR(50) NOT NULL, CHANGE alt alt VARCHAR(100) NOT NULL, CHANGE description description VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet CHANGE titre titre VARCHAR(255) NOT NULL, CHANGE alt alt VARCHAR(255) NOT NULL, CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE parcours CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE poste poste VARCHAR(255) NOT NULL, CHANGE statut statut VARCHAR(255) NOT NULL');
    }
}
