<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240925125059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE translation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE word_translation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE translation (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE word_translation (id INT NOT NULL, word_id INT NOT NULL, translation_id INT NOT NULL, priority INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8CD87099E357438D ON word_translation (word_id)');
        $this->addSql('CREATE INDEX IDX_8CD870999CAA2B25 ON word_translation (translation_id)');
        $this->addSql('CREATE UNIQUE INDEX word_translation_priority_unique_idx ON word_translation (word_id, translation_id, priority)');
        $this->addSql('ALTER TABLE word_translation ADD CONSTRAINT FK_8CD87099E357438D FOREIGN KEY (word_id) REFERENCES word (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE word_translation ADD CONSTRAINT FK_8CD870999CAA2B25 FOREIGN KEY (translation_id) REFERENCES translation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX pronunciation_word_dialect_source_unique_idx ON pronunciation (word_id, dialect, source)');
        $this->addSql('CREATE UNIQUE INDEX word_name_dialect_unique_idx ON word (name, dialect)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE translation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE word_translation_id_seq CASCADE');
        $this->addSql('ALTER TABLE word_translation DROP CONSTRAINT FK_8CD87099E357438D');
        $this->addSql('ALTER TABLE word_translation DROP CONSTRAINT FK_8CD870999CAA2B25');
        $this->addSql('DROP TABLE translation');
        $this->addSql('DROP TABLE word_translation');
        $this->addSql('DROP INDEX word_name_dialect_unique_idx');
        $this->addSql('DROP INDEX pronunciation_word_dialect_source_unique_idx');
    }
}
