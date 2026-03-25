<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260325023155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paciente (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(100) NOT NULL, fecha_nacimiento DATE NOT NULL, genero VARCHAR(1) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE visita (id INT AUTO_INCREMENT NOT NULL, fecha_visita DATE NOT NULL, nombre_medico VARCHAR(100) NOT NULL, recibe_medicamentos VARCHAR(2) NOT NULL, paciente_id INT NOT NULL, INDEX IDX_B7F148A27310DAD4 (paciente_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE visita ADD CONSTRAINT FK_B7F148A27310DAD4 FOREIGN KEY (paciente_id) REFERENCES paciente (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE visita DROP FOREIGN KEY FK_B7F148A27310DAD4');
        $this->addSql('DROP TABLE paciente');
        $this->addSql('DROP TABLE visita');
    }
}
