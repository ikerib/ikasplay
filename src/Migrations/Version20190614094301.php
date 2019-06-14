<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190614094301 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quizz_det DROP FOREIGN KEY FK_71C6D5FCBA934BCD');
        $this->addSql('ALTER TABLE quizz_det ADD CONSTRAINT FK_71C6D5FCBA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quizz_det DROP FOREIGN KEY FK_71C6D5FCBA934BCD');
        $this->addSql('ALTER TABLE quizz_det ADD CONSTRAINT FK_71C6D5FCBA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id)');
    }
}
