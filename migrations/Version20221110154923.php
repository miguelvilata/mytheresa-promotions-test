<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221110154923 extends AbstractMigration
{
    private $jsonData = '{
"products": [
{
"sku": "000001",
"name": "BV Lean leather ankle boots",
"category": "boots",
"price": 89000
},
{
"sku": "000002",
"name": "BV Lean leather ankle boots",
"category": "boots",
"price": 99000
},
{
"sku": "000003",
"name": "Ashlington leather ankle boots",
"category": "boots",
"price": 71000
},
{
"sku": "000004",
"name": "Naima embellished suede sandals",
"category": "sandals",
"price": 79500
},
{
"sku": "000005",
"name": "Nathane leather sneakers",
"category": "sneakers",
"price": 59000
}
]
}';


    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
