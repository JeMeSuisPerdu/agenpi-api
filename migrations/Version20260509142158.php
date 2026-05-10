<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260509142158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE absence (id INT AUTO_INCREMENT NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, user_id INT NOT NULL, reason_id INT NOT NULL, INDEX IDX_765AE0C9A76ED395 (user_id), INDEX IDX_765AE0C959BB1592 (reason_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, company_name VARCHAR(255) NOT NULL, contact_email VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, status VARCHAR(255) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME DEFAULT NULL, client_id INT NOT NULL, INDEX IDX_2FB3D0EE19EB6921 (client_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE project_user (project_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_B4021E51166D1F9C (project_id), INDEX IDX_B4021E51A76ED395 (user_id), PRIMARY KEY (project_id, user_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE reason (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, status VARCHAR(255) NOT NULL, project_id INT NOT NULL, INDEX IDX_527EDB25166D1F9C (project_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE task_user (task_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_FE2042328DB60186 (task_id), INDEX IDX_FE204232A76ED395 (user_id), PRIMARY KEY (task_id, user_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, service_id INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649ED5CA9E6 (service_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C959BB1592 FOREIGN KEY (reason_id) REFERENCES reason (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE project_user ADD CONSTRAINT FK_B4021E51166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_user ADD CONSTRAINT FK_B4021E51A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE task_user ADD CONSTRAINT FK_FE2042328DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE task_user ADD CONSTRAINT FK_FE204232A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9A76ED395');
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C959BB1592');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE19EB6921');
        $this->addSql('ALTER TABLE project_user DROP FOREIGN KEY FK_B4021E51166D1F9C');
        $this->addSql('ALTER TABLE project_user DROP FOREIGN KEY FK_B4021E51A76ED395');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25166D1F9C');
        $this->addSql('ALTER TABLE task_user DROP FOREIGN KEY FK_FE2042328DB60186');
        $this->addSql('ALTER TABLE task_user DROP FOREIGN KEY FK_FE204232A76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649ED5CA9E6');
        $this->addSql('DROP TABLE absence');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_user');
        $this->addSql('DROP TABLE reason');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE task_user');
        $this->addSql('DROP TABLE user');
    }
}
