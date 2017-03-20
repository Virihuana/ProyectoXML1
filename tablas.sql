cl scr

PROM **************************************************
DROP TABLE songs;
DROP TABLE albums;
DROP SEQUENCE sec_albums;
DROP SEQUENCE sec_songs;
PROM **************************************************


-- (1)
CREATE TABLE albums (
	idalbum		NUMBER(5) NOT NULL,
	album		VARCHAR2(150) NOT NULL,
	categoria	VARCHAR2(18) NOT NULL,
	year		varchar2(4),
	rutaimagen	VARCHAR2(150),
	CONSTRAINT pk_idalbum PRIMARY KEY (idalbum)	
);

CREATE SEQUENCE sec_albums
START WITH 100
INCREMENT BY 1
MAXVALUE 99999
NOCYCLE;

-- (2)
CREATE TABLE songs (
	idsong		NUMBER(5) NOT NULL,
	nombre 		VARCHAR2(50) NOT NULL UNIQUE,	
	duracion	VARCHAR(5) NOT NULL,
	fkalbum		NUMBER(5) NOT NULL,
	CONSTRAINT pk_idsong PRIMARY KEY (idsong),
	CONSTRAINT fk_idalbum FOREIGN KEY (fkalbum) REFERENCES albums(idalbum)
);

CREATE SEQUENCE sec_songs
START WITH 1
INCREMENT BY 1
MAXVALUE 99999
NOCYCLE;

-------------------------------------------------------------------------------------
-- INSERCIONES --

--INSERT INTO albums (idalbum,album) VALUES (sec_albums.nextval, 'Parachutes');

--INSERT INTO songs VALUES(sec_songs.nextval,'Yellow','Coldplay','Rock','2004',100);


commit;














