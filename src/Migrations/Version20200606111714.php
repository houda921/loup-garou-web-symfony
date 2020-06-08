<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200606111714 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE party_account');
        $this->addSql('ALTER TABLE account CHANGE is_admin is_website_admin TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE party DROP FOREIGN KEY FK_89954EE0642B8210');
        $this->addSql('DROP INDEX IDX_89954EE0642B8210 ON party');
        $this->addSql('ALTER TABLE party DROP admin_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE party_account (party_id INT NOT NULL, account_id INT NOT NULL, INDEX IDX_6FC7C98F213C1059 (party_id), INDEX IDX_6FC7C98F9B6B5FBA (account_id), PRIMARY KEY(party_id, account_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE party_account ADD CONSTRAINT FK_6FC7C98F213C1059 FOREIGN KEY (party_id) REFERENCES party (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE party_account ADD CONSTRAINT FK_6FC7C98F9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE account CHANGE is_website_admin is_admin TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE party ADD admin_id INT NOT NULL');
        $this->addSql('ALTER TABLE party ADD CONSTRAINT FK_89954EE0642B8210 FOREIGN KEY (admin_id) REFERENCES account (id)');
        $this->addSql('CREATE INDEX IDX_89954EE0642B8210 ON party (admin_id)');
    }
}
