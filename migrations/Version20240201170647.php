<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240201170647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nationality_actor DROP FOREIGN KEY FK_AE68B64510DAF24A');
        $this->addSql('ALTER TABLE nationality_actor DROP FOREIGN KEY FK_AE68B6451C9DA55');
        $this->addSql('DROP TABLE nationality_actor');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE nationality_actor (nationality_id INT NOT NULL, actor_id INT NOT NULL, INDEX IDX_AE68B64510DAF24A (actor_id), INDEX IDX_AE68B6451C9DA55 (nationality_id), PRIMARY KEY(nationality_id, actor_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE nationality_actor ADD CONSTRAINT FK_AE68B64510DAF24A FOREIGN KEY (actor_id) REFERENCES actor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nationality_actor ADD CONSTRAINT FK_AE68B6451C9DA55 FOREIGN KEY (nationality_id) REFERENCES nationality (id) ON DELETE CASCADE');
    }
}
