<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210406115555 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__course AS SELECT id, slug, name, description FROM course');
        $this->addSql('DROP TABLE course');
        $this->addSql('CREATE TABLE course (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, professor_id INTEGER DEFAULT NULL, slug VARCHAR(255) NOT NULL COLLATE BINARY, name VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_169E6FB97D2D84D5 FOREIGN KEY (professor_id) REFERENCES professor (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO course (id, slug, name, description) SELECT id, slug, name, description FROM __temp__course');
        $this->addSql('DROP TABLE __temp__course');
        $this->addSql('CREATE INDEX IDX_169E6FB97D2D84D5 ON course (professor_id)');
        $this->addSql('DROP INDEX IDX_E4BE6645BA364942');
        $this->addSql('CREATE TEMPORARY TABLE __temp__discussion_entry AS SELECT id, entry_id, text, date FROM discussion_entry');
        $this->addSql('DROP TABLE discussion_entry');
        $this->addSql('CREATE TABLE discussion_entry (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, entry_id INTEGER DEFAULT NULL, text CLOB NOT NULL COLLATE BINARY, date DATETIME NOT NULL, CONSTRAINT FK_E4BE6645BA364942 FOREIGN KEY (entry_id) REFERENCES discussion_entry (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO discussion_entry (id, entry_id, text, date) SELECT id, entry_id, text, date FROM __temp__discussion_entry');
        $this->addSql('DROP TABLE __temp__discussion_entry');
        $this->addSql('CREATE INDEX IDX_E4BE6645BA364942 ON discussion_entry (entry_id)');
        $this->addSql('DROP INDEX IDX_3BAE0AA7591CC992');
        $this->addSql('CREATE TEMPORARY TABLE __temp__event AS SELECT id, course_id, name, date FROM event');
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, course_id INTEGER DEFAULT NULL, name VARCHAR(50) NOT NULL COLLATE BINARY, date DATETIME NOT NULL, CONSTRAINT FK_3BAE0AA7591CC992 FOREIGN KEY (course_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO event (id, course_id, name, date) SELECT id, course_id, name, date FROM __temp__event');
        $this->addSql('DROP TABLE __temp__event');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7591CC992 ON event (course_id)');
        $this->addSql('DROP INDEX IDX_790DD7E3591CC992');
        $this->addSql('CREATE TEMPORARY TABLE __temp__professor AS SELECT id, name, degree FROM professor');
        $this->addSql('DROP TABLE professor');
        $this->addSql('CREATE TABLE professor (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(50) NOT NULL COLLATE BINARY, degree VARCHAR(50) DEFAULT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO professor (id, name, degree) SELECT id, name, degree FROM __temp__professor');
        $this->addSql('DROP TABLE __temp__professor');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_169E6FB97D2D84D5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__course AS SELECT id, slug, name, description FROM course');
        $this->addSql('DROP TABLE course');
        $this->addSql('CREATE TABLE course (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, slug VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO course (id, slug, name, description) SELECT id, slug, name, description FROM __temp__course');
        $this->addSql('DROP TABLE __temp__course');
        $this->addSql('DROP INDEX IDX_E4BE6645BA364942');
        $this->addSql('CREATE TEMPORARY TABLE __temp__discussion_entry AS SELECT id, entry_id, text, date FROM discussion_entry');
        $this->addSql('DROP TABLE discussion_entry');
        $this->addSql('CREATE TABLE discussion_entry (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, entry_id INTEGER DEFAULT NULL, text CLOB NOT NULL, date DATETIME NOT NULL)');
        $this->addSql('INSERT INTO discussion_entry (id, entry_id, text, date) SELECT id, entry_id, text, date FROM __temp__discussion_entry');
        $this->addSql('DROP TABLE __temp__discussion_entry');
        $this->addSql('CREATE INDEX IDX_E4BE6645BA364942 ON discussion_entry (entry_id)');
        $this->addSql('DROP INDEX IDX_3BAE0AA7591CC992');
        $this->addSql('CREATE TEMPORARY TABLE __temp__event AS SELECT id, course_id, name, date FROM event');
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, course_id INTEGER DEFAULT NULL, name VARCHAR(50) NOT NULL, date DATETIME NOT NULL)');
        $this->addSql('INSERT INTO event (id, course_id, name, date) SELECT id, course_id, name, date FROM __temp__event');
        $this->addSql('DROP TABLE __temp__event');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7591CC992 ON event (course_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__professor AS SELECT id, name, degree FROM professor');
        $this->addSql('DROP TABLE professor');
        $this->addSql('CREATE TABLE professor (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(50) NOT NULL, degree VARCHAR(50) DEFAULT NULL, course_id INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO professor (id, name, degree) SELECT id, name, degree FROM __temp__professor');
        $this->addSql('DROP TABLE __temp__professor');
        $this->addSql('CREATE INDEX IDX_790DD7E3591CC992 ON professor (course_id)');
    }
}
