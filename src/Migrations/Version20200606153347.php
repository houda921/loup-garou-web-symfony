<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200606153347 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE player ADD party_id INT NOT NULL, ADD account_id INT NOT NULL, ADD role_id INT DEFAULT NULL, ADD is_party_admin TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65213C1059 FOREIGN KEY (party_id) REFERENCES party (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A659B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('CREATE INDEX IDX_98197A65213C1059 ON player (party_id)');
        $this->addSql('CREATE INDEX IDX_98197A659B6B5FBA ON player (account_id)');
        $this->addSql('CREATE INDEX IDX_98197A65D60322AC ON player (role_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65213C1059');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A659B6B5FBA');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65D60322AC');
        $this->addSql('DROP INDEX IDX_98197A65213C1059 ON player');
        $this->addSql('DROP INDEX IDX_98197A659B6B5FBA ON player');
        $this->addSql('DROP INDEX IDX_98197A65D60322AC ON player');
        $this->addSql('ALTER TABLE player DROP party_id, DROP account_id, DROP role_id, DROP is_party_admin');
    }
}
