<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200620160815 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_users (id UUID NOT NULL, login VARCHAR(32) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(32) NOT NULL, status VARCHAR(16) NOT NULL, confirm_token_token VARCHAR(128) DEFAULT NULL, info_about_me VARCHAR(512) DEFAULT NULL, info_country VARCHAR(64) DEFAULT NULL, info_sex VARCHAR(16) DEFAULT NULL, info_age SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6415EB1AA08CB10 ON user_users (login)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6415EB1E7927C74 ON user_users (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6415EB1F464BC96 ON user_users (confirm_token_token)');
        $this->addSql('COMMENT ON COLUMN user_users.id IS \'(DC2Type:user_user_id)\'');
        $this->addSql('COMMENT ON COLUMN user_users.login IS \'(DC2Type:user_user_login)\'');
        $this->addSql('COMMENT ON COLUMN user_users.email IS \'(DC2Type:user_user_email)\'');
        $this->addSql('COMMENT ON COLUMN user_users.password IS \'(DC2Type:user_user_password)\'');
        $this->addSql('COMMENT ON COLUMN user_users.status IS \'(DC2Type:user_user_status)\'');
        $this->addSql('COMMENT ON COLUMN user_users.confirm_token_token IS \'(DC2Type:user_user_confirm_token)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE user_users');
    }
}
