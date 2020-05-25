<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200522172202 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, manufacturer VARCHAR(127) NOT NULL, model VARCHAR(127) NOT NULL, vin VARCHAR(127) NOT NULL, engine VARCHAR(127) NOT NULL, year VARCHAR(127) NOT NULL, UNIQUE INDEX UNIQ_773DE69DB1085141 (vin), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_customer (car_id INT NOT NULL, customer_id INT NOT NULL, INDEX IDX_E0FBB0DC3C6F69F (car_id), INDEX IDX_E0FBB0D9395C3F3 (customer_id), PRIMARY KEY(car_id, customer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, surname VARCHAR(127) NOT NULL, name VARCHAR(127) NOT NULL, patronymic VARCHAR(127) DEFAULT NULL, phone VARCHAR(127) NOT NULL, discount VARCHAR(127) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE done_work (id INT AUTO_INCREMENT NOT NULL, work_id INT DEFAULT NULL, order_id INT DEFAULT NULL, count_of_work VARCHAR(127) NOT NULL, price VARCHAR(127) NOT NULL, INDEX IDX_A5B430C6BB3453DB (work_id), INDEX IDX_A5B430C68D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE done_works_employers (done_work_id INT NOT NULL, employee_id INT NOT NULL, INDEX IDX_CB9A1791E0296E01 (done_work_id), INDEX IDX_CB9A17918C03F15C (employee_id), PRIMARY KEY(done_work_id, employee_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, position_id INT DEFAULT NULL, created DATETIME NOT NULL, start_date DATE NOT NULL, surname VARCHAR(127) NOT NULL, name VARCHAR(127) NOT NULL, patronymic VARCHAR(127) DEFAULT NULL, phone VARCHAR(127) NOT NULL, INDEX IDX_5D9F75A1DD842E46 (position_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, created DATETIME NOT NULL, price VARCHAR(127) NOT NULL, total_price VARCHAR(127) NOT NULL, INDEX IDX_F52993989395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE part (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, title VARCHAR(127) NOT NULL, part_number VARCHAR(127) NOT NULL, cost VARCHAR(127) NOT NULL, INDEX IDX_490F70C68D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE position (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(127) NOT NULL, type VARCHAR(127) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE position_work (position_id INT NOT NULL, work_id INT NOT NULL, INDEX IDX_40D646DEDD842E46 (position_id), INDEX IDX_40D646DEBB3453DB (work_id), PRIMARY KEY(position_id, work_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE work (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(127) NOT NULL, price VARCHAR(127) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car_customer ADD CONSTRAINT FK_E0FBB0DC3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car_customer ADD CONSTRAINT FK_E0FBB0D9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE done_work ADD CONSTRAINT FK_A5B430C6BB3453DB FOREIGN KEY (work_id) REFERENCES work (id)');
        $this->addSql('ALTER TABLE done_work ADD CONSTRAINT FK_A5B430C68D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE done_works_employers ADD CONSTRAINT FK_CB9A1791E0296E01 FOREIGN KEY (done_work_id) REFERENCES done_work (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE done_works_employers ADD CONSTRAINT FK_CB9A17918C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1DD842E46 FOREIGN KEY (position_id) REFERENCES position (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993989395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE part ADD CONSTRAINT FK_490F70C68D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE position_work ADD CONSTRAINT FK_40D646DEDD842E46 FOREIGN KEY (position_id) REFERENCES position (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE position_work ADD CONSTRAINT FK_40D646DEBB3453DB FOREIGN KEY (work_id) REFERENCES work (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car_customer DROP FOREIGN KEY FK_E0FBB0DC3C6F69F');
        $this->addSql('ALTER TABLE car_customer DROP FOREIGN KEY FK_E0FBB0D9395C3F3');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993989395C3F3');
        $this->addSql('ALTER TABLE done_works_employers DROP FOREIGN KEY FK_CB9A1791E0296E01');
        $this->addSql('ALTER TABLE done_works_employers DROP FOREIGN KEY FK_CB9A17918C03F15C');
        $this->addSql('ALTER TABLE done_work DROP FOREIGN KEY FK_A5B430C68D9F6D38');
        $this->addSql('ALTER TABLE part DROP FOREIGN KEY FK_490F70C68D9F6D38');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1DD842E46');
        $this->addSql('ALTER TABLE position_work DROP FOREIGN KEY FK_40D646DEDD842E46');
        $this->addSql('ALTER TABLE done_work DROP FOREIGN KEY FK_A5B430C6BB3453DB');
        $this->addSql('ALTER TABLE position_work DROP FOREIGN KEY FK_40D646DEBB3453DB');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE car_customer');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE done_work');
        $this->addSql('DROP TABLE done_works_employers');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE part');
        $this->addSql('DROP TABLE position');
        $this->addSql('DROP TABLE position_work');
        $this->addSql('DROP TABLE work');
    }
}
