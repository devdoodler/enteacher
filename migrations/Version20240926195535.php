<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240926195535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE translation_pron_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE translation_pron (id INT NOT NULL, translation_id INT NOT NULL, path VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_78435B129CAA2B25 ON translation_pron (translation_id)');
        $this->addSql('ALTER TABLE translation_pron ADD CONSTRAINT FK_78435B129CAA2B25 FOREIGN KEY (translation_id) REFERENCES translation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE translation ADD explanation TEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE translation_pron_id_seq CASCADE');
        $this->addSql('ALTER TABLE translation_pron DROP CONSTRAINT FK_78435B129CAA2B25');
        $this->addSql('DROP TABLE translation_pron');
        $this->addSql('ALTER TABLE translation DROP explanation');
    }
}
