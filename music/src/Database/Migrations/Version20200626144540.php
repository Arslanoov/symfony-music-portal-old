<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200626144540 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE music_albums (id UUID NOT NULL, artist_id UUID NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, release_year INT NOT NULL, cover_photo VARCHAR(255) DEFAULT NULL, description VARCHAR(512) NOT NULL, status VARCHAR(64) NOT NULL, type VARCHAR(64) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_613A84B6B7970CF8 ON music_albums (artist_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_613A84B62B36786B989D9B62 ON music_albums (title, slug)');
        $this->addSql('COMMENT ON COLUMN music_albums.id IS \'(DC2Type:music_album_id)\'');
        $this->addSql('COMMENT ON COLUMN music_albums.artist_id IS \'(DC2Type:music_artist_id)\'');
        $this->addSql('COMMENT ON COLUMN music_albums.title IS \'(DC2Type:music_album_title)\'');
        $this->addSql('COMMENT ON COLUMN music_albums.slug IS \'(DC2Type:music_album_slug)\'');
        $this->addSql('COMMENT ON COLUMN music_albums.created_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN music_albums.release_year IS \'(DC2Type:music_album_release_year)\'');
        $this->addSql('COMMENT ON COLUMN music_albums.cover_photo IS \'(DC2Type:music_album_cover_photo)\'');
        $this->addSql('COMMENT ON COLUMN music_albums.description IS \'(DC2Type:music_album_description)\'');
        $this->addSql('COMMENT ON COLUMN music_albums.status IS \'(DC2Type:music_album_status)\'');
        $this->addSql('COMMENT ON COLUMN music_albums.type IS \'(DC2Type:music_album_type)\'');
        $this->addSql('ALTER TABLE music_albums ADD CONSTRAINT FK_613A84B6B7970CF8 FOREIGN KEY (artist_id) REFERENCES music_artists (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE music_albums');
    }
}
