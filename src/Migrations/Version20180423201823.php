<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180423201823 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bird (id INT AUTO_INCREMENT NOT NULL, bird_statuses_id INT DEFAULT NULL, bird_families_id INT DEFAULT NULL, taxref_classe VARCHAR(50) NOT NULL, taxref_cd_nom INT NOT NULL, taxref_nom_vern VARCHAR(255) NOT NULL, taxref_url_image VARCHAR(255) DEFAULT NULL, protected TINYINT(1) NOT NULL, INDEX IDX_A0BBAE0E946CC373 (bird_statuses_id), INDEX IDX_A0BBAE0EDBCBCE58 (bird_families_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bird_family (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bird_status (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bird ADD CONSTRAINT FK_A0BBAE0E946CC373 FOREIGN KEY (bird_statuses_id) REFERENCES bird_status (id)');
        $this->addSql('ALTER TABLE bird ADD CONSTRAINT FK_A0BBAE0EDBCBCE58 FOREIGN KEY (bird_families_id) REFERENCES bird_family (id)');
        $this->addSql('DROP TABLE birds');
        $this->addSql('ALTER TABLE article ADD user_id INT NOT NULL, ADD article_id INT NOT NULL');
        $this->addSql('ALTER TABLE comments DROP author, DROP datecomment');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bird DROP FOREIGN KEY FK_A0BBAE0EDBCBCE58');
        $this->addSql('ALTER TABLE bird DROP FOREIGN KEY FK_A0BBAE0E946CC373');
        $this->addSql('CREATE TABLE birds (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, weight INT NOT NULL, size INT NOT NULL, latitude VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, observation VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, longitude INT NOT NULL, altitude INT NOT NULL, url VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, user_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE bird');
        $this->addSql('DROP TABLE bird_family');
        $this->addSql('DROP TABLE bird_status');
        $this->addSql('ALTER TABLE article DROP user_id, DROP article_id');
        $this->addSql('ALTER TABLE comments ADD author VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD datecomment DATETIME NOT NULL');
    }
}
