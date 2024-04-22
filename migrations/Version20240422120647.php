<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240422120647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vaccine ADD week_2 BOOLEAN DEFAULT NULL');
        $this->addSql('ALTER TABLE vaccine ADD week_4 BOOLEAN DEFAULT NULL');
        $this->addSql('ALTER TABLE vaccine ADD week_6 BOOLEAN DEFAULT NULL');
        $this->addSql('ALTER TABLE vaccine ADD month_2 BOOLEAN DEFAULT NULL');
        $this->addSql('ALTER TABLE vaccine ADD month_3 BOOLEAN DEFAULT NULL');
        $this->addSql('ALTER TABLE vaccine ADD month_4 BOOLEAN DEFAULT NULL');
        $this->addSql('ALTER TABLE vaccine ADD month_5 BOOLEAN DEFAULT NULL');
        $this->addSql('ALTER TABLE vaccine ADD month_6 BOOLEAN DEFAULT NULL');
        $this->addSql('ALTER TABLE vaccine ADD year_1 BOOLEAN DEFAULT NULL');
        $this->addSql('ALTER TABLE vaccine ADD annual_recall BOOLEAN DEFAULT NULL');
        $this->addSql('ALTER TABLE vaccine ADD annual_3_recall BOOLEAN DEFAULT NULL');
        $this->addSql('ALTER TABLE vaccine DROP recall');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE vaccine ADD recall DATE NOT NULL');
        $this->addSql('ALTER TABLE vaccine DROP week_2');
        $this->addSql('ALTER TABLE vaccine DROP week_4');
        $this->addSql('ALTER TABLE vaccine DROP week_6');
        $this->addSql('ALTER TABLE vaccine DROP month_2');
        $this->addSql('ALTER TABLE vaccine DROP month_3');
        $this->addSql('ALTER TABLE vaccine DROP month_4');
        $this->addSql('ALTER TABLE vaccine DROP month_5');
        $this->addSql('ALTER TABLE vaccine DROP month_6');
        $this->addSql('ALTER TABLE vaccine DROP year_1');
        $this->addSql('ALTER TABLE vaccine DROP annual_recall');
        $this->addSql('ALTER TABLE vaccine DROP annual_3_recall');
    }
}
