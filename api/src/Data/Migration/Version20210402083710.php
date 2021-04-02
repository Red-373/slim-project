<?php

declare(strict_types=1);

namespace App\Data\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210402083710 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C15E237E06 ON category (name)');
        $this->addSql('COMMENT ON COLUMN category.id IS \'(DC2Type:uuid_type)\'');
        $this->addSql('COMMENT ON COLUMN category.name IS \'(DC2Type:category_name_type)\'');
        $this->addSql('CREATE TABLE product (id UUID NOT NULL, category_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD5E237E06 ON product (name)');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
        $this->addSql('COMMENT ON COLUMN product.id IS \'(DC2Type:uuid_type)\'');
        $this->addSql('COMMENT ON COLUMN product.category_id IS \'(DC2Type:uuid_type)\'');
        $this->addSql('COMMENT ON COLUMN product.name IS \'(DC2Type:product_name_type)\'');
        $this->addSql('COMMENT ON COLUMN product.description IS \'(DC2Type:product_description_type)\'');
        $this->addSql('COMMENT ON COLUMN product.price IS \'(DC2Type:product_price_type)\'');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04AD12469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE product');
    }
}
