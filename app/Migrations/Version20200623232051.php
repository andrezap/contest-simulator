<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200623232051 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE round_contestant (id UUID NOT NULL, contestant_id UUID DEFAULT NULL, round_id UUID DEFAULT NULL, score DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7B59F893AF70032D ON round_contestant (contestant_id)');
        $this->addSql('CREATE INDEX IDX_7B59F893A6005CA0 ON round_contestant (round_id)');
        $this->addSql('COMMENT ON COLUMN round_contestant.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN round_contestant.contestant_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN round_contestant.round_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE contestant (id UUID NOT NULL, contest_id UUID NOT NULL, gender_strength JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_60D3BEE71CD0F0DE ON contestant (contest_id)');
        $this->addSql('COMMENT ON COLUMN contestant.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN contestant.contest_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE round (id UUID NOT NULL, contest_id UUID DEFAULT NULL, finished BOOLEAN NOT NULL, number INT NOT NULL, music_genre VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C5EEEA341CD0F0DE ON round (contest_id)');
        $this->addSql('COMMENT ON COLUMN round.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN round.contest_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE contest (id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN contest.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE round_contestant ADD CONSTRAINT FK_7B59F893AF70032D FOREIGN KEY (contestant_id) REFERENCES contestant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE round_contestant ADD CONSTRAINT FK_7B59F893A6005CA0 FOREIGN KEY (round_id) REFERENCES round (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contestant ADD CONSTRAINT FK_60D3BEE71CD0F0DE FOREIGN KEY (contest_id) REFERENCES contest (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE round ADD CONSTRAINT FK_C5EEEA341CD0F0DE FOREIGN KEY (contest_id) REFERENCES contest (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE round_contestant DROP CONSTRAINT FK_7B59F893AF70032D');
        $this->addSql('ALTER TABLE round_contestant DROP CONSTRAINT FK_7B59F893A6005CA0');
        $this->addSql('ALTER TABLE contestant DROP CONSTRAINT FK_60D3BEE71CD0F0DE');
        $this->addSql('ALTER TABLE round DROP CONSTRAINT FK_C5EEEA341CD0F0DE');
        $this->addSql('DROP TABLE round_contestant');
        $this->addSql('DROP TABLE contestant');
        $this->addSql('DROP TABLE round');
        $this->addSql('DROP TABLE contest');
    }
}
