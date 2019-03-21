<?php

declare(strict_types=1);

namespace App\Domain\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190321171612 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE lj_client (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lj_maker (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lj_phone (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', maker_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, stock INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_B215A3D468DA5EC3 (maker_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lj_user (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', client_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone_number VARCHAR(10) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_6E81849C19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lj_phone ADD CONSTRAINT FK_B215A3D468DA5EC3 FOREIGN KEY (maker_id) REFERENCES lj_maker (id)');
        $this->addSql('ALTER TABLE lj_user ADD CONSTRAINT FK_6E81849C19EB6921 FOREIGN KEY (client_id) REFERENCES lj_client (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lj_user DROP FOREIGN KEY FK_6E81849C19EB6921');
        $this->addSql('ALTER TABLE lj_phone DROP FOREIGN KEY FK_B215A3D468DA5EC3');
        $this->addSql('DROP TABLE lj_client');
        $this->addSql('DROP TABLE lj_maker');
        $this->addSql('DROP TABLE lj_phone');
        $this->addSql('DROP TABLE lj_user');
    }
}
