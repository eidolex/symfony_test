<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241206154540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, total DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking_session (booking_id INT NOT NULL, session_id INT NOT NULL, INDEX IDX_8AFA90F43301C60 (booking_id), INDEX IDX_8AFA90F4613FECDF (session_id), PRIMARY KEY(booking_id, session_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, trainer VARCHAR(255) NOT NULL, time DATETIME NOT NULL, price DOUBLE PRECISION NOT NULL, is_available TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking_session ADD CONSTRAINT FK_8AFA90F43301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_session ADD CONSTRAINT FK_8AFA90F4613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_session DROP FOREIGN KEY FK_8AFA90F43301C60');
        $this->addSql('ALTER TABLE booking_session DROP FOREIGN KEY FK_8AFA90F4613FECDF');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE booking_session');
        $this->addSql('DROP TABLE session');
    }
}
