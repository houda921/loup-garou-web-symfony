<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200606152804 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE party DROP FOREIGN KEY FK_89954EE0642B8210');
        $this->addSql('DROP INDEX UNIQ_89954EE0642B8210 ON party');
        $this->addSql('ALTER TABLE party DROP admin_id');
        $this->addSql('ALTER TABLE account DROP FOREIGN KEY FK_7D3656A43E6229E9');
        $this->addSql('DROP INDEX IDX_7D3656A43E6229E9 ON account');
        $this->addSql('ALTER TABLE account DROP party_is_playing_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE player');
        $this->addSql('ALTER TABLE account ADD party_is_playing_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A43E6229E9 FOREIGN KEY (party_is_playing_id) REFERENCES party (id)');
        $this->addSql('CREATE INDEX IDX_7D3656A43E6229E9 ON account (party_is_playing_id)');
        $this->addSql('ALTER TABLE party ADD admin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE party ADD CONSTRAINT FK_89954EE0642B8210 FOREIGN KEY (admin_id) REFERENCES account (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_89954EE0642B8210 ON party (admin_id)');
    }
}
