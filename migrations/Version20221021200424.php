<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221021200424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE history_ni_nineaproposition (id INT AUTO_INCREMENT NOT NULL, history_ni_personne_id INT DEFAULT NULL, INDEX IDX_120EA8874B14797B (history_ni_personne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE history_ni_personne (id INT AUTO_INCREMENT NOT NULL, nin_sexe_id INT DEFAULT NULL, civilite_id VARCHAR(10) DEFAULT NULL, nationalite_id VARCHAR(25) DEFAULT NULL, created_by_id VARCHAR(255) DEFAULT NULL, nin_qvh_id VARCHAR(25) DEFAULT NULL, nin_typevoie_id VARCHAR(10) DEFAULT NULL, nin_nom VARCHAR(100) DEFAULT NULL, nin_prenom VARCHAR(100) DEFAULT NULL, nin_date_naissance DATE DEFAULT NULL, nin_lieu_naissance VARCHAR(255) DEFAULT NULL, nin_cni VARCHAR(20) DEFAULT NULL, nin_date_cni DATE DEFAULT NULL, nin_sigle VARCHAR(100) DEFAULT NULL, created_at DATE DEFAULT NULL, updated_at DATE DEFAULT NULL, nin_raison LONGTEXT DEFAULT NULL, adresse LONGTEXT DEFAULT NULL, nin_telephone VARCHAR(10) DEFAULT NULL, nin_email_personnel VARCHAR(200) DEFAULT NULL, nin_voie VARCHAR(255) DEFAULT NULL, num_voie VARCHAR(50) DEFAULT NULL, INDEX IDX_1DFABC2085937C76 (nin_sexe_id), INDEX IDX_1DFABC2039194ABF (civilite_id), INDEX IDX_1DFABC201B063272 (nationalite_id), INDEX IDX_1DFABC20B03A8386 (created_by_id), INDEX IDX_1DFABC201DE64858 (nin_qvh_id), INDEX IDX_1DFABC20BB208913 (nin_typevoie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE history_nininea (id INT AUTO_INCREMENT NOT NULL, history_ni_personne_id INT DEFAULT NULL, INDEX IDX_4D23C31D4B14797B (history_ni_personne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE history_ni_nineaproposition ADD CONSTRAINT FK_120EA8874B14797B FOREIGN KEY (history_ni_personne_id) REFERENCES history_ni_personne (id)');
        $this->addSql('ALTER TABLE history_ni_personne ADD CONSTRAINT FK_1DFABC2085937C76 FOREIGN KEY (nin_sexe_id) REFERENCES ni_sexe (id)');
        $this->addSql('ALTER TABLE history_ni_personne ADD CONSTRAINT FK_1DFABC2039194ABF FOREIGN KEY (civilite_id) REFERENCES ni_civilite (id)');
        $this->addSql('ALTER TABLE history_ni_personne ADD CONSTRAINT FK_1DFABC201B063272 FOREIGN KEY (nationalite_id) REFERENCES ref_pays (id)');
        $this->addSql('ALTER TABLE history_ni_personne ADD CONSTRAINT FK_1DFABC20B03A8386 FOREIGN KEY (created_by_id) REFERENCES `utilisateur` (id)');
        $this->addSql('ALTER TABLE history_ni_personne ADD CONSTRAINT FK_1DFABC201DE64858 FOREIGN KEY (nin_qvh_id) REFERENCES `ref_qvh` (id)');
        $this->addSql('ALTER TABLE history_ni_personne ADD CONSTRAINT FK_1DFABC20BB208913 FOREIGN KEY (nin_typevoie_id) REFERENCES ni_typevoie (id)');
        $this->addSql('ALTER TABLE history_nininea ADD CONSTRAINT FK_4D23C31D4B14797B FOREIGN KEY (history_ni_personne_id) REFERENCES history_ni_personne (id)');
        $this->addSql('DROP TABLE history_cuci_achats_du_production');
        $this->addSql('DROP TABLE ni_chiffre_aff');
        $this->addSql('DROP TABLE ni_dirigeants');
        $this->addSql('DROP TABLE ni_nationalite');
        $this->addSql('DROP TABLE ni_personnemorale');
        $this->addSql('DROP TABLE ni_personnephysique');
        $this->addSql('DROP TABLE suivi_materiel_mobilier_util_smt');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE history_ni_nineaproposition DROP FOREIGN KEY FK_120EA8874B14797B');
        $this->addSql('ALTER TABLE history_nininea DROP FOREIGN KEY FK_4D23C31D4B14797B');
        $this->addSql('CREATE TABLE history_cuci_achats_du_production (create_at TEXT CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, operation TEXT CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, db_user TEXT CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, id VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, repertoire_id VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, achat_production_util_id INT DEFAULT NULL, libelle VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, qty_produit_dans_etat VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, qty_achetee_dans_etat VARCHAR(100) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, qty_achetee_hors_pays VARCHAR(100) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, val_produit_dans_etat VARCHAR(100) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, val_achetee_dans_pays VARCHAR(100) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, val_achetee_hors_pays VARCHAR(100) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, variation_des_stocks VARCHAR(100) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, unites VARCHAR(100) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, annee_financiere VARCHAR(6) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, submit TINYINT(1) DEFAULT NULL, created_by_id VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, updated_by_id VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, demat TINYINT(1) DEFAULT NULL) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = InnoDB COMMENT = \'\' ');
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
        $this->addSql('DROP TABLE history_ni_nineaproposition');
        $this->addSql('DROP TABLE history_ni_personne');
        $this->addSql('DROP TABLE history_nininea');
    }
}
