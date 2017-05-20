<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170520223945 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cards CHANGE water_cold water_cold DOUBLE PRECISION NOT NULL, CHANGE water_hot water_hot DOUBLE PRECISION NOT NULL, CHANGE electricity_day electricity_day DOUBLE PRECISION NOT NULL, CHANGE electricity_night electricity_night DOUBLE PRECISION NOT NULL');
        $this->addSql('DROP INDEX UNIQ_1483A5E992FC23A8 ON users');
        $this->addSql('DROP INDEX UNIQ_1483A5E9A0D96FBF ON users');
        $this->addSql('DROP INDEX UNIQ_1483A5E9C05FB297 ON users');
        $this->addSql('ALTER TABLE users ADD token VARCHAR(32) NOT NULL, ADD registration_date DATETIME NOT NULL, DROP username, DROP username_canonical, DROP email_canonical, DROP enabled, DROP salt, DROP last_login, DROP confirmation_token, DROP password_requested_at, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE roles roles LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE password name VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E95E237E06 ON users (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E95F37A13B ON users (token)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cards CHANGE water_cold water_cold INT NOT NULL, CHANGE water_hot water_hot INT NOT NULL, CHANGE electricity_day electricity_day INT NOT NULL, CHANGE electricity_night electricity_night INT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_1483A5E95E237E06 ON users');
        $this->addSql('DROP INDEX UNIQ_1483A5E9E7927C74 ON users');
        $this->addSql('DROP INDEX UNIQ_1483A5E95F37A13B ON users');
        $this->addSql('ALTER TABLE users ADD username VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, ADD username_canonical VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, ADD email_canonical VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, ADD enabled TINYINT(1) NOT NULL, ADD salt VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD last_login DATETIME DEFAULT NULL, ADD confirmation_token VARCHAR(180) DEFAULT NULL COLLATE utf8_unicode_ci, ADD password_requested_at DATETIME DEFAULT NULL, DROP token, DROP registration_date, CHANGE email email VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', CHANGE name password VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E992FC23A8 ON users (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9A0D96FBF ON users (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9C05FB297 ON users (confirmation_token)');
    }
}
