<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230809084646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE about_web_site (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content CLOB NOT NULL, image_url VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE TEMPORARY TABLE __temp__adress AS SELECT id, user_id, street, code_postal, city, country, created_at, updated_at FROM adress');
        $this->addSql('DROP TABLE adress');
        $this->addSql('CREATE TABLE adress (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, street VARCHAR(255) NOT NULL, code_postal VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_5CECC7BEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO adress (id, user_id, street, code_postal, city, country, created_at, updated_at) SELECT id, user_id, street, code_postal, city, country, created_at, updated_at FROM __temp__adress');
        $this->addSql('DROP TABLE __temp__adress');
        $this->addSql('CREATE INDEX IDX_5CECC7BEA76ED395 ON adress (user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, author_id, title, slug, content, image_url, created_at, updated_at FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(60) NOT NULL, slug VARCHAR(255) NOT NULL, content CLOB NOT NULL, image_url VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_23A0E66F675F31B FOREIGN KEY (author_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO article (id, author_id, title, slug, content, image_url, created_at, updated_at) SELECT id, author_id, title, slug, content, image_url, created_at, updated_at FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE INDEX IDX_23A0E66F675F31B ON article (author_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category AS SELECT id, name, description, image_url, created_at, updated_at, slug FROM category');
        $this->addSql('DROP TABLE category');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, image_url VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , slug VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO category (id, name, description, image_url, created_at, updated_at, slug) SELECT id, name, description, image_url, created_at, updated_at, slug FROM __temp__category');
        $this->addSql('DROP TABLE __temp__category');
        $this->addSql('CREATE TEMPORARY TABLE __temp__contact AS SELECT id, full_name, email, subject, message, created_at, message_read, updated_at FROM contact');
        $this->addSql('DROP TABLE contact');
        $this->addSql('CREATE TABLE contact (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, full_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, message CLOB NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , message_read BOOLEAN NOT NULL, updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO contact (id, full_name, email, subject, message, created_at, message_read, updated_at) SELECT id, full_name, email, subject, message, created_at, message_read, updated_at FROM __temp__contact');
        $this->addSql('DROP TABLE __temp__contact');
        $this->addSql('CREATE TEMPORARY TABLE __temp__profile AS SELECT id, user_id, picture, description, date_birth, cover_picture, updated_at, created_at FROM profile');
        $this->addSql('DROP TABLE profile');
        $this->addSql('CREATE TABLE profile (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, picture VARCHAR(255) DEFAULT NULL, description CLOB DEFAULT NULL, date_birth DATETIME DEFAULT NULL, cover_picture VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_8157AA0FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO profile (id, user_id, picture, description, date_birth, cover_picture, updated_at, created_at) SELECT id, user_id, picture, description, date_birth, cover_picture, updated_at, created_at FROM __temp__profile');
        $this->addSql('DROP TABLE __temp__profile');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8157AA0FA76ED395 ON profile (user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, full_name, email, roles, password, created_at, updated_at FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, full_name VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO user (id, full_name, email, roles, password, created_at, updated_at) SELECT id, full_name, email, roles, password, created_at, updated_at FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE about_web_site');
        $this->addSql('CREATE TEMPORARY TABLE __temp__adress AS SELECT id, user_id, street, code_postal, city, country, created_at, updated_at FROM adress');
        $this->addSql('DROP TABLE adress');
        $this->addSql('CREATE TABLE adress (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, street VARCHAR(255) NOT NULL, code_postal VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_5CECC7BEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO adress (id, user_id, street, code_postal, city, country, created_at, updated_at) SELECT id, user_id, street, code_postal, city, country, created_at, updated_at FROM __temp__adress');
        $this->addSql('DROP TABLE __temp__adress');
        $this->addSql('CREATE INDEX IDX_5CECC7BEA76ED395 ON adress (user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, author_id, title, slug, content, image_url, created_at, updated_at FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(60) NOT NULL, slug VARCHAR(255) NOT NULL, content CLOB NOT NULL, image_url VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_23A0E66F675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO article (id, author_id, title, slug, content, image_url, created_at, updated_at) SELECT id, author_id, title, slug, content, image_url, created_at, updated_at FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE INDEX IDX_23A0E66F675F31B ON article (author_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category AS SELECT id, name, description, image_url, created_at, updated_at, slug FROM category');
        $this->addSql('DROP TABLE category');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, image_url VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , slug VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO category (id, name, description, image_url, created_at, updated_at, slug) SELECT id, name, description, image_url, created_at, updated_at, slug FROM __temp__category');
        $this->addSql('DROP TABLE __temp__category');
        $this->addSql('CREATE TEMPORARY TABLE __temp__contact AS SELECT id, full_name, email, subject, message, created_at, message_read, updated_at FROM contact');
        $this->addSql('DROP TABLE contact');
        $this->addSql('CREATE TABLE contact (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, full_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, message CLOB NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , message_read BOOLEAN NOT NULL, updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO contact (id, full_name, email, subject, message, created_at, message_read, updated_at) SELECT id, full_name, email, subject, message, created_at, message_read, updated_at FROM __temp__contact');
        $this->addSql('DROP TABLE __temp__contact');
        $this->addSql('CREATE TEMPORARY TABLE __temp__profile AS SELECT id, user_id, picture, description, date_birth, cover_picture, updated_at, created_at FROM profile');
        $this->addSql('DROP TABLE profile');
        $this->addSql('CREATE TABLE profile (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, picture VARCHAR(255) DEFAULT NULL, description CLOB DEFAULT NULL, date_birth DATETIME DEFAULT NULL, cover_picture VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_8157AA0FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO profile (id, user_id, picture, description, date_birth, cover_picture, updated_at, created_at) SELECT id, user_id, picture, description, date_birth, cover_picture, updated_at, created_at FROM __temp__profile');
        $this->addSql('DROP TABLE __temp__profile');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8157AA0FA76ED395 ON profile (user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, full_name, email, roles, password, created_at, updated_at FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, full_name VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO user (id, full_name, email, roles, password, created_at, updated_at) SELECT id, full_name, email, roles, password, created_at, updated_at FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }
}
