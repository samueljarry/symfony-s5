<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230926070007 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actor ADD first_name VARCHAR(70) NOT NULL, ADD last_name VARCHAR(70) NOT NULL, DROP name');
        $this->addSql('ALTER TABLE category CHANGE name name VARCHAR(70) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actor ADD name VARCHAR(255) NOT NULL, DROP first_name, DROP last_name');
        $this->addSql('ALTER TABLE category CHANGE name name VARCHAR(255) NOT NULL');
    }
}
