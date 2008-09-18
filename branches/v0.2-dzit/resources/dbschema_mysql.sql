DROP TABLE IF EXISTS nysearchresult;
DROP TABLE IF EXISTS nysearch;
DROP TABLE IF EXISTS nykeyword;
DROP TABLE IF EXISTS nyconfig;
DROP TABLE IF EXISTS nylocation;
DROP TABLE IF EXISTS nygroup;
DROP TABLE IF EXISTS nyupload;
DROP TABLE IF EXISTS nyreportedentry;
DROP TABLE IF EXISTS nyentry;
DROP TABLE IF EXISTS nycategorywatch;
DROP TABLE IF EXISTS nypwdresetrequest;
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
INSERT INTO nyconfig VALUES ('MAX_UPLOAD_FILES', '5');
INSERT INTO nyconfig VALUES ('MAX_UPLOAD_SIZE', '1000000');
INSERT INTO nyconfig VALUES ('ALLOWED_UPLOAD_FILE_TYPES', '.gif .png .jpg');
INSERT INTO nyconfig VALUES ('EMAIL_OUTGOING', 'noreply@domain.com');
INSERT INTO nyconfig VALUES ('EMAIL_ADMINISTRATOR', 'admin@domain.com');
INSERT INTO nyconfig VALUES ('TEMPLATE_URI', '/templates/{folder}/');
INSERT INTO nyconfig VALUES ('DATE_FORMAT', 'd-m-Y');
INSERT INTO nyconfig VALUES ('DATETIME_FORMAT', 'h:ia d-m-Y');
INSERT INTO nyconfig VALUES ('NUM_TOP_CATEGORIES', '1');
INSERT INTO nyconfig VALUES ('ADS_EXPIRY_DAYS', '7');
INSERT INTO nyconfig VALUES ('AUTO_DELETE_EXPIRED_ADS', '1');

CREATE TABLE nylocation (
	lid						INTEGER			NOT NULL AUTO_INCREMENT,
	lname					VARCHAR(64)		NOT NULL,
	PRIMARY KEY (lid)
) ENGINE=InnoDb;				  
INSERT INTO nylocation (lid, lname) VALUES (1, 'An Giang');
INSERT INTO nylocation (lid, lname) VALUES (2, 'Bà Rịa Vũng Tàu');
INSERT INTO nylocation (lid, lname) VALUES (3, 'Bắc Giang');
INSERT INTO nylocation (lid, lname) VALUES (4, 'Bắc Kạn');
INSERT INTO nylocation (lid, lname) VALUES (5, 'Bạc Liêu');
INSERT INTO nylocation (lid, lname) VALUES (6, 'Bắc Ninh');
INSERT INTO nylocation (lid, lname) VALUES (7, 'Bến Tre');
INSERT INTO nylocation (lid, lname) VALUES (8, 'Bình Định');
INSERT INTO nylocation (lid, lname) VALUES (9, 'Bình Dương');
INSERT INTO nylocation (lid, lname) VALUES (10, 'Bình Phước');
INSERT INTO nylocation (lid, lname) VALUES (11, 'Bình Thuận');
INSERT INTO nylocation (lid, lname) VALUES (12, 'Cà Mau');
INSERT INTO nylocation (lid, lname) VALUES (13, 'Cần Thơ');
INSERT INTO nylocation (lid, lname) VALUES (14, 'Cao Bằng');
INSERT INTO nylocation (lid, lname) VALUES (15, 'Đà Nẵng');
INSERT INTO nylocation (lid, lname) VALUES (16, 'Đắc Lắc');
INSERT INTO nylocation (lid, lname) VALUES (17, 'Đắc Nông');
INSERT INTO nylocation (lid, lname) VALUES (18, 'Điện Biên');
INSERT INTO nylocation (lid, lname) VALUES (19, 'Đồng Nai');
INSERT INTO nylocation (lid, lname) VALUES (20, 'Đồng Tháp');
INSERT INTO nylocation (lid, lname) VALUES (21, 'Gia Lai');
INSERT INTO nylocation (lid, lname) VALUES (22, 'Hà Giang');
INSERT INTO nylocation (lid, lname) VALUES (23, 'Hà Nam');
INSERT INTO nylocation (lid, lname) VALUES (24, 'Hà Nội');
INSERT INTO nylocation (lid, lname) VALUES (25, 'Hà Tây');
INSERT INTO nylocation (lid, lname) VALUES (26, 'Hà Tĩnh');
INSERT INTO nylocation (lid, lname) VALUES (27, 'Hải Dương');
INSERT INTO nylocation (lid, lname) VALUES (28, 'Hải Phòng');
INSERT INTO nylocation (lid, lname) VALUES (29, 'Hậu Giang');
INSERT INTO nylocation (lid, lname) VALUES (30, 'Hoà Bình');
INSERT INTO nylocation (lid, lname) VALUES (31, 'Hưng Yên');
INSERT INTO nylocation (lid, lname) VALUES (32, 'Khánh Hoà');
INSERT INTO nylocation (lid, lname) VALUES (33, 'Kiên Giang');
INSERT INTO nylocation (lid, lname) VALUES (34, 'Kon Tum');
INSERT INTO nylocation (lid, lname) VALUES (35, 'Lai Châu');
INSERT INTO nylocation (lid, lname) VALUES (36, 'Lâm Đồng');
INSERT INTO nylocation (lid, lname) VALUES (37, 'Lạng Sơn');
INSERT INTO nylocation (lid, lname) VALUES (38, 'Lào Cai');
INSERT INTO nylocation (lid, lname) VALUES (39, 'Long An');
INSERT INTO nylocation (lid, lname) VALUES (40, 'Nam Định');
INSERT INTO nylocation (lid, lname) VALUES (41, 'Nghệ An');
INSERT INTO nylocation (lid, lname) VALUES (42, 'Ninh Bình');
INSERT INTO nylocation (lid, lname) VALUES (43, 'Ninh Thuận');
INSERT INTO nylocation (lid, lname) VALUES (44, 'Phú Thọ');
INSERT INTO nylocation (lid, lname) VALUES (45, 'Phú Yên');
INSERT INTO nylocation (lid, lname) VALUES (46, 'Quảng Bình');
INSERT INTO nylocation (lid, lname) VALUES (47, 'Quảng Nam');
INSERT INTO nylocation (lid, lname) VALUES (48, 'Quảng Ngãi');
INSERT INTO nylocation (lid, lname) VALUES (49, 'Quảng Ninh');
INSERT INTO nylocation (lid, lname) VALUES (50, 'Quảng Trị');
INSERT INTO nylocation (lid, lname) VALUES (51, 'Sóc Trăng');
INSERT INTO nylocation (lid, lname) VALUES (52, 'Sơn La');
INSERT INTO nylocation (lid, lname) VALUES (53, 'TP Hồ Chí Minh');
INSERT INTO nylocation (lid, lname) VALUES (54, 'Tây Ninh');
INSERT INTO nylocation (lid, lname) VALUES (55, 'Thái Bình');
INSERT INTO nylocation (lid, lname) VALUES (56, 'Thái Nguyên');
INSERT INTO nylocation (lid, lname) VALUES (57, 'Thanh Hoá');
INSERT INTO nylocation (lid, lname) VALUES (58, 'Thừa thiên Huế');
INSERT INTO nylocation (lid, lname) VALUES (59, 'Tiền Giang');
INSERT INTO nylocation (lid, lname) VALUES (60, 'Trà Vinh');
INSERT INTO nylocation (lid, lname) VALUES (61, 'Tuyên Quang');
INSERT INTO nylocation (lid, lname) VALUES (62, 'Vĩnh Long');
INSERT INTO nylocation (lid, lname) VALUES (63, 'Vĩnh Phúc');
INSERT INTO nylocation (lid, lname) VALUES (64, 'Yên Bái');

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
	uactivationcode			VARCHAR(32),
	PRIMARY KEY(uid)
) ENGINE=InnoDb;
INSERT INTO nyuser (uid, uloginname, upassword, uemail, ufullname, ugroupid, ucreationtimestamp)
VALUES (1, 'admin', MD5('password'), 'admin@domain.com', 'Administrator', 1, UNIX_TIMESTAMP());
INSERT INTO nyuser (uid, uloginname, upassword, uemail, ufullname, ugroupid, ucreationtimestamp)
VALUES (2, 'moderator', MD5('password'), 'moderator@domain.com', 'Moderator', 1, UNIX_TIMESTAMP());

CREATE TABLE nypwdresetrequest (
	pruid					INTEGER			NOT NULL,
	prtimestamp				INTEGER			NOT NULL DEFAULT 0,
		INDEX (prtimestamp),
	prpwdresetcode			CHAR(32),
		INDEX (prpwdresetcode),
	PRIMARY KEY (pruid),
	FOREIGN KEY (pruid) REFERENCES nyuser(uid) ON DELETE CASCADE
) ENGINE=InnoDb;

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
	INDEX (eid, ecatid),
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
	elocation				INTEGER,
		INDEX (elocation),
	eprice					DOUBLE,
		INDEX (eprice),
	etype					TINYINT			NOT NULL DEFAULT 0,
		INDEX (etype),
	ehtml					TINYINT			NOT NULL DEFAULT 0,
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

CREATE TABLE nyreportedentry (
	rentryid				INTEGER			NOT NULL,
	PRIMARY KEY (rentryid),
		FOREIGN KEY (rentryid) REFERENCES nyentry(eid) ON DELETE CASCADE,
	rcreationtimestamp		INTEGER			NOT NULL DEFAULT 0,
		INDEX (rcreationtimestamp),
	rreporterid				INTEGER	
) ENGINE=InnoDB;

CREATE TABLE nycategorywatch (
	categoryid				INTEGER			NOT NULL,
	userid					INTEGER			NOT NULL,
		INDEX (userid),
	PRIMARY KEY (categoryid, userid),
	FOREIGN KEY (categoryid) REFERENCES nycategory(cid) ON DELETE CASCADE,
	FOREIGN KEY (userid) REFERENCES nyuser(uid) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE nykeyword (
	kword					VARCHAR(32)		NOT NULL,
	kentryid				INTEGER			NOT NULL,
		INDEX (kentryid),
	PRIMARY KEY (kword, kentryid),
	FOREIGN KEY (kentryid) REFERENCES nyentry(eid) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE nysearch (
	sid						INTEGER			NOT NULL AUTO_INCREMENT,
	skeyword				VARCHAR(64)		NOT NULL,
		INDEX (skeyword),
	stimestamp				INTEGER			NOT NULL,
		INDEX (stimestamp),
	PRIMARY KEY (sid)
) ENGINE=InnoDB;

CREATE TABLE nysearchresult (
	sid						INTEGER			NOT NULL,
	sentryid				INTEGER			NOT NULL,
		INDEX (sentryid),
	PRIMARY KEY (sid, sentryid),
	FOREIGN KEY (sid) REFERENCES nysearch (sid) ON DELETE CASCADE,
	FOREIGN KEY (sentryid) REFERENCES nyentry (eid) ON DELETE CASCADE
) ENGINE=InnoDB;
