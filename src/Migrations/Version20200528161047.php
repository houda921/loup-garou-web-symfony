<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200528161047 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE party (id INT AUTO_INCREMENT NOT NULL, creator_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_89954EE061220EA6 (creator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE party_account (party_id INT NOT NULL, account_id INT NOT NULL, INDEX IDX_6FC7C98F213C1059 (party_id), INDEX IDX_6FC7C98F9B6B5FBA (account_id), PRIMARY KEY(party_id, account_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE party ADD CONSTRAINT FK_89954EE061220EA6 FOREIGN KEY (creator_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE party_account ADD CONSTRAINT FK_6FC7C98F213C1059 FOREIGN KEY (party_id) REFERENCES party (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE party_account ADD CONSTRAINT FK_6FC7C98F9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE account CHANGE is_admin is_admin TINYINT(1) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7D3656A4F85E0677 ON account (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7D3656A4E7927C74 ON account (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE party_account DROP FOREIGN KEY FK_6FC7C98F213C1059');
        $this->addSql('DROP TABLE party');
        $this->addSql('DROP TABLE party_account');
        $this->addSql('DROP INDEX UNIQ_7D3656A4F85E0677 ON account');
        $this->addSql('DROP INDEX UNIQ_7D3656A4E7927C74 ON account');
        $this->addSql('ALTER TABLE account CHANGE is_admin is_admin TINYINT(1) DEFAULT \'0\'');
    }
}
