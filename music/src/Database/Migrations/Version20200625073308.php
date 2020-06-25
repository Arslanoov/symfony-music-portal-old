<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200625073308 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE music_genres (id UUID NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, songs_count INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3D3326EF5E237E06989D9B62 ON music_genres (name, slug)');
        $this->addSql('COMMENT ON COLUMN music_genres.id IS \'(DC2Type:music_genre_id)\'');
        $this->addSql('COMMENT ON COLUMN music_genres.name IS \'(DC2Type:music_genre_name)\'');
        $this->addSql('COMMENT ON COLUMN music_genres.slug IS \'(DC2Type:music_genre_slug)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE music_genres');
    }
}
