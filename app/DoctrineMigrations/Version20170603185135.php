<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170603185135 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cards ADD creator VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE cards ADD CONSTRAINT FK_4C258FDBC06EA63 FOREIGN KEY (creator) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_4C258FDBC06EA63 ON cards (creator)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cards DROP FOREIGN KEY FK_4C258FDBC06EA63');
        $this->addSql('DROP INDEX IDX_4C258FDBC06EA63 ON cards');
        $this->addSql('ALTER TABLE cards DROP creator');
    }
}
