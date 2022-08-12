<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220811150718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE customers_contact (id INT NOT NULL, customers_id VARCHAR(255) DEFAULT NULL, customers_customer_types_id INT DEFAULT NULL, customers_identifier_types_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_702A35DDC3568B40CB8DDDCF3ECD0E5C ON customers_contact (customers_id, customers_customer_types_id, customers_identifier_types_id)');
        $this->addSql('ALTER TABLE customers_contact ADD CONSTRAINT FK_702A35DDC3568B40CB8DDDCF3ECD0E5C FOREIGN KEY (customers_id, customers_customer_types_id, customers_identifier_types_id) REFERENCES customers (id, customer_types_id, identifier_types_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE customers_contact');
    }
}
