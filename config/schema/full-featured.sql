DROP TABLE IF EXISTS `reviews`, `books`, `authors`, `publishers`, `reviewers`;

CREATE TABLE `authors` (
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  name varchar(255) NOT NULL
);

CREATE TABLE `publishers` (
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  name varchar(255) NOT NULL
);

CREATE TABLE `reviewers` (
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  name varchar(255) NOT NULL
);

CREATE TABLE `books` (
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  price decimal(8,2) NOT NULL,
  author_id int(11) NOT NULL,
  publisher_id int(11) NOT NULL,
  description text NOT NULL,
  updated_at datetime NOT NULL,
  FOREIGN KEY (author_id) REFERENCES `authors`(id),
  FOREIGN KEY (publisher_id) REFERENCES `publishers`(id)
);

CREATE TABLE `reviews` (
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  book_id int(11) NOT NULL,
  reviewer_id int(11) NOT NULL,
  rating decimal(2,1) NOT NULL,
  message text NOT NULL,
  reviewed_at datetime NOT NULL,
  FOREIGN KEY (book_id) REFERENCES `books`(id),
  FOREIGN KEY (reviewer_id) REFERENCES `reviewers`(id)
);
