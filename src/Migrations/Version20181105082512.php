<?php declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181105082512 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE codebreaker ADD player_id INT NOT NULL');
        $this->addSql('ALTER TABLE codebreaker ADD CONSTRAINT FK_7151523199E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('CREATE INDEX IDX_7151523199E6F5DF ON codebreaker (player_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE codebreaker DROP FOREIGN KEY FK_7151523199E6F5DF');
        $this->addSql('DROP INDEX IDX_7151523199E6F5DF ON codebreaker');
        $this->addSql('ALTER TABLE codebreaker DROP player_id');
    }
}
