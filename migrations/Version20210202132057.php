<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210202132057 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur ADD first_name VARCHAR(255) DEFAULT NULL, ADD last_name VARCHAR(255) DEFAULT NULL, ADD address VARCHAR(255) DEFAULT NULL, ADD phone_number VARCHAR(255) DEFAULT NULL, ADD birth_date DATE DEFAULT NULL');
        $this->addSql("INSERT INTO utilisateur (username, roles, password , first_name , last_name) VALUES ('admin', '[\"ROLE_ADMIN\"]',
        '\$argon2id\$v=19\$m=65536,t=4,p=1\$cN76DbICOKVdELQ9P8WzSA\$r5OqGNQJ4hYwrrz/ykd7oW8tkatpwBGMFTU3dUulWnw', 'Marc', 'Balouzet')");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP first_name, DROP last_name, DROP address, DROP phone_number, DROP birth_date');
    }
}
