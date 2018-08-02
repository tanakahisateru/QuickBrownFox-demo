DROP TABLE IF EXISTS "reviews", "books", "authors", "publishers", "reviewers";

CREATE TABLE "authors" (
  id serial PRIMARY KEY,
  name varchar(255) NOT NULL
);

CREATE TABLE "books" (
  id serial PRIMARY KEY,
  title varchar(255) NOT NULL,
  price decimal(8,2) NOT NULL,
  author_id integer REFERENCES authors NOT NULL,
  description text NOT NULL,
  updated_at timestamp without time zone NOT NULL
);
