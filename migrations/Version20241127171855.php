<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241127171855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE lost_animal_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE lost_animal (id INT NOT NULL, animal_id_id INT DEFAULT NULL, description TEXT NOT NULL, peureux BOOLEAN NOT NULL, agressif BOOLEAN NOT NULL, lieu VARCHAR(255) NOT NULL, lon NUMERIC(10, 10) NOT NULL, lat NUMERIC(10, 10) NOT NULL, numero_icad INT NOT NULL, trouver BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FE6591765EB747A3 ON lost_animal (animal_id_id)');
        $this->addSql('ALTER TABLE lost_animal ADD CONSTRAINT FK_FE6591765EB747A3 FOREIGN KEY (animal_id_id) REFERENCES animals (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE lost_animal_id_seq CASCADE');
        $this->addSql('ALTER TABLE lost_animal DROP CONSTRAINT FK_FE6591765EB747A3');
        $this->addSql('DROP TABLE lost_animal');
    }
}
