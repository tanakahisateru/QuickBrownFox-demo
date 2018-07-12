DROP TABLE IF EXISTS `reviews`, `books`, `authors`, `publishers`, `reviewers`;

CREATE TABLE `books` (
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  price decimal(8,2) NOT NULL,
  description text NOT NULL,
  updated_at datetime NOT NULL
);
