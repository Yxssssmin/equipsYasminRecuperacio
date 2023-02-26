<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230226105728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE membredos (id INT AUTO_INCREMENT NOT NULL, equip_id INT NOT NULL, nom VARCHAR(50) NOT NULL, cognoms VARCHAR(100) NOT NULL, email VARCHAR(150) NOT NULL, imatge_perfil VARCHAR(255) NOT NULL, data_naixement DATE NOT NULL, nota NUMERIC(2, 0) DEFAULT NULL, UNIQUE INDEX UNIQ_972EDF7AE7927C74 (email), INDEX IDX_972EDF7A8AC49FD9 (equip_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE membredos ADD CONSTRAINT FK_972EDF7A8AC49FD9 FOREIGN KEY (equip_id) REFERENCES equip (id)');
        $this->addSql('ALTER TABLE equip CHANGE nota nota DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('DROP INDEX nom ON equip');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F273C3B06C6E55B5 ON equip (nom)');
        $this->addSql('ALTER TABLE membre CHANGE nota nota DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('DROP INDEX email ON membre');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6B4FB29E7927C74 ON membre (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE membredos DROP FOREIGN KEY FK_972EDF7A8AC49FD9');
        $this->addSql('DROP TABLE membredos');
        $this->addSql('ALTER TABLE equip CHANGE nota nota NUMERIC(2, 0) DEFAULT NULL');
        $this->addSql('DROP INDEX uniq_f273c3b06c6e55b5 ON equip');
        $this->addSql('CREATE UNIQUE INDEX nom ON equip (nom)');
        $this->addSql('ALTER TABLE membre CHANGE nota nota NUMERIC(2, 2) DEFAULT NULL');
        $this->addSql('DROP INDEX uniq_f6b4fb29e7927c74 ON membre');
        $this->addSql('CREATE UNIQUE INDEX email ON membre (email)');
    }
}
