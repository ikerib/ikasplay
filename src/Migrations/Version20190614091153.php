<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190614091153 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE quizz (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL, result TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quizz_det (id INT AUTO_INCREMENT NOT NULL, quizz_id INT DEFAULT NULL, question_id INT DEFAULT NULL, result TINYINT(1) NOT NULL, INDEX IDX_71C6D5FCBA934BCD (quizz_id), UNIQUE INDEX UNIQ_71C6D5FC1E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quizz_det ADD CONSTRAINT FK_71C6D5FCBA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id)');
        $this->addSql('ALTER TABLE quizz_det ADD CONSTRAINT FK_71C6D5FC1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quizz_det DROP FOREIGN KEY FK_71C6D5FCBA934BCD');
        $this->addSql('DROP TABLE quizz');
        $this->addSql('DROP TABLE quizz_det');
    }
}
