<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240521143618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create initial Band table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE band (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, origin VARCHAR(30) NOT NULL, city VARCHAR(30) NOT NULL, start_year SMALLINT NOT NULL, separation_year SMALLINT DEFAULT NULL, founders VARCHAR(255) DEFAULT NULL, members SMALLINT DEFAULT NULL, musical_current VARCHAR(30) DEFAULT NULL, presentation LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE band');
    }
}
