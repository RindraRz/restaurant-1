<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250208033025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id SERIAL NOT NULL, nom VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE ingredient (id SERIAL NOT NULL, nom VARCHAR(100) NOT NULL, unite VARCHAR(10) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE plat (id SERIAL NOT NULL, nom VARCHAR(100) NOT NULL, cusine_time INT NOT NULL, prix DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE recette (id SERIAL NOT NULL, plat_id INT NOT NULL, ingredient_id INT NOT NULL, quantite DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_49BB6390D73DB560 ON recette (plat_id)');
        $this->addSql('CREATE INDEX IDX_49BB6390933FE08C ON recette (ingredient_id)');
        $this->addSql('CREATE TABLE stock_ingredient (id SERIAL NOT NULL, ingredient_id INT NOT NULL, quantite DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C5E68FDC933FE08C ON stock_ingredient (ingredient_id)');
        $this->addSql('CREATE TABLE vente (id SERIAL NOT NULL, plat_id INT NOT NULL, quantite DOUBLE PRECISION NOT NULL, prix_unitaire DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_888A2A4CD73DB560 ON vente (plat_id)');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB6390D73DB560 FOREIGN KEY (plat_id) REFERENCES plat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB6390933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE stock_ingredient ADD CONSTRAINT FK_C5E68FDC933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vente ADD CONSTRAINT FK_888A2A4CD73DB560 FOREIGN KEY (plat_id) REFERENCES plat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON users (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_identifier_email ON "user" (email)');
        $this->addSql('ALTER TABLE recette DROP CONSTRAINT FK_49BB6390D73DB560');
        $this->addSql('ALTER TABLE recette DROP CONSTRAINT FK_49BB6390933FE08C');
        $this->addSql('ALTER TABLE stock_ingredient DROP CONSTRAINT FK_C5E68FDC933FE08C');
        $this->addSql('ALTER TABLE vente DROP CONSTRAINT FK_888A2A4CD73DB560');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE plat');
        $this->addSql('DROP TABLE recette');
        $this->addSql('DROP TABLE stock_ingredient');
        $this->addSql('DROP TABLE vente');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_EMAIL');
    }
}
