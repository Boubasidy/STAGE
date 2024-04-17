<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240413123014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annee_universitaire (annee INT NOT NULL, PRIMARY KEY(annee)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE element (codeelt VARCHAR(20) NOT NULL, PRIMARY KEY(codeelt)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (anneeuniversitaire INT NOT NULL, etudiant VARCHAR(8) NOT NULL, element VARCHAR(20) NOT NULL, note DOUBLE PRECISION DEFAULT NULL, INDEX IDX_CFBDFA1469D43CC0 (anneeuniversitaire), INDEX IDX_CFBDFA14717E22E3 (etudiant), INDEX IDX_CFBDFA1441405E39 (element), PRIMARY KEY(anneeuniversitaire, etudiant, element)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1469D43CC0 FOREIGN KEY (anneeuniversitaire) REFERENCES annee_universitaire (annee)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14717E22E3 FOREIGN KEY (etudiant) REFERENCES etudiant (numetd)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1441405E39 FOREIGN KEY (element) REFERENCES element (codeelt)');
        $this->addSql('ALTER TABLE bloc ADD element VARCHAR(20) DEFAULT NULL, CHANGE filiere filiere VARCHAR(20) DEFAULT NULL, CHANGE nom_bloc nombloc VARCHAR(60) NOT NULL, CHANGE note_placher noteplancher INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bloc ADD CONSTRAINT FK_C778955A41405E39 FOREIGN KEY (element) REFERENCES element (codeelt)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C778955A41405E39 ON bloc (element)');
        $this->addSql('ALTER TABLE epreuve ADD element VARCHAR(20) DEFAULT NULL, ADD typeepreuve VARCHAR(20) NOT NULL, DROP type_epreuve, CHANGE matiere matiere VARCHAR(20) DEFAULT NULL, CHANGE salle salle VARCHAR(20) DEFAULT NULL, CHANGE duree duree INT DEFAULT NULL, CHANGE num_chance numchance INT NOT NULL');
        $this->addSql('ALTER TABLE epreuve ADD CONSTRAINT FK_D6ADE47F41405E39 FOREIGN KEY (element) REFERENCES element (codeelt)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D6ADE47F41405E39 ON epreuve (element)');
        $this->addSql('ALTER TABLE filiere ADD element VARCHAR(20) DEFAULT NULL, ADD nomfiliere VARCHAR(30) NOT NULL, ADD respfiliere VARCHAR(50) DEFAULT NULL, DROP nom_filiere, DROP resp_filiere');
        $this->addSql('ALTER TABLE filiere ADD CONSTRAINT FK_2ED05D9E41405E39 FOREIGN KEY (element) REFERENCES element (codeelt)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2ED05D9E41405E39 ON filiere (element)');
        $this->addSql('ALTER TABLE matiere ADD element VARCHAR(20) DEFAULT NULL, ADD nommat VARCHAR(40) NOT NULL, DROP nom_mat, CHANGE unite unite VARCHAR(20) DEFAULT NULL, CHANGE periode periode VARCHAR(3) NOT NULL');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT FK_9014574A41405E39 FOREIGN KEY (element) REFERENCES element (codeelt)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9014574A41405E39 ON matiere (element)');
        $this->addSql('ALTER TABLE unite ADD element VARCHAR(20) DEFAULT NULL, ADD coeficient INT DEFAULT NULL, ADD respunite VARCHAR(50) DEFAULT NULL, DROP coef, DROP rep_unite, CHANGE bloc bloc VARCHAR(20) DEFAULT NULL, CHANGE nom_unite nomunite VARCHAR(60) NOT NULL');
        $this->addSql('ALTER TABLE unite ADD CONSTRAINT FK_1D64C11841405E39 FOREIGN KEY (element) REFERENCES element (codeelt)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D64C11841405E39 ON unite (element)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bloc DROP FOREIGN KEY FK_C778955A41405E39');
        $this->addSql('ALTER TABLE epreuve DROP FOREIGN KEY FK_D6ADE47F41405E39');
        $this->addSql('ALTER TABLE filiere DROP FOREIGN KEY FK_2ED05D9E41405E39');
        $this->addSql('ALTER TABLE matiere DROP FOREIGN KEY FK_9014574A41405E39');
        $this->addSql('ALTER TABLE unite DROP FOREIGN KEY FK_1D64C11841405E39');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1469D43CC0');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14717E22E3');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1441405E39');
        $this->addSql('DROP TABLE annee_universitaire');
        $this->addSql('DROP TABLE element');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP INDEX UNIQ_C778955A41405E39 ON bloc');
        $this->addSql('ALTER TABLE bloc DROP element, CHANGE filiere filiere VARCHAR(20) NOT NULL, CHANGE nombloc nom_bloc VARCHAR(60) NOT NULL, CHANGE noteplancher note_placher INT DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_D6ADE47F41405E39 ON epreuve');
        $this->addSql('ALTER TABLE epreuve ADD type_epreuve VARCHAR(25) NOT NULL, DROP element, DROP typeepreuve, CHANGE matiere matiere VARCHAR(20) NOT NULL, CHANGE salle salle VARCHAR(50) DEFAULT NULL, CHANGE duree duree INT NOT NULL, CHANGE numchance num_chance INT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_2ED05D9E41405E39 ON filiere');
        $this->addSql('ALTER TABLE filiere ADD nom_filiere VARCHAR(60) NOT NULL, ADD resp_filiere VARCHAR(60) DEFAULT NULL, DROP element, DROP nomfiliere, DROP respfiliere');
        $this->addSql('DROP INDEX UNIQ_9014574A41405E39 ON matiere');
        $this->addSql('ALTER TABLE matiere ADD nom_mat VARCHAR(60) NOT NULL, DROP element, DROP nommat, CHANGE unite unite VARCHAR(20) NOT NULL, CHANGE periode periode VARCHAR(4) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_1D64C11841405E39 ON unite');
        $this->addSql('ALTER TABLE unite ADD coef INT NOT NULL, ADD rep_unite VARCHAR(60) DEFAULT NULL, DROP element, DROP coeficient, DROP respunite, CHANGE bloc bloc VARCHAR(20) NOT NULL, CHANGE nomunite nom_unite VARCHAR(60) NOT NULL');
    }
}
