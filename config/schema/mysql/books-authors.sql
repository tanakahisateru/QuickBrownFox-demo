DROP TABLE IF EXISTS `reviews`, `books`, `authors`, `publishers`, `reviewers`;

CREATE TABLE `authors` (
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  name varchar(255) NOT NULL
);

CREATE TABLE `books` (
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  price decimal(8,2) NOT NULL,
  author_id int(11) NOT NULL,
  description text NOT NULL,
  updated_at datetime NOT NULL,
  FOREIGN KEY (author_id) REFERENCES `authors`(id)
);
