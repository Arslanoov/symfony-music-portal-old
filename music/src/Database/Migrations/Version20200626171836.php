<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200626171836 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE music_albums ADD songs_count INT NOT NULL');
        $this->addSql('ALTER TABLE music_albums ADD listen_statistics_all INT NOT NULL');
        $this->addSql('ALTER TABLE music_albums ADD listen_statistics_today INT NOT NULL');
        $this->addSql('ALTER TABLE music_albums ADD listen_statistics_week INT NOT NULL');
        $this->addSql('ALTER TABLE music_albums ADD listen_statistics_month INT NOT NULL');
        $this->addSql('ALTER TABLE music_albums ADD download_statistics_all INT NOT NULL');
        $this->addSql('ALTER TABLE music_albums ADD download_statistics_today INT NOT NULL');
        $this->addSql('ALTER TABLE music_albums ADD download_statistics_week INT NOT NULL');
        $this->addSql('ALTER TABLE music_albums ADD download_statistics_month INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE music_albums DROP songs_count');
        $this->addSql('ALTER TABLE music_albums DROP listen_statistics_all');
        $this->addSql('ALTER TABLE music_albums DROP listen_statistics_today');
        $this->addSql('ALTER TABLE music_albums DROP listen_statistics_week');
        $this->addSql('ALTER TABLE music_albums DROP listen_statistics_month');
        $this->addSql('ALTER TABLE music_albums DROP download_statistics_all');
        $this->addSql('ALTER TABLE music_albums DROP download_statistics_today');
        $this->addSql('ALTER TABLE music_albums DROP download_statistics_week');
        $this->addSql('ALTER TABLE music_albums DROP download_statistics_month');
    }
}
