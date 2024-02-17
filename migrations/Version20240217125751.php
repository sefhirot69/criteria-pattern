<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240217125751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Created Album and Artist tables with foreign key relationship.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Album (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', artist_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', Title VARCHAR(255) NOT NULL, INDEX IDX_F8594147B7970CF8 (artist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Artist (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', Name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Album ADD CONSTRAINT FK_F8594147B7970CF8 FOREIGN KEY (artist_id) REFERENCES Artist (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Album DROP FOREIGN KEY FK_F8594147B7970CF8');
        $this->addSql('DROP TABLE Album');
        $this->addSql('DROP TABLE Artist');
    }
}
