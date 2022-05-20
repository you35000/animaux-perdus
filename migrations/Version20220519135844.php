<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220519135844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FCD3C5613 FOREIGN KEY (croisements_id) REFERENCES croisement (id)');
        $this->addSql('CREATE INDEX IDX_6AAB231FCD3C5613 ON animal (croisements_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FCD3C5613');
        $this->addSql('DROP INDEX IDX_6AAB231FCD3C5613 ON animal');
    }
}
