<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240515101149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conference ADD slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_911533C82D5B0234 ON conference (city)');
        $this->addSql('ALTER TABLE product ALTER id DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_911533C82D5B0234');
        $this->addSql('ALTER TABLE conference DROP slug');
        $this->addSql('CREATE SEQUENCE product_id_seq');
        $this->addSql('SELECT setval(\'product_id_seq\', (SELECT MAX(id) FROM product))');
        $this->addSql('ALTER TABLE product ALTER id SET DEFAULT nextval(\'product_id_seq\')');
    }
}
