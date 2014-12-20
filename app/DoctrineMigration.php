<?php
namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

class VersionYYYYMMDDHHIISS extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // customize index size as you want...
        $this->addSql("CREATE INDEX idx_url_shortener_link_long_url ON image (long_url(20))");
    }

    public function down(Schema $schema)
    {
        $this->addSql("DROP INDEX idx_url_shortener_link_long_url ON link;");
    }
}
