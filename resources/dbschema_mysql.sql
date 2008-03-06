DROP TABLE IF EXISTS nyconfig;
DROP TABLE IF EXISTS nygroup;
DROP TABLE IF EXISTS nyupload;
DROP TABLE IF EXISTS nyentry;
DROP TABLE IF EXISTS nyuser;
DROP TABLE IF EXISTS nycategory;

CREATE TABLE nyconfig (
	ckey					VARCHAR(32)		NOT NULL,
	cvalue					TEXT,
	PRIMARY KEY (ckey)
) ENGINE=InnoDb;
INSERT INTO nyconfig VALUES ('SITE_NAME', 'NgocYou');
INSERT INTO nyconfig VALUES ('SITE_TITLE', 'www.you.com.vn');
INSERT INTO nyconfig VALUES ('SITE_KEYWORDS', 'NgocYou Keywords');
INSERT INTO nyconfig VALUES ('SITE_DESCRIPTION', 'NgocYou Description');

CREATE TABLE nygroup (
	gid						INTEGER			NOT NULL,
	gname					VARCHAR(48)		NOT NULL,
	gdesc					VARCHAR(255),
	PRIMARY KEY(gid)
) ENGINE=InnoDb;
INSERT INTO nygroup (gid, gname, gdesc)
VALUES (1, 'Administrator', 'Administrator group, people in this group will have all permissions.');
INSERT INTO nygroup (gid, gname, gdesc)
VALUES (2, 'Moderator', 'Moderator group, people in this group will have selected administrative permissions.');
INSERT INTO nygroup (gid, gname, gdesc)
VALUES (3, 'Member', 'Normal user group.');

CREATE TABLE nyuser (
	uid						INTEGER			NOT NULL AUTO_INCREMENT,
	uloginname				VARCHAR(32)		NOT NULL,
		UNIQUE INDEX (uloginname),
	upassword				VARCHAR(48)		NOT NULL,
	uemail					VARCHAR(64)		NOT NULL,
		INDEX (uemail),
	ufullname				VARCHAR(64),
	ucreationtimestamp		INTEGER			NOT NULL DEFAULT 0,
		INDEX (ucreationtimestamp),
	ugroupid				INTEGER			NOT NULL DEFAULT 0,
	PRIMARY KEY(uid)
) ENGINE=InnoDb;
INSERT INTO nyuser (uid, uloginname, upassword, uemail, ufullname, ugroupid, ucreationtimestamp)
VALUES (1, 'admin', MD5('password'), 'admin@domain.com', 'Administrator', 1, UNIX_TIMESTAMP());

CREATE TABLE nycategory (
	cid						INTEGER			NOT NULL AUTO_INCREMENT,
	cparentid				INTEGER,
		INDEX (cparentid),
		FOREIGN KEY (cparentid) REFERENCES nycategory(cid) ON DELETE RESTRICT,
	cposition				INTEGER			NOT NULL DEFAULT 0,
		INDEX (cposition),
	cname					VARCHAR(64)		NOT NULL,
	cdesc					VARCHAR(255),
	cnumviews				INTEGER			NOT NULL DEFAULT 0,
	PRIMARY KEY(cid)
) ENGINE=InnoDb;

CREATE TABLE nyentry (
	eid						INTEGER			NOT NULL AUTO_INCREMENT,
	ecatid					INTEGER			NOT NULL,
		INDEX (ecatid),
		FOREIGN KEY (ecatid) REFERENCES nycategory(cid) ON DELETE CASCADE,
	euserid					INTEGER			NOT NULL,
		INDEX (euserid),
		FOREIGN KEY (euserid) REFERENCES nyuser(uid) ON DELETE CASCADE,
	ecreationtimestamp		INTEGER			NOT NULL DEFAULT 0,
		INDEX (ecreationtimestamp),
	eexpirytimestamp		INTEGER			NOT NULL DEFAULT 0,
		INDEX (ecreationtimestamp),
	etitle					VARCHAR(255)	NOT NULL,
	ebody					TEXT,
	enumviews				INTEGER			NOT NULL DEFAULT 0,
		INDEX (enumviews),
	PRIMARY KEY(eid)
) ENGINE=InnoDB;

CREATE TABLE nyupload (
	uid						INTEGER			NOT NULL AUTO_INCREMENT,
	uentryid				INTEGER			NOT NULL,
		INDEX (uentryid),
		FOREIGN KEY (uentryid) REFERENCES nyentry(eid) ON DELETE CASCADE,
	usize					INTEGER			NOT NULL DEFAULT 0,
	umimetype				VARCHAR(32)		NOT NULL,
	ucontent				MEDIUMBLOB,
	PRIMARY KEY (uid)
) ENGINE=InnoDB;