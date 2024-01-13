<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230423212834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE i23_produits_paniers');
        $this->addSql('CREATE TEMPORARY TABLE __temp__i23_paniers AS SELECT id FROM i23_paniers');
        $this->addSql('DROP TABLE i23_paniers');
        $this->addSql('CREATE TABLE i23_paniers (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, produits_id INTEGER DEFAULT NULL, quantite INTEGER DEFAULT NULL, CONSTRAINT FK_62571961CD11A2CF FOREIGN KEY (produits_id) REFERENCES i23_produits (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO i23_paniers (id) SELECT id FROM __temp__i23_paniers');
        $this->addSql('DROP TABLE __temp__i23_paniers');
        $this->addSql('CREATE INDEX IDX_62571961CD11A2CF ON i23_paniers (produits_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE i23_produits_paniers (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_produit INTEGER NOT NULL, id_panier INTEGER NOT NULL, prix_unitaire DOUBLE PRECISION NOT NULL, CONSTRAINT FK_11594227F7384557 FOREIGN KEY (id_produit) REFERENCES i23_produits (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_115942272FBB81F FOREIGN KEY (id_panier) REFERENCES i23_paniers (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_11594227F73845572FBB81F ON i23_produits_paniers (id_produit, id_panier)');
        $this->addSql('CREATE INDEX IDX_115942272FBB81F ON i23_produits_paniers (id_panier)');
        $this->addSql('CREATE INDEX IDX_11594227F7384557 ON i23_produits_paniers (id_produit)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__i23_paniers AS SELECT id FROM i23_paniers');
        $this->addSql('DROP TABLE i23_paniers');
        $this->addSql('CREATE TABLE i23_paniers (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('INSERT INTO i23_paniers (id) SELECT id FROM __temp__i23_paniers');
        $this->addSql('DROP TABLE __temp__i23_paniers');
    }
}
