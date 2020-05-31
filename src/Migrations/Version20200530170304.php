<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200530170304 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE party DROP FOREIGN KEY FK_89954EE061220EA6');
        $this->addSql('DROP INDEX IDX_89954EE061220EA6 ON party');
        $this->addSql('ALTER TABLE party CHANGE creator_id admin_id INT NOT NULL');
        $this->addSql('ALTER TABLE party ADD CONSTRAINT FK_89954EE0642B8210 FOREIGN KEY (admin_id) REFERENCES account (id)');
        $this->addSql('CREATE INDEX IDX_89954EE0642B8210 ON party (admin_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE party DROP FOREIGN KEY FK_89954EE0642B8210');
        $this->addSql('DROP INDEX IDX_89954EE0642B8210 ON party');
        $this->addSql('ALTER TABLE party CHANGE admin_id creator_id INT NOT NULL');
        $this->addSql('ALTER TABLE party ADD CONSTRAINT FK_89954EE061220EA6 FOREIGN KEY (creator_id) REFERENCES account (id)');
        $this->addSql('CREATE INDEX IDX_89954EE061220EA6 ON party (creator_id)');
    }
}
