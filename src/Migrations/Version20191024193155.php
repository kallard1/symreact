<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191024193155 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, status_id INT NOT NULL, user_id INT DEFAULT NULL, count VARCHAR(6) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, sent_at DATETIME DEFAULT NULL, INDEX IDX_906517449395C3F3 (customer_id), INDEX IDX_906517446BF700BD (status_id), INDEX IDX_90651744A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice_product (invoice_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_2193327E2989F1FD (invoice_id), INDEX IDX_2193327E4584665A (product_id), PRIMARY KEY(invoice_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_906517449395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_906517446BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_90651744A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE invoice_product ADD CONSTRAINT FK_2193327E2989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE invoice_product ADD CONSTRAINT FK_2193327E4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE category CHANGE user_id user_id INT DEFAULT NULL, CHANGE enabled enabled TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE enabled enabled TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE invoice_product DROP FOREIGN KEY FK_2193327E2989F1FD');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE invoice_product');
        $this->addSql('ALTER TABLE category CHANGE user_id user_id INT DEFAULT NULL, CHANGE enabled enabled TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE product CHANGE enabled enabled TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
