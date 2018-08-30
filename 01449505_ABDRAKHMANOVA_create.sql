

CREATE TABLE admin(
login char (15) NOT NULL,
kennwort char (15) NOT NULL,
personalnummer integer,
PRIMARY KEY (personalnummer));

CREATE TABLE benutzer (
kennwort char(15) NOT NULL,
login char(15) NOT NULL,
benutzer_id integer NOT NULL,
PRIMARY KEY (benutzer_id ));

CREATE SEQUENCE user_id
START WITH 1
INCREMENT BY 1;

CREATE OR REPLACE trigger user_id_trg
BEFORE INSERT ON benutzer
FOR EACH ROW
BEGIN
     SELECT user_id.nextval
         INTO :new.benutzer_id
         FROM dual;
END;
/


CREATE TABLE arbeitgeber (
firma_name varchar (30) NOT NULL,
adresse varchar (50),
benutzer_id integer NOT NULL,
bereich varchar (30) NOT NULL,
ort char (25) NOT NULL,
telefonnumer integer NOT NULL UNIQUE,
email varchar (50) NOT NULL UNIQUE,
PRIMARY KEY (firma_name),
FOREIGN KEY (benutzer_id) REFERENCES benutzer ON DELETE CASCADE);


CREATE TABLE bewerber (
benutzer_id integer NOT NULL,
geburtsdatum date,
vorname varchar (50) NOT NULL,
nachname varchar (50) NOT NULL,
ort char (25) NOT NULL,
telefonnumer integer NOT NULL UNIQUE,
email varchar (50) NOT NULL,
adresse varchar (50),
PRIMARY KEY (email),
FOREIGN KEY (benutzer_id) REFERENCES benutzer ON DELETE CASCADE);


CREATE TABLE kategorie(
beschreibung varchar (100),
kategname char(100) NOT NULL,
PRIMARY KEY (kategname));


CREATE TABLE lebenslauf (
cvid integer NOT NULL,
beschreibung varchar (2000) NOT NULL,
schule varchar (50),
hochschule varchar (80),
kategname char (100) NOT NULL,
email varchar (50) NOT NULL,
position char (30) NOT NULL,
updatedatum date,
PRIMARY KEY (cvid),
FOREIGN KEY (email) REFERENCES bewerber ON DELETE CASCADE,
FOREIGN KEY (kategname) REFERENCES kategorie);


CREATE SEQUENCE lebenslauf_id
START WITH 1
INCREMENT BY 1;

CREATE OR REPLACE trigger lebenslauf_id_trg
BEFORE INSERT ON lebenslauf
FOR EACH ROW
BEGIN
     SELECT lebenslauf_id.nextval
         INTO :new.cvid
         FROM dual;
END;
/



CREATE TABLE stellenangebote (
vacancyid integer  NOT NULL,
beschreibung varchar (2000),
title char (30) NOT NULL,
gehalt double precision,
kategname char(100) NOT NULL,
endzeit date NOT NULL,
beginzeit date NOT NULL,
firma_name varchar (30) NOT NULL,
anstelungsart varchar (50)NOT NULL,
PRIMARY KEY (vacancyid),
FOREIGN KEY (firma_name) REFERENCES arbeitgeber ON DELETE CASCADE,
FOREIGN KEY (kategname) REFERENCES kategorie,
CHECK (gehalt>0),
CHECK (beginzeit < endzeit));

CREATE SEQUENCE vacancy_id
START WITH 1
INCREMENT BY 1;

CREATE OR REPLACE trigger vacancy_id_trg
BEFORE INSERT ON stellenangebote
FOR EACH ROW
BEGIN
     SELECT vacancy_id.nextval
         INTO :new.vacancyid
         FROM dual;
END;
/


CREATE TABLE stellenangeboteBewerben(
email varchar (50) NOT NULL,
vacancyid INTEGER NOT NULL,
PRIMARY KEY (email , vacancyid),
FOREIGN KEY (email )REFERENCES bewerber ON DELETE CASCADE,
FOREIGN KEY (vacancyid) REFERENCES stellenangebote ON DELETE CASCADE);

CREATE TABLE lebenslaufSuchen(
firma_name varchar (30) NOT NULL,
cvid integer  NOT NULL,
PRIMARY KEY (firma_name , cvid),
FOREIGN KEY (firma_name )REFERENCES arbeitgeber ON DELETE CASCADE,
FOREIGN KEY (cvid) REFERENCES lebenslauf ON DELETE CASCADE);


CREATE TABLE zugehoerigkeit(
vacancyid integer NOT NULL,
cvid integer  NOT NULL,
kategname char (20)NOT NULL,
PRIMARY KEY (vacancyid,cvid, kategname),
FOREIGN KEY (vacancyid)REFERENCES stellenangebote ON DELETE CASCADE,
FOREIGN KEY (cvid) REFERENCES lebenslauf ON DELETE CASCADE,
FOREIGN KEY (kategname) REFERENCES kategorie ON DELETE CASCADE);




CREATE VIEW alle_cv AS
(SELECT  vorname, nachname, geburtsdatum,
ort, telefonnumer, kategname,position, schule, hochschule, beschreibung,updatedatum
FROM bewerber
join lebenslauf on (lebenslauf.email=bewerber.email));


CREATE VIEW alle_jobs AS
(SELECT  ort, telefonnumer, adresse, kategname,title, gehalt, endzeit,beginzeit, anstelungsart,beschreibung, vacancyid, email
FROM arbeitgeber
join stellenangebote on (stellenangebote.firma_name=arbeitgeber.firma_name));


CREATE VIEW search_jobs AS
(SELECT  ort, telefonnumer,email, adresse, kategname,title, gehalt, anstelungsart,beschreibung, vacancyid
FROM arbeitgeber
join stellenangebote on (stellenangebote.firma_name=arbeitgeber.firma_name));



CREATE VIEW apply AS
(SELECT vacancyid, nachname, vorname
FROM stellenangeboteBewerben
JOIN  bewerber on 
(stellenangeboteBewerben.email =bewerber.email));



CREATE VIEW job_count (vacancyid)
AS 
SELECT COUNT (vacancyid)
FROM  stellenangebote;


CREATE VIEW bewerber_count1 (vorname)
AS 
SELECT COUNT (vorname)
FROM  bewerber;


CREATE VIEW vacancy_min_gehalt (gehalt)
AS 
SELECT  Min (gehalt) 
FROM stellenangebote;


CREATE VIEW gehaltAVG(gehalt)
AS
SELECT AVG(gehalt) 
FROM stellenangebote;







