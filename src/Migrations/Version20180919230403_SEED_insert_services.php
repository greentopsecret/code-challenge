<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180919230403_SEED_insert_services extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("INSERT INTO services (id, name) VALUES (802030, 'Abtransport, Entsorgung und Entrümpelung');");
        $this->addSql("INSERT INTO services (id, name) VALUES (411070, 'Fensterreinigung');");
        $this->addSql("INSERT INTO services (id, name) VALUES (402020, 'Holzdielen schleifen');");
        $this->addSql("INSERT INTO services (id, name) VALUES (108140, 'Kellersanierung');");
        $this->addSql("INSERT INTO services (id, name) VALUES (804040, 'Sonstige Umzugsleistungen');");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
