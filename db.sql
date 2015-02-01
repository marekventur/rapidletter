CREATE EXTENSION IF NOT EXISTS pgcrypto;

CREATE TABLE IF NOT EXISTS benutzer (
    id SERIAL PRIMARY KEY ,
    password text NOT NULL,
    email text NOT NULL UNIQUE,
    anrede text default '',
    vorname text default '',
    nachname text default '',
    strasse text default '',
    hausnummer text default '',
    plz text default '',
    ort text default '',
    logo text default '',
    logo_width int NOT NULL default '0',
    logo_height int NOT NULL default '0',
    design text NOT NULL default 'classic',
    use_bzz text NOT NULL default 'bzz',
    name text NOT NULL default '',
    type text NOT NULL default 'private',
    fenster int NOT NULL default '0',
    falz int NOT NULL default '1',
    firmenname text NOT NULL default '',
    telefon text NOT NULL default '',
    fax text NOT NULL default '',
    internet text NOT NULL default '',
    ga1 text NOT NULL,
    ga2 text NOT NULL,
    ga3 text NOT NULL,
    isadmin int NOT NULL
);

CREATE TABLE IF NOT EXISTS briefe (
  id SERIAL PRIMARY KEY,
  benutzer int UNIQUE,
  betreff text NOT NULL default '',
  text text NOT NULL,
  letter_type text NOT NULL default 'business',
  design text NOT NULL default 'classic',
  showFensterLine int NOT NULL default '0',
  showFalzLine int NOT NULL default '1',
  header text NOT NULL default '',
  absender_firmenname text default '',
  absender_anrede text default '',
  absender_vorname text default '',
  absender_nachname text default '',
  absender_strasse text default '',
  absender_hausnummer text default '',
  absender_plz text default '',
  absender_ort text default '',
  bzz_use text default '',
  bzz_ihrzeichen text default '',
  bzz_unserzeichen text default '',
  bzz_name text default '',
  bzz_telefon text default '',
  bzz_fax text default '',
  bzz_email text default '',
  bzz_internet text default '',
  bzz_datum text default '',
  ga1 text,
  ga2 text,
  ga3 text,
  empfaenger_firmenname text default '',
  empfaenger_anrede text default '',
  empfaenger_vorname text default '',
  empfaenger_nachname text default '',
  empfaenger_strasse text default '',
  empfaenger_hausnummer text default '',
  empfaenger_plz text default '',
  empfaenger_ort text default '',
  empfaenger_show_normal int NOT NULL default '1',
  empfaenger_full text NOT NULL,
  ortdatum text default NULL,
  titel text default NULL,
  beschreibung text,
  usepublic int NOT NULL,
  ispublic int NOT NULL default '0',
  uid text NOT NULL,
  showpublic int NOT NULL default '0'
);

CREATE TABLE IF NOT EXISTS empfaenger (
  id SERIAL PRIMARY KEY,
  benutzer int NOT NULL,
  firmenname text default NULL,
  anrede text default NULL,
  vorname text default NULL,
  nachname text default NULL,
  strasse text default NULL,
  hausnummer text default NULL,
  plz text default NULL,
  ort text default NULL,
  show_normal int NOT NULL default '1',
  "full" text NOT NULL
);

CREATE TABLE IF NOT EXISTS outgoing_letters (
  id SERIAL PRIMARY KEY,
  session text default NULL,
  successfull int default '0',
  method text default 'lvin',
  letter_hash text default NULL,
  created timestamp NULL default NOW(),
  content bytea,
  price int default NULL
);

CREATE TABLE IF NOT EXISTS paypal_ipn_incoming (
  id SERIAL PRIMARY KEY,
  txn text NOT NULL default '',
  email text NOT NULL default '',
  amount int NOT NULL default '0',
  successfull int NOT NULL default '0',
  outgoing_letter int NOT NULL default '0',
  post text,
  response text
);

CREATE TABLE IF NOT EXISTS static (
  filename text PRIMARY KEY,
  created timestamp NOT NULL default NOW(),
  lifetime int default NULL,
  size int NOT NULL,
  data bytea NOT NULL
);

CREATE TABLE IF NOT EXISTS textbausteine (
  id SERIAL PRIMARY KEY,
  text text NOT NULL,
  schlagwoerter text NOT NULL
);

CREATE TABLE IF NOT EXISTS vorlagen (
  id SERIAL PRIMARY KEY,
  betreff text NOT NULL,
  text text NOT NULL,
  titel text NOT NULL,
  kategorie text NOT NULL
);

GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO rapidletter;