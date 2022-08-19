<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220818141553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE customers_phones_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE customers_phones (id INT NOT NULL, phones_numbers_phone_number NUMERIC(14, 0) DEFAULT NULL, customers_id VARCHAR(255) DEFAULT NULL, customers_customer_types_id INT DEFAULT NULL, customers_identifier_types_id INT DEFAULT NULL, countries_phone_code_id INT DEFAULT NULL, created_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A81F1AD12CAD9473 ON customers_phones (phones_numbers_phone_number)');
        $this->addSql('CREATE INDEX IDX_A81F1AD1C3568B40CB8DDDCF3ECD0E5C ON customers_phones (customers_id, customers_customer_types_id, customers_identifier_types_id)');
        $this->addSql('CREATE INDEX IDX_A81F1AD1DC30CC4B ON customers_phones (countries_phone_code_id)');
        $this->addSql('CREATE TABLE phones_numbers (phone_number NUMERIC(14, 0) NOT NULL, countries_phone_code_id INT DEFAULT NULL, created_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(phone_number))');
        $this->addSql('CREATE INDEX IDX_AF54493FDC30CC4B ON phones_numbers (countries_phone_code_id)');
        $this->addSql('ALTER TABLE customers_phones ADD CONSTRAINT FK_A81F1AD12CAD9473 FOREIGN KEY (phones_numbers_phone_number) REFERENCES phones_numbers (phone_number) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE customers_phones ADD CONSTRAINT FK_A81F1AD1C3568B40CB8DDDCF3ECD0E5C FOREIGN KEY (customers_id, customers_customer_types_id, customers_identifier_types_id) REFERENCES customers (id, customer_types_id, identifier_types_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE customers_phones ADD CONSTRAINT FK_A81F1AD1DC30CC4B FOREIGN KEY (countries_phone_code_id) REFERENCES countries_phone_code (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE phones_numbers ADD CONSTRAINT FK_AF54493FDC30CC4B FOREIGN KEY (countries_phone_code_id) REFERENCES countries_phone_code (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE customers_phones DROP CONSTRAINT FK_A81F1AD12CAD9473');
        $this->addSql('DROP SEQUENCE customers_phones_id_seq CASCADE');
        $this->addSql('DROP TABLE customers_phones');
        $this->addSql('DROP TABLE phones_numbers');
    }
}
