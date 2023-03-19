<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230319223725 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, id_type_contrat_id INT NOT NULL, user_id_id INT NOT NULL, intitule_poste VARCHAR(255) NOT NULL, lieu_travail VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, horaires VARCHAR(255) NOT NULL, salaire INT NOT NULL, actif TINYINT(1) NOT NULL, INDEX IDX_F65593E5EC7E13B2 (id_type_contrat_id), INDEX IDX_F65593E59D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attributs_candidat (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, cv LONGBLOB DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attributs_recruteur (id INT AUTO_INCREMENT NOT NULL, nom_entreprise VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diplayed_role (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_contrat (id INT AUTO_INCREMENT NOT NULL, nom_contrat VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, displayed_role_id_id INT DEFAULT NULL, attr_candidat_id_id INT DEFAULT NULL, attr_recruteur_id_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, actif TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D6495EA85E6 (displayed_role_id_id), UNIQUE INDEX UNIQ_8D93D6495FDF43CE (attr_candidat_id_id), UNIQUE INDEX UNIQ_8D93D64980DDFF02 (attr_recruteur_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5EC7E13B2 FOREIGN KEY (id_type_contrat_id) REFERENCES type_contrat (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E59D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495EA85E6 FOREIGN KEY (displayed_role_id_id) REFERENCES diplayed_role (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495FDF43CE FOREIGN KEY (attr_candidat_id_id) REFERENCES attributs_candidat (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64980DDFF02 FOREIGN KEY (attr_recruteur_id_id) REFERENCES attributs_recruteur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5EC7E13B2');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E59D86650F');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495EA85E6');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495FDF43CE');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64980DDFF02');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE attributs_candidat');
        $this->addSql('DROP TABLE attributs_recruteur');
        $this->addSql('DROP TABLE diplayed_role');
        $this->addSql('DROP TABLE type_contrat');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
