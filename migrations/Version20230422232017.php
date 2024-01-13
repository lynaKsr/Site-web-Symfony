<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230422232017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE i23_produits_paniers (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_produit INTEGER NOT NULL, id_panier INTEGER NOT NULL, prix_unitaire DOUBLE PRECISION NOT NULL, CONSTRAINT FK_11594227F7384557 FOREIGN KEY (id_produit) REFERENCES i23_produits (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_115942272FBB81F FOREIGN KEY (id_panier) REFERENCES i23_paniers (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_11594227F7384557 ON i23_produits_paniers (id_produit)');
        $this->addSql('CREATE INDEX IDX_115942272FBB81F ON i23_produits_paniers (id_panier)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_11594227F73845572FBB81F ON i23_produits_paniers (id_produit, id_panier)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__i23_utilisateurs AS SELECT id, login, roles, password, nom, prenom, date_de_naissance, is_admin FROM i23_utilisateurs');
        $this->addSql('DROP TABLE i23_utilisateurs');
        $this->addSql('CREATE TABLE i23_utilisateurs (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, panier_id INTEGER DEFAULT NULL, login VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, nom VARCHAR(200) NOT NULL, prenom VARCHAR(200) NOT NULL, date_de_naissance DATE NOT NULL, is_admin BOOLEAN NOT NULL, CONSTRAINT FK_A743AC56F77D927C FOREIGN KEY (panier_id) REFERENCES i23_paniers (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO i23_utilisateurs (id, login, roles, password, nom, prenom, date_de_naissance, is_admin) SELECT id, login, roles, password, nom, prenom, date_de_naissance, is_admin FROM __temp__i23_utilisateurs');
        $this->addSql('DROP TABLE __temp__i23_utilisateurs');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A743AC56AA08CB10 ON i23_utilisateurs (login)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A743AC56F77D927C ON i23_utilisateurs (panier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE i23_produits_paniers');
        $this->addSql('CREATE TEMPORARY TABLE __temp__i23_utilisateurs AS SELECT id, login, roles, password, nom, prenom, date_de_naissance, is_admin FROM i23_utilisateurs');
        $this->addSql('DROP TABLE i23_utilisateurs');
        $this->addSql('CREATE TABLE i23_utilisateurs (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, nom VARCHAR(200) NOT NULL, prenom VARCHAR(200) NOT NULL, date_de_naissance DATE NOT NULL, is_admin BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO i23_utilisateurs (id, login, roles, password, nom, prenom, date_de_naissance, is_admin) SELECT id, login, roles, password, nom, prenom, date_de_naissance, is_admin FROM __temp__i23_utilisateurs');
        $this->addSql('DROP TABLE __temp__i23_utilisateurs');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A743AC56AA08CB10 ON i23_utilisateurs (login)');
    }
}
