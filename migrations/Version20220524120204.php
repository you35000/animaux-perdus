<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220524120204 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE declaration ADD etas_id INT NOT NULL, ADD secteurs_id INT NOT NULL, ADD animaux_id INT NOT NULL, CHANGE users_id users_id INT NOT NULL');
        $this->addSql('ALTER TABLE declaration ADD CONSTRAINT FK_7AA3DAC29089BE46 FOREIGN KEY (etas_id) REFERENCES etat (id)');
        $this->addSql('ALTER TABLE declaration ADD CONSTRAINT FK_7AA3DAC2978437EE FOREIGN KEY (secteurs_id) REFERENCES secteur (id)');
        $this->addSql('ALTER TABLE declaration ADD CONSTRAINT FK_7AA3DAC2A9DAECAA FOREIGN KEY (animaux_id) REFERENCES animal (id)');
        $this->addSql('CREATE INDEX IDX_7AA3DAC29089BE46 ON declaration (etas_id)');
        $this->addSql('CREATE INDEX IDX_7AA3DAC2978437EE ON declaration (secteurs_id)');
        $this->addSql('CREATE INDEX IDX_7AA3DAC2A9DAECAA ON declaration (animaux_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE declaration DROP FOREIGN KEY FK_7AA3DAC29089BE46');
        $this->addSql('ALTER TABLE declaration DROP FOREIGN KEY FK_7AA3DAC2978437EE');
        $this->addSql('ALTER TABLE declaration DROP FOREIGN KEY FK_7AA3DAC2A9DAECAA');
        $this->addSql('DROP INDEX IDX_7AA3DAC29089BE46 ON declaration');
        $this->addSql('DROP INDEX IDX_7AA3DAC2978437EE ON declaration');
        $this->addSql('DROP INDEX IDX_7AA3DAC2A9DAECAA ON declaration');
        $this->addSql('ALTER TABLE declaration DROP etas_id, DROP secteurs_id, DROP animaux_id, CHANGE users_id users_id INT DEFAULT NULL');
    }
}
