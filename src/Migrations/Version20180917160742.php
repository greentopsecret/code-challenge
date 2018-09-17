<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180917160742 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Orders DROP FOREIGN KEY FK_E283F8D8ED5CA9E6');
        $this->addSql('CREATE TABLE services (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE service');
        $this->addSql('ALTER TABLE Orders ADD CONSTRAINT FK_E52FFDEEED5CA9E6 FOREIGN KEY (service_id) REFERENCES services (id)');
        $this->addSql('ALTER TABLE Orders RENAME INDEX idx_e283f8d8ed5ca9e6 TO IDX_E52FFDEEED5CA9E6');
        $this->addSql('ALTER TABLE Orders RENAME INDEX idx_e283f8d88bac62af TO IDX_E52FFDEE8BAC62AF');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEED5CA9E6');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) DEFAULT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE services');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E283F8D8ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE orders RENAME INDEX idx_e52ffdeeed5ca9e6 TO IDX_E283F8D8ED5CA9E6');
        $this->addSql('ALTER TABLE orders RENAME INDEX idx_e52ffdee8bac62af TO IDX_E283F8D88BAC62AF');
    }
}
