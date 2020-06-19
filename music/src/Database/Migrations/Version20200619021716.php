<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200619021716 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE music_artists (id UUID NOT NULL, login TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AC271265AA08CB10 ON music_artists (login)');
        $this->addSql('COMMENT ON COLUMN music_artists.id IS \'(DC2Type:music_artist_id)\'');
        $this->addSql('COMMENT ON COLUMN music_artists.login IS \'(DC2Type:music_artist_login)\'');
        $this->addSql('CREATE TABLE music_songs (id UUID NOT NULL, artist_id UUID NOT NULL, name TEXT NOT NULL, status TEXT NOT NULL, date_upload TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_update TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, file_path VARCHAR(255) NOT NULL, file_format VARCHAR(16) NOT NULL, file_size VARCHAR(16) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DD65CA53B7970CF8 ON music_songs (artist_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DD65CA535E237E06 ON music_songs (name)');
        $this->addSql('COMMENT ON COLUMN music_songs.id IS \'(DC2Type:music_song_id)\'');
        $this->addSql('COMMENT ON COLUMN music_songs.artist_id IS \'(DC2Type:music_artist_id)\'');
        $this->addSql('COMMENT ON COLUMN music_songs.name IS \'(DC2Type:music_song_name)\'');
        $this->addSql('COMMENT ON COLUMN music_songs.status IS \'(DC2Type:music_song_status)\'');
        $this->addSql('COMMENT ON COLUMN music_songs.date_upload IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN music_songs.date_update IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE music_songs ADD CONSTRAINT FK_DD65CA53B7970CF8 FOREIGN KEY (artist_id) REFERENCES music_artists (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE music_songs DROP CONSTRAINT FK_DD65CA53B7970CF8');
        $this->addSql('DROP TABLE music_artists');
        $this->addSql('DROP TABLE music_songs');
    }
}
