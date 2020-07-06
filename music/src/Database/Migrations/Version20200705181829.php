<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200705181829 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE music_songs ADD album_id UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE music_songs ADD genre_id UUID NOT NULL');
        $this->addSql('ALTER TABLE music_songs ADD download_url TEXT NOT NULL');
        $this->addSql('ALTER TABLE music_songs ADD download_status TEXT NOT NULL');
        $this->addSql('ALTER TABLE music_songs ADD views_count INT NOT NULL');
        $this->addSql('COMMENT ON COLUMN music_songs.album_id IS \'(DC2Type:music_album_id)\'');
        $this->addSql('COMMENT ON COLUMN music_songs.genre_id IS \'(DC2Type:music_genre_id)\'');
        $this->addSql('COMMENT ON COLUMN music_songs.download_url IS \'(DC2Type:music_song_download_url)\'');
        $this->addSql('COMMENT ON COLUMN music_songs.download_status IS \'(DC2Type:music_song_download_status)\'');
        $this->addSql('ALTER TABLE music_songs ADD CONSTRAINT FK_DD65CA531137ABCF FOREIGN KEY (album_id) REFERENCES music_albums (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE music_songs ADD CONSTRAINT FK_DD65CA534296D31F FOREIGN KEY (genre_id) REFERENCES music_genres (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_DD65CA531137ABCF ON music_songs (album_id)');
        $this->addSql('CREATE INDEX IDX_DD65CA534296D31F ON music_songs (genre_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE music_songs DROP CONSTRAINT FK_DD65CA531137ABCF');
        $this->addSql('ALTER TABLE music_songs DROP CONSTRAINT FK_DD65CA534296D31F');
        $this->addSql('DROP INDEX IDX_DD65CA531137ABCF');
        $this->addSql('DROP INDEX IDX_DD65CA534296D31F');
        $this->addSql('ALTER TABLE music_songs DROP album_id');
        $this->addSql('ALTER TABLE music_songs DROP genre_id');
        $this->addSql('ALTER TABLE music_songs DROP download_url');
        $this->addSql('ALTER TABLE music_songs DROP download_status');
        $this->addSql('ALTER TABLE music_songs DROP views_count');
    }
}
