<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220811173751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customers_contact ADD contacts_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE customers_contact ADD contacts_identifier_types_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE customers_contact ADD CONSTRAINT FK_702A35DD719FB48EDC14895D FOREIGN KEY (contacts_id, contacts_identifier_types_id) REFERENCES contacts (id, identifier_types_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_702A35DD719FB48EDC14895D ON customers_contact (contacts_id, contacts_identifier_types_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE customers_contact DROP CONSTRAINT FK_702A35DD719FB48EDC14895D');
        $this->addSql('DROP INDEX IDX_702A35DD719FB48EDC14895D');
        $this->addSql('ALTER TABLE customers_contact DROP contacts_id');
        $this->addSql('ALTER TABLE customers_contact DROP contacts_identifier_types_id');
    }
}
