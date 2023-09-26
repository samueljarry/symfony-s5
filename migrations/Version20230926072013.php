<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230926072013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE nationality (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nationality_actor (nationality_id INT NOT NULL, actor_id INT NOT NULL, INDEX IDX_AE68B6451C9DA55 (nationality_id), INDEX IDX_AE68B64510DAF24A (actor_id), PRIMARY KEY(nationality_id, actor_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE nationality_actor ADD CONSTRAINT FK_AE68B6451C9DA55 FOREIGN KEY (nationality_id) REFERENCES nationality (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nationality_actor ADD CONSTRAINT FK_AE68B64510DAF24A FOREIGN KEY (actor_id) REFERENCES actor (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nationality_actor DROP FOREIGN KEY FK_AE68B6451C9DA55');
        $this->addSql('ALTER TABLE nationality_actor DROP FOREIGN KEY FK_AE68B64510DAF24A');
        $this->addSql('DROP TABLE nationality');
        $this->addSql('DROP TABLE nationality_actor');
    }
}
