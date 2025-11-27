<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251127105833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE search_result_label (search_result_id INT NOT NULL, label_id INT NOT NULL, PRIMARY KEY (search_result_id, label_id))');
        $this->addSql('CREATE INDEX IDX_889FD0BABCBCA6EB ON search_result_label (search_result_id)');
        $this->addSql('CREATE INDEX IDX_889FD0BA33B92F39 ON search_result_label (label_id)');
        $this->addSql('ALTER TABLE search_result_label ADD CONSTRAINT FK_889FD0BABCBCA6EB FOREIGN KEY (search_result_id) REFERENCES search_result (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE search_result_label ADD CONSTRAINT FK_889FD0BA33B92F39 FOREIGN KEY (label_id) REFERENCES label (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE search_result_label DROP CONSTRAINT FK_889FD0BABCBCA6EB');
        $this->addSql('ALTER TABLE search_result_label DROP CONSTRAINT FK_889FD0BA33B92F39');
        $this->addSql('DROP TABLE search_result_label');
    }
}
