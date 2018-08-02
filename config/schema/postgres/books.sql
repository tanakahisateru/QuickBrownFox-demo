DROP TABLE IF EXISTS "reviews", "books", "authors", "publishers", "reviewers";

CREATE TABLE "books" (
  id serial PRIMARY KEY,
  title varchar(255) NOT NULL,
  price decimal(8,2) NOT NULL,
  description text,
  updated_at timestamp without time zone NOT NULL
);
