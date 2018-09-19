<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180919230046_SEED_insert_cities extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("INSERT INTO cities (name, zip) VALUES ('Berlin', '10115');");
        $this->addSql("INSERT INTO cities (name, zip) VALUES ('Porta Westfalica', '32457');");
        $this->addSql("INSERT INTO cities (name, zip) VALUES ('Lommatzsch', '01623');");
        $this->addSql("INSERT INTO cities (name, zip) VALUES ('Hamburg', '21521');");
        $this->addSql("INSERT INTO cities (name, zip) VALUES ('Bülzig', '06895');");
        $this->addSql("INSERT INTO cities (name, zip) VALUES ('Diesbar-Seußlitz', '01612');");

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
