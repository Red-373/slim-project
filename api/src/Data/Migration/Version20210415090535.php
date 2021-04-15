<?php

declare(strict_types=1);

namespace App\Data\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210415090535 extends AbstractMigration
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
        $this->addSql('CREATE TABLE oauth_access_tokens (identifier VARCHAR(80) NOT NULL, expiry_date_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, user_identifier UUID NOT NULL, client VARCHAR(255) NOT NULL, scopes JSON NOT NULL, PRIMARY KEY(identifier))');
        $this->addSql('COMMENT ON COLUMN oauth_access_tokens.expiry_date_time IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN oauth_access_tokens.user_identifier IS \'(DC2Type:uuid_type)\'');
        $this->addSql('COMMENT ON COLUMN oauth_access_tokens.client IS \'(DC2Type:oauth_client)\'');
        $this->addSql('CREATE TABLE oauth_refresh_tokens (identifier VARCHAR(80) NOT NULL, access_token_identifier VARCHAR(80) NOT NULL, expiry_date_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(identifier))');
        $this->addSql('CREATE INDEX IDX_5AB6878E5675DC ON oauth_refresh_tokens (access_token_identifier)');
        $this->addSql('CREATE TABLE product (id UUID NOT NULL, category_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
        $this->addSql('COMMENT ON COLUMN product.id IS \'(DC2Type:uuid_type)\'');
        $this->addSql('COMMENT ON COLUMN product.category_id IS \'(DC2Type:uuid_type)\'');
        $this->addSql('COMMENT ON COLUMN product.name IS \'(DC2Type:product_name_type)\'');
        $this->addSql('COMMENT ON COLUMN product.description IS \'(DC2Type:product_description_type)\'');
        $this->addSql('COMMENT ON COLUMN product.price IS \'(DC2Type:product_price_type)\'');
        $this->addSql('CREATE TABLE products_tags (product_id UUID NOT NULL, tag_id UUID NOT NULL, PRIMARY KEY(product_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_E3AB5A2C4584665A ON products_tags (product_id)');
        $this->addSql('CREATE INDEX IDX_E3AB5A2CBAD26311 ON products_tags (tag_id)');
        $this->addSql('COMMENT ON COLUMN products_tags.product_id IS \'(DC2Type:uuid_type)\'');
        $this->addSql('COMMENT ON COLUMN products_tags.tag_id IS \'(DC2Type:uuid_type)\'');
        $this->addSql('CREATE TABLE tag (id UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_389B7835E237E06 ON tag (name)');
        $this->addSql('COMMENT ON COLUMN tag.id IS \'(DC2Type:uuid_type)\'');
        $this->addSql('COMMENT ON COLUMN tag.name IS \'(DC2Type:tag_name_type)\'');
        $this->addSql('CREATE TABLE user_users (id UUID NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6415EB1E7927C74 ON user_users (email)');
        $this->addSql('COMMENT ON COLUMN user_users.id IS \'(DC2Type:uuid_type)\'');
        $this->addSql('COMMENT ON COLUMN user_users.email IS \'(DC2Type:user_email)\'');
        $this->addSql('COMMENT ON COLUMN user_users.password IS \'(DC2Type:user_password)\'');
        $this->addSql('ALTER TABLE oauth_refresh_tokens ADD CONSTRAINT FK_5AB6878E5675DC FOREIGN KEY (access_token_identifier) REFERENCES oauth_access_tokens (identifier) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products_tags ADD CONSTRAINT FK_E3AB5A2C4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products_tags ADD CONSTRAINT FK_E3AB5A2CBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE oauth_refresh_tokens DROP CONSTRAINT FK_5AB6878E5675DC');
        $this->addSql('ALTER TABLE products_tags DROP CONSTRAINT FK_E3AB5A2C4584665A');
        $this->addSql('ALTER TABLE products_tags DROP CONSTRAINT FK_E3AB5A2CBAD26311');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE oauth_access_tokens');
        $this->addSql('DROP TABLE oauth_refresh_tokens');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE products_tags');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE user_users');
    }
}
