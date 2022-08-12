<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220812224918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "references" (id INT NOT NULL, customers_id VARCHAR(255) DEFAULT NULL, customers_customer_types_id INT DEFAULT NULL, customers_identifier_types_id INT DEFAULT NULL, references_identifier_type_id INT DEFAULT NULL, references_countries_phone_code_id INT DEFAULT NULL, full_name VARCHAR(128) DEFAULT NULL, references_contact_phone NUMERIC(14, 0) DEFAULT NULL, created_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9F1E2D9CC3568B40CB8DDDCF3ECD0E5C ON "references" (customers_id, customers_customer_types_id, customers_identifier_types_id)');
        $this->addSql('CREATE INDEX IDX_9F1E2D9C3A716FF8 ON "references" (references_identifier_type_id)');
        $this->addSql('CREATE INDEX IDX_9F1E2D9CF05EB681 ON "references" (references_countries_phone_code_id)');
        $this->addSql('ALTER TABLE "references" ADD CONSTRAINT FK_9F1E2D9CC3568B40CB8DDDCF3ECD0E5C FOREIGN KEY (customers_id, customers_customer_types_id, customers_identifier_types_id) REFERENCES customers (id, customer_types_id, identifier_types_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "references" ADD CONSTRAINT FK_9F1E2D9C3A716FF8 FOREIGN KEY (references_identifier_type_id) REFERENCES identifier_types (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "references" ADD CONSTRAINT FK_9F1E2D9CF05EB681 FOREIGN KEY (references_countries_phone_code_id) REFERENCES countries_phone_code (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE "references"');
    }
}
