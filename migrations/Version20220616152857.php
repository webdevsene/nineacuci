<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220616152857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ni_chiffre_aff');
        $this->addSql('DROP TABLE ni_dirigeants');
        $this->addSql('DROP TABLE ni_nationalite');
        $this->addSql('DROP TABLE ni_personnemorale');
        $this->addSql('DROP TABLE ni_personnephysique');
        $this->addSql('DROP TABLE suivi_materiel_mobilier_util_smt');
        $this->addSql('ALTER TABLE ninproduits ADD n_ininea_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ninproduits ADD CONSTRAINT FK_B7979BB73034704 FOREIGN KEY (n_ininea_id) REFERENCES `ni_ninea` (id)');
        $this->addSql('CREATE INDEX IDX_B7979BB73034704 ON ninproduits (n_ininea_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ni_chiffre_aff (id INT AUTO_INCREMENT NOT NULL, nin_ninea_id INT DEFAULT NULL, nin_Montant VARCHAR(100) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, nin_Date DATE NOT NULL, created_by VARCHAR(100) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, updated_by VARCHAR(100) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, created_at DATE NOT NULL, updated_at DATE NOT NULL, INDEX IDX_E65075C5113CA4C (nin_ninea_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE ni_dirigeants (id INT AUTO_INCREMENT NOT NULL, nin_presi_gie_civil_id VARCHAR(10) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, nin_presi_gie_type_voie_domicile_id VARCHAR(10) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, nin_ninea_id INT DEFAULT NULL, nin_presi_gie_adresse_domicile VARCHAR(150) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, nin_presi_gie_bpdomicile VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, nin_presi_gie_cni VARCHAR(25) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, nin_presi_gie_com_domicile VARCHAR(150) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, nin_presi_gie_date_cni DATE DEFAULT NULL, nin_presi_gie_date_passeport DATE DEFAULT NULL, nin_presi_gie_datnais DATE NOT NULL, nin_presi_gie_dept_domicile VARCHAR(150) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, nin_presi_gie_lieunais VARCHAR(150) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, nin_presi_gie_nom VARCHAR(150) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, nin_presi_gie_num_voie_domicile VARCHAR(20) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, nin_presi_gie_passeport VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, nin_presi_gie_prenom VARCHAR(100) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, nin_presi_gie_qrt_village_domicile VARCHAR(100) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, nin_presi_gie_sexe VARCHAR(1) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, nin_presi_gie_teldomicile1 VARCHAR(30) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, nin_presi_gie_teldomicile2 VARCHAR(30) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, nin_presi_gie_voie_domicile VARCHAR(100) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, INDEX IDX_7AE4CEDE3EF19D56 (nin_presi_gie_type_voie_domicile_id), INDEX IDX_7AE4CEDE5113CA4C (nin_ninea_id), INDEX IDX_7AE4CEDEFE5FB118 (nin_presi_gie_civil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE ni_nationalite (id VARCHAR(10) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, natcode VARCHAR(5) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, natlibelle VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE ni_personnemorale (id INT AUTO_INCREMENT NOT NULL, nin_PMcode VARCHAR(10) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, nin_PMlibelle VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, created_by VARCHAR(10) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, updated_by VARCHAR(10) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE ni_personnephysique (id INT AUTO_INCREMENT NOT NULL, nin_PPcode VARCHAR(10) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, nin_PPlibelle VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, created_by VARCHAR(10) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, updated_by VARCHAR(10) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE suivi_materiel_mobilier_util_smt (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE ni_chiffre_aff ADD CONSTRAINT FK_E65075C5113CA4C FOREIGN KEY (nin_ninea_id) REFERENCES ni_nineaproposition (id)');
        $this->addSql('ALTER TABLE ni_dirigeants ADD CONSTRAINT FK_7AE4CEDE3EF19D56 FOREIGN KEY (nin_presi_gie_type_voie_domicile_id) REFERENCES ni_typevoie (id)');
        $this->addSql('ALTER TABLE ni_dirigeants ADD CONSTRAINT FK_7AE4CEDEFE5FB118 FOREIGN KEY (nin_presi_gie_civil_id) REFERENCES ni_civilite (id)');
        $this->addSql('ALTER TABLE ni_dirigeants ADD CONSTRAINT FK_7AE4CEDE5113CA4C FOREIGN KEY (nin_ninea_id) REFERENCES ni_nineaproposition (id)');
        $this->addSql('ALTER TABLE ninproduits DROP FOREIGN KEY FK_B7979BB73034704');
        $this->addSql('DROP INDEX IDX_B7979BB73034704 ON ninproduits');
        $this->addSql('ALTER TABLE ninproduits DROP n_ininea_id');
    }
}
