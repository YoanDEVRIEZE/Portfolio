<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250308111205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE projet_skill (projet_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_F59B0BC1C18272 (projet_id), INDEX IDX_F59B0BC15585C142 (skill_id), PRIMARY KEY(projet_id, skill_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projet_skill ADD CONSTRAINT FK_F59B0BC1C18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet_skill ADD CONSTRAINT FK_F59B0BC15585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet_skill DROP FOREIGN KEY FK_F59B0BC1C18272');
        $this->addSql('ALTER TABLE projet_skill DROP FOREIGN KEY FK_F59B0BC15585C142');
        $this->addSql('DROP TABLE projet_skill');
    }
}
