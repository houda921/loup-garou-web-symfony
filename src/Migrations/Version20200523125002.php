<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200523125002 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX FK_ID_Faction ON role');
        $this->addSql('ALTER TABLE role CHANGE ID id INT AUTO_INCREMENT NOT NULL, CHANGE Name name VARCHAR(255) NOT NULL, CHANGE Description description VARCHAR(255) NOT NULL, CHANGE is_unique is_unique TINYINT(1) NOT NULL, CHANGE active_at_night active_at_night TINYINT(1) NOT NULL, CHANGE image_path image_path VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE role CHANGE id ID INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE name Name VARCHAR(50) CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`, CHANGE description Description VARCHAR(1000) CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`, CHANGE is_unique is_unique TINYINT(1) DEFAULT \'1\' NOT NULL, CHANGE active_at_night active_at_night TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE image_path image_path VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`');
        $this->addSql('CREATE INDEX FK_ID_Faction ON role (id_faction)');
    }
}
