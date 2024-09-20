<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240831202051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add pronunciation and relate to word';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE pronunciation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE pronunciation (id INT NOT NULL, word_id INT NOT NULL, dialect VARCHAR(255) NOT NULL, source VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, phonetically VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D465ED07E357438D ON pronunciation (word_id)');
        $this->addSql('ALTER TABLE pronunciation ADD CONSTRAINT FK_D465ED07E357438D FOREIGN KEY (word_id) REFERENCES word (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE pronunciation_id_seq CASCADE');
        $this->addSql('ALTER TABLE pronunciation DROP CONSTRAINT FK_D465ED07E357438D');
        $this->addSql('DROP TABLE pronunciation');
    }
}
