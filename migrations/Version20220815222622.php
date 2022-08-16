<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220815222622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE references_customers_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE customers_references_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE customers_references (id INT NOT NULL, customers_id VARCHAR(255) DEFAULT NULL, customers_customer_types_id INT DEFAULT NULL, customers_identifier_types_id INT DEFAULT NULL, references_identifier_type_id INT DEFAULT NULL, references_countries_phone_code_id INT DEFAULT NULL, full_name VARCHAR(128) DEFAULT NULL, references_contact_phone NUMERIC(14, 0) DEFAULT NULL, created_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E2256095C3568B40CB8DDDCF3ECD0E5C ON customers_references (customers_id, customers_customer_types_id, customers_identifier_types_id)');
        $this->addSql('CREATE INDEX IDX_E22560953A716FF8 ON customers_references (references_identifier_type_id)');
        $this->addSql('CREATE INDEX IDX_E2256095F05EB681 ON customers_references (references_countries_phone_code_id)');
        $this->addSql('ALTER TABLE customers_references ADD CONSTRAINT FK_E2256095C3568B40CB8DDDCF3ECD0E5C FOREIGN KEY (customers_id, customers_customer_types_id, customers_identifier_types_id) REFERENCES customers (id, customer_types_id, identifier_types_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE customers_references ADD CONSTRAINT FK_E22560953A716FF8 FOREIGN KEY (references_identifier_type_id) REFERENCES identifier_types (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE customers_references ADD CONSTRAINT FK_E2256095F05EB681 FOREIGN KEY (references_countries_phone_code_id) REFERENCES countries_phone_code (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE references_customers');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE customers_references_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE references_customers_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE references_customers (id INT NOT NULL, customers_id VARCHAR(255) DEFAULT NULL, customers_customer_types_id INT DEFAULT NULL, customers_identifier_types_id INT DEFAULT NULL, references_identifier_type_id INT DEFAULT NULL, references_countries_phone_code_id INT DEFAULT NULL, full_name VARCHAR(128) DEFAULT NULL, references_contact_phone NUMERIC(14, 0) DEFAULT NULL, created_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_f757c7633a716ff8 ON references_customers (references_identifier_type_id)');
        $this->addSql('CREATE INDEX idx_f757c763f05eb681 ON references_customers (references_countries_phone_code_id)');
        $this->addSql('CREATE INDEX idx_f757c763c3568b40cb8dddcf3ecd0e5c ON references_customers (customers_id, customers_customer_types_id, customers_identifier_types_id)');
        $this->addSql('ALTER TABLE references_customers ADD CONSTRAINT fk_f757c763c3568b40cb8dddcf3ecd0e5c FOREIGN KEY (customers_id, customers_customer_types_id, customers_identifier_types_id) REFERENCES customers (id, customer_types_id, identifier_types_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE references_customers ADD CONSTRAINT fk_f757c7633a716ff8 FOREIGN KEY (references_identifier_type_id) REFERENCES identifier_types (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE references_customers ADD CONSTRAINT fk_f757c763f05eb681 FOREIGN KEY (references_countries_phone_code_id) REFERENCES countries_phone_code (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE customers_references');
    }
}
