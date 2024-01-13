<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230422233428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__i23_paniers AS SELECT id FROM i23_paniers');
        $this->addSql('DROP TABLE i23_paniers');
        $this->addSql('CREATE TABLE i23_paniers (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_utilisateur INTEGER DEFAULT NULL, CONSTRAINT FK_6257196150EAE44 FOREIGN KEY (id_utilisateur) REFERENCES i23_utilisateurs (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO i23_paniers (id) SELECT id FROM __temp__i23_paniers');
        $this->addSql('DROP TABLE __temp__i23_paniers');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6257196150EAE44 ON i23_paniers (id_utilisateur)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__i23_paniers AS SELECT id FROM i23_paniers');
        $this->addSql('DROP TABLE i23_paniers');
        $this->addSql('CREATE TABLE i23_paniers (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('INSERT INTO i23_paniers (id) SELECT id FROM __temp__i23_paniers');
        $this->addSql('DROP TABLE __temp__i23_paniers');
    }
}
