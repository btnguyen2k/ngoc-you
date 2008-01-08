DROP TABLE IF EXISTS nygroup;
DROP TABLE IF EXISTS nyentry;
DROP TABLE IF EXISTS nyuser;
DROP TABLE IF EXISTS nycategory;

CREATE TABLE nygroup (
  gid INTEGER UNSIGNED NOT NULL,
  gname VARCHAR(48) NOT NULL,
  gdesc VARCHAR(255) NULL,
  PRIMARY KEY(gid)
) ENGINE=InnoDb;
INSERT INTO nygroup (gid, gname, gdesc)
VALUES (1, 'Administrator', 'Administrator group, people in this group will have all permissions.');
INSERT INTO nygroup (gid, gname, gdesc)
VALUES (2, 'Moderator', 'Moderator group, people in this group will have selected administrative permissions.');
INSERT INTO nygroup (gid, gname, gdesc)
VALUES (3, 'Member', 'Normal user group.');

CREATE TABLE nyuser (
  uid INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  uloginname VARCHAR(32) NOT NULL,
  upassword VARCHAR(48) NOT NULL,
  uemail VARCHAR(64) NOT NULL,
  ufullname VARCHAR(64) NULL,
  ucreationtimestamp INTEGER UNSIGNED NOT NULL DEFAULT 0,
  ugroupid INTEGER UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY(uid),
  UNIQUE INDEX nyuser_loginname(uloginname),
  UNIQUE INDEX nyuser_email(uemail),
  INDEX nyuser_creationtimestamp(ucreationtimestamp)
) ENGINE=InnoDb;
INSERT INTO nyuser (uid, uloginname, upassword, uemail, ufullname, ugroupid, ucreationtimestamp)
VALUES (1, 'admin', MD5('password'), 'admin@domain.com', 'Administrator', 1, UNIX_TIMESTAMP());

CREATE TABLE nycategory (
  cid INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  cparentid INTEGER UNSIGNED NULL,
  cposition INTEGER UNSIGNED NOT NULL DEFAULT 0,
  cname VARCHAR(64) NOT NULL,
  cdesc VARCHAR(255) NULL,
  PRIMARY KEY(cid),
  INDEX nycategory_position(cposition),
  INDEX nycategory_parentid(cparentid),
  FOREIGN KEY(cparentid)
    REFERENCES nycategory(cid)
      ON DELETE RESTRICT
      ON UPDATE CASCADE
) ENGINE=InnoDb;

CREATE TABLE nyentry (
  eid INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  ecatid INTEGER UNSIGNED NOT NULL,
  euserid INTEGER UNSIGNED NOT NULL,
  ecreationtimestamp INTEGER UNSIGNED NOT NULL DEFAULT 0,
  etitle VARCHAR(255) NOT NULL,
  ebody TEXT NULL,
  PRIMARY KEY(eid),
  INDEX nyentry_catid(ecatid),
  INDEX nyentry_userid(euserid),
  INDEX nyentry_creationtimestamp(ecreationtimestamp),
  FOREIGN KEY(euserid)
    REFERENCES nyuser(uid)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  FOREIGN KEY(ecatid)
    REFERENCES nycategory(cid)
      ON DELETE CASCADE
      ON UPDATE CASCADE
) ENGINE=InnoDB;