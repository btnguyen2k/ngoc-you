DROP TABLE IF EXISTS nygroup;
CREATE TABLE nygroup (
  gid INTEGER UNSIGNED NOT NULL,
  gname VARCHAR(48) NOT NULL,
  gdesc VARCHAR(255) NULL,
  PRIMARY KEY(gid)
);
INSERT INTO nygroup (gid, gname, gdesc)
VALUES (1, 'Administrator', 'Administrator group, people in this group will have all permissions.');
INSERT INTO nygroup (gid, gname, gdesc)
VALUES (2, 'Moderator', 'Moderator group, people in this group will have selected administrative permissions.');
INSERT INTO nygroup (gid, gname, gdesc)
VALUES (3, 'Member', 'Normal user group.');

DROP TABLE IF EXISTS nyuser;
CREATE TABLE nyuser (
  uid INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  uloginname VARCHAR(32) NOT NULL,
  upassword VARCHAR(48) NOT NULL,
  uemail VARCHAR(64) NOT NULL,
  ufullname VARCHAR(64) NULL,
  ucreationtimestamp INTEGER UNSIGNED NOT NULL DEFAULT 0,
  ugroupid INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(uid),
  UNIQUE INDEX nyuser_loginname(uloginname),
  UNIQUE INDEX nyuser_email(uemail),
  INDEX nyuser_creationtimestamp(ucreationtimestamp)
);
INSERT INTO nyuser (uid, uloginname, upassword, uemail, ufullname, ugroupid, ucreationtimestamp)
VALUES (1, 'admin', MD5('password'), 'admin@domain.com', 'Administrator', 1, UNIX_TIMESTAMP());

DROP TABLE IF EXISTS nycategory;
CREATE TABLE nycategory (
  cid INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  cparentid INTEGER UNSIGNED NULL,
  cposition INTEGER UNSIGNED NOT NULL DEFAULT 0,
  cname VARCHAR(64) NOT NULL,
  cdesc VARCHAR(255) NULL,
  PRIMARY KEY(cid),
  INDEX nycategory_position(cposition),
  INDEX nycategory_FKIndex1(cparentid)
);