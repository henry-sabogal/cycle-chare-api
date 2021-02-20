<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210218172621 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bike (id INT AUTO_INCREMENT NOT NULL, station_id INT DEFAULT NULL, state VARCHAR(15) DEFAULT NULL, INDEX IDX_4CBC378021BDB235 (station_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE station (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) DEFAULT NULL, lon DOUBLE PRECISION DEFAULT NULL, lat DOUBLE PRECISION DEFAULT NULL, station_id VARCHAR(10) DEFAULT NULL, current_dock_count INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trip (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, bike_id INT DEFAULT NULL, from_station_id_id INT DEFAULT NULL, to_station_id_id INT DEFAULT NULL, state VARCHAR(10) DEFAULT NULL, trip_date DATE DEFAULT NULL, INDEX IDX_7656F53BA76ED395 (user_id), INDEX IDX_7656F53BD5A4816F (bike_id), INDEX IDX_7656F53B6E96E0F6 (from_station_id_id), INDEX IDX_7656F53BA873EA3D (to_station_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(100) DEFAULT NULL, name VARCHAR(100) DEFAULT NULL, surname VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bike ADD CONSTRAINT FK_4CBC378021BDB235 FOREIGN KEY (station_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53BD5A4816F FOREIGN KEY (bike_id) REFERENCES bike (id)');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53B6E96E0F6 FOREIGN KEY (from_station_id_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53BA873EA3D FOREIGN KEY (to_station_id_id) REFERENCES station (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53BD5A4816F');
        $this->addSql('ALTER TABLE bike DROP FOREIGN KEY FK_4CBC378021BDB235');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53B6E96E0F6');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53BA873EA3D');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53BA76ED395');
        $this->addSql('DROP TABLE bike');
        $this->addSql('DROP TABLE station');
        $this->addSql('DROP TABLE trip');
        $this->addSql('DROP TABLE user');
    }
}
