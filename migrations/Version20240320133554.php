<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240320133554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE advice_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE animals_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE breed_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE participant_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ride_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE vaccinated_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE vaccine_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE advice (id INT NOT NULL, user_id_id INT DEFAULT NULL, breed_id_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content TEXT NOT NULL, category VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_64820E8D9D86650F ON advice (user_id_id)');
        $this->addSql('CREATE INDEX IDX_64820E8D243B1A1A ON advice (breed_id_id)');
        $this->addSql('CREATE TABLE animals (id INT NOT NULL, breed_id_id INT DEFAULT NULL, user_id_id INT NOT NULL, name VARCHAR(255) NOT NULL, birthday DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_966C69DD243B1A1A ON animals (breed_id_id)');
        $this->addSql('CREATE INDEX IDX_966C69DD9D86650F ON animals (user_id_id)');
        $this->addSql('CREATE TABLE breed (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE participant (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE participant_user (participant_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(participant_id, user_id))');
        $this->addSql('CREATE INDEX IDX_5927C4779D1C3019 ON participant_user (participant_id)');
        $this->addSql('CREATE INDEX IDX_5927C477A76ED395 ON participant_user (user_id)');
        $this->addSql('CREATE TABLE participant_ride (participant_id INT NOT NULL, ride_id INT NOT NULL, PRIMARY KEY(participant_id, ride_id))');
        $this->addSql('CREATE INDEX IDX_4F896EEE9D1C3019 ON participant_ride (participant_id)');
        $this->addSql('CREATE INDEX IDX_4F896EEE302A8A70 ON participant_ride (ride_id)');
        $this->addSql('CREATE TABLE ride (id INT NOT NULL, user_creator_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, location VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9B3D7CD0C645C84A ON ride (user_creator_id)');
        $this->addSql('CREATE TABLE vaccinated (id INT NOT NULL, next_recall DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE vaccinated_animals (vaccinated_id INT NOT NULL, animals_id INT NOT NULL, PRIMARY KEY(vaccinated_id, animals_id))');
        $this->addSql('CREATE INDEX IDX_8D5382E6A131834D ON vaccinated_animals (vaccinated_id)');
        $this->addSql('CREATE INDEX IDX_8D5382E6132B9E58 ON vaccinated_animals (animals_id)');
        $this->addSql('CREATE TABLE vaccinated_vaccine (vaccinated_id INT NOT NULL, vaccine_id INT NOT NULL, PRIMARY KEY(vaccinated_id, vaccine_id))');
        $this->addSql('CREATE INDEX IDX_BCE27B8AA131834D ON vaccinated_vaccine (vaccinated_id)');
        $this->addSql('CREATE INDEX IDX_BCE27B8A2BFE75C3 ON vaccinated_vaccine (vaccine_id)');
        $this->addSql('CREATE TABLE vaccine (id INT NOT NULL, name VARCHAR(255) NOT NULL, recall DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE advice ADD CONSTRAINT FK_64820E8D9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE advice ADD CONSTRAINT FK_64820E8D243B1A1A FOREIGN KEY (breed_id_id) REFERENCES breed (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE animals ADD CONSTRAINT FK_966C69DD243B1A1A FOREIGN KEY (breed_id_id) REFERENCES breed (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE animals ADD CONSTRAINT FK_966C69DD9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE participant_user ADD CONSTRAINT FK_5927C4779D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE participant_user ADD CONSTRAINT FK_5927C477A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE participant_ride ADD CONSTRAINT FK_4F896EEE9D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE participant_ride ADD CONSTRAINT FK_4F896EEE302A8A70 FOREIGN KEY (ride_id) REFERENCES ride (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ride ADD CONSTRAINT FK_9B3D7CD0C645C84A FOREIGN KEY (user_creator_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vaccinated_animals ADD CONSTRAINT FK_8D5382E6A131834D FOREIGN KEY (vaccinated_id) REFERENCES vaccinated (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vaccinated_animals ADD CONSTRAINT FK_8D5382E6132B9E58 FOREIGN KEY (animals_id) REFERENCES animals (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vaccinated_vaccine ADD CONSTRAINT FK_BCE27B8AA131834D FOREIGN KEY (vaccinated_id) REFERENCES vaccinated (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vaccinated_vaccine ADD CONSTRAINT FK_BCE27B8A2BFE75C3 FOREIGN KEY (vaccine_id) REFERENCES vaccine (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE advice_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE animals_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE breed_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE participant_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ride_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE vaccinated_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE vaccine_id_seq CASCADE');
        $this->addSql('ALTER TABLE advice DROP CONSTRAINT FK_64820E8D9D86650F');
        $this->addSql('ALTER TABLE advice DROP CONSTRAINT FK_64820E8D243B1A1A');
        $this->addSql('ALTER TABLE animals DROP CONSTRAINT FK_966C69DD243B1A1A');
        $this->addSql('ALTER TABLE animals DROP CONSTRAINT FK_966C69DD9D86650F');
        $this->addSql('ALTER TABLE participant_user DROP CONSTRAINT FK_5927C4779D1C3019');
        $this->addSql('ALTER TABLE participant_user DROP CONSTRAINT FK_5927C477A76ED395');
        $this->addSql('ALTER TABLE participant_ride DROP CONSTRAINT FK_4F896EEE9D1C3019');
        $this->addSql('ALTER TABLE participant_ride DROP CONSTRAINT FK_4F896EEE302A8A70');
        $this->addSql('ALTER TABLE ride DROP CONSTRAINT FK_9B3D7CD0C645C84A');
        $this->addSql('ALTER TABLE vaccinated_animals DROP CONSTRAINT FK_8D5382E6A131834D');
        $this->addSql('ALTER TABLE vaccinated_animals DROP CONSTRAINT FK_8D5382E6132B9E58');
        $this->addSql('ALTER TABLE vaccinated_vaccine DROP CONSTRAINT FK_BCE27B8AA131834D');
        $this->addSql('ALTER TABLE vaccinated_vaccine DROP CONSTRAINT FK_BCE27B8A2BFE75C3');
        $this->addSql('DROP TABLE advice');
        $this->addSql('DROP TABLE animals');
        $this->addSql('DROP TABLE breed');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE participant_user');
        $this->addSql('DROP TABLE participant_ride');
        $this->addSql('DROP TABLE ride');
        $this->addSql('DROP TABLE vaccinated');
        $this->addSql('DROP TABLE vaccinated_animals');
        $this->addSql('DROP TABLE vaccinated_vaccine');
        $this->addSql('DROP TABLE vaccine');
    }
}
