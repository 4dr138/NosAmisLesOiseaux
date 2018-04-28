<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180428220353 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bird (id INT AUTO_INCREMENT NOT NULL, bird_status_id INT DEFAULT NULL, bird_family_id INT DEFAULT NULL, taxref_classe VARCHAR(50) NOT NULL, taxref_cd_nom INT NOT NULL, taxref_nom_vern VARCHAR(255) NOT NULL, taxref_url_image VARCHAR(255) DEFAULT NULL, protected TINYINT(1) NOT NULL, INDEX IDX_A0BBAE0ED8F3D1F2 (bird_status_id), INDEX IDX_A0BBAE0E705A8725 (bird_family_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bird_family (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bird_status (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE observation (id INT AUTO_INCREMENT NOT NULL, bird_id INT DEFAULT NULL, user_id INT DEFAULT NULL, date_observation DATETIME NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, comment VARCHAR(255) NOT NULL, INDEX IDX_C576DBE0E813F9 (bird_id), INDEX IDX_C576DBE0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bird ADD CONSTRAINT FK_A0BBAE0ED8F3D1F2 FOREIGN KEY (bird_status_id) REFERENCES bird_status (id)');
        $this->addSql('ALTER TABLE bird ADD CONSTRAINT FK_A0BBAE0E705A8725 FOREIGN KEY (bird_family_id) REFERENCES bird_family (id)');
        $this->addSql('ALTER TABLE observation ADD CONSTRAINT FK_C576DBE0E813F9 FOREIGN KEY (bird_id) REFERENCES bird (id)');
        $this->addSql('ALTER TABLE observation ADD CONSTRAINT FK_C576DBE0A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('DROP TABLE birds');
        $this->addSql('ALTER TABLE article ADD image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE users ADD godfather_code VARCHAR(255) NOT NULL, ADD experience INT NOT NULL, ADD godson_code VARCHAR(255) DEFAULT NULL, ADD image VARCHAR(255) DEFAULT NULL, ADD is_parrained TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE observation DROP FOREIGN KEY FK_C576DBE0E813F9');
        $this->addSql('ALTER TABLE bird DROP FOREIGN KEY FK_A0BBAE0E705A8725');
        $this->addSql('ALTER TABLE bird DROP FOREIGN KEY FK_A0BBAE0ED8F3D1F2');
        $this->addSql('CREATE TABLE birds (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, weight INT NOT NULL, size INT NOT NULL, latitude VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, observation VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, longitude INT NOT NULL, altitude INT NOT NULL, url VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, user_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE bird');
        $this->addSql('DROP TABLE bird_family');
        $this->addSql('DROP TABLE bird_status');
        $this->addSql('DROP TABLE observation');
        $this->addSql('ALTER TABLE article DROP image');
        $this->addSql('ALTER TABLE users DROP godfather_code, DROP experience, DROP godson_code, DROP image, DROP is_parrained');
    }
}
