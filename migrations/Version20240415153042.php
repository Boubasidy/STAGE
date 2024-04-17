<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240415153042 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3BE4E55D8');
        $this->addSql('ALTER TABLE choix DROP FOREIGN KEY FK_4F488091E7D6FCC1');
        $this->addSql('ALTER TABLE choix DROP FOREIGN KEY FK_4F488091717E22E3');
        $this->addSql('ALTER TABLE etudsup DROP FOREIGN KEY FK_5DDD686404021BF');
        $this->addSql('ALTER TABLE etudsup DROP FOREIGN KEY FK_5DDD686717E22E3');
        $this->addSql('ALTER TABLE resultatbac DROP FOREIGN KEY FK_A83D80341C4FAC58');
        $this->addSql('ALTER TABLE resultatbac DROP FOREIGN KEY FK_A83D8034717E22E3');
        $this->addSql('DROP TABLE bac');
        $this->addSql('DROP TABLE choix');
        $this->addSql('DROP TABLE etudsup');
        $this->addSql('DROP TABLE formation_ant');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE resultatbac');
        $this->addSql('DROP TABLE specialite');
        $this->addSql('DROP INDEX IDX_717E22E3BE4E55D8 ON etudiant');
        $this->addSql('ALTER TABLE etudiant DROP codegrp, CHANGE email email VARCHAR(60) DEFAULT NULL, CHANGE sexe sexe VARCHAR(1) DEFAULT NULL, CHANGE datnaiss datnaiss DATE DEFAULT NULL, CHANGE dateinsc dateinsc DATE DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bac (idbac INT AUTO_INCREMENT NOT NULL, typebac VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, libele VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(idbac)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE choix (specialite VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, etudiant VARCHAR(8) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, enterminale TINYINT(1) NOT NULL, INDEX IDX_4F488091717E22E3 (etudiant), INDEX IDX_4F488091E7D6FCC1 (specialite), PRIMARY KEY(specialite, etudiant)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE etudsup (formation VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, etudiant VARCHAR(8) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, anneedeb INT DEFAULT NULL, INDEX IDX_5DDD686717E22E3 (etudiant), INDEX IDX_5DDD686404021BF (formation), PRIMARY KEY(formation, etudiant)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE formation_ant (codef VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nomf VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, etablissement VARCHAR(80) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, diplome VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(codef)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE groupe (codegrp VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nomgrp VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nbetds INT NOT NULL, capacite INT NOT NULL, PRIMARY KEY(codegrp)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE resultatbac (bac INT NOT NULL, etudiant VARCHAR(8) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, anneebac INT NOT NULL, mention VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, moyennebac DOUBLE PRECISION DEFAULT NULL, etabbac VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, depbac VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_A83D80341C4FAC58 (bac), INDEX IDX_A83D8034717E22E3 (etudiant), PRIMARY KEY(bac, etudiant)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE specialite (codespe VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nomspe VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(codespe)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE choix ADD CONSTRAINT FK_4F488091E7D6FCC1 FOREIGN KEY (specialite) REFERENCES specialite (codespe)');
        $this->addSql('ALTER TABLE choix ADD CONSTRAINT FK_4F488091717E22E3 FOREIGN KEY (etudiant) REFERENCES etudiant (numetd)');
        $this->addSql('ALTER TABLE etudsup ADD CONSTRAINT FK_5DDD686404021BF FOREIGN KEY (formation) REFERENCES formation_ant (codef)');
        $this->addSql('ALTER TABLE etudsup ADD CONSTRAINT FK_5DDD686717E22E3 FOREIGN KEY (etudiant) REFERENCES etudiant (numetd)');
        $this->addSql('ALTER TABLE resultatbac ADD CONSTRAINT FK_A83D80341C4FAC58 FOREIGN KEY (bac) REFERENCES bac (idbac)');
        $this->addSql('ALTER TABLE resultatbac ADD CONSTRAINT FK_A83D8034717E22E3 FOREIGN KEY (etudiant) REFERENCES etudiant (numetd)');
        $this->addSql('ALTER TABLE etudiant ADD codegrp VARCHAR(50) DEFAULT NULL, CHANGE email email VARCHAR(60) NOT NULL, CHANGE sexe sexe VARCHAR(1) NOT NULL, CHANGE datnaiss datnaiss DATE NOT NULL, CHANGE dateinsc dateinsc DATE NOT NULL');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3BE4E55D8 FOREIGN KEY (codegrp) REFERENCES groupe (codegrp) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_717E22E3BE4E55D8 ON etudiant (codegrp)');
    }
}
