-- Portable script for creating the RelayShield database
-- 
-- mysql -D RelayShieldDB -u root -p < createdb.sql 

-- RealyShield HouseKeeping Log table
CREATE TABLE RSHouseKeepingLog(
	id INT PRIMARY KEY AUTO_INCREMENT,
	occurredat TIMESTAMP,
	remarks VARCHAR(255),	-- auto generated / canned
	userid INT,
	FOREIGN KEY (userid) REFERENCES RSUsers(id)
	);

-- RelayShield User Types table
CREATE TABLE RSUserTypes(
	id INT PRIMARY KEY AUTO_INCREMENT,
	typename VARCHAR(20) NOT NULL UNIQUE,
	typedescription VARCHAR(255)
	);

-- RelayShield Users table
CREATE TABLE RSUsers(
	id INT PRIMARY KEY AUTO_INCREMENT,
	firstname VARCHAR(100),
	lastname VARCHAR(100),
	email VARCHAR(150) NOT NULL UNIQUE,
	username VARCHAR(50) NOT NULL UNIQUE,
	encryptedpassword VARCHAR(255),
	usertypeid INT,
	activestatus BOOLEAN DEFAULT false,
	FOREIGN KEY (usertypeid) REFERENCES RSUserTypes(id)
	);
-- TODO: add an index to the username column to speed up look-up during login.
	
-- RelayShield User Groups table
CREATE TABLE RSGroups(
	id INT PRIMARY KEY AUTO_INCREMENT,
	groupname VARCHAR(30) NOT NULL UNIQUE,
	groupdescription VARCHAR(255),
	activestatus BOOLEAN DEFAULT false
	);
	
-- RelayShield Group User Memberships table
CREATE TABLE RSGroupUserMemberships(
	id INT PRIMARY KEY AUTO_INCREMENT,
	groupid INT,
	userid INT,
	UNIQUE(groupid, userid),
	FOREIGN KEY (groupid) REFERENCES RSGroups(id),
	FOREIGN KEY (userid) REFERENCES RSUsers(id)
	);

-- RelayShield Devices table
CREATE TABLE RSDevices(
	id INT PRIMARY KEY AUTO_INCREMENT,
	deviceid VARCHAR(100) NOT NULL UNIQUE,
	encryptedaccesstoken VARCHAR(255),
	devicedescription VARCHAR(255),
	activestatus BOOLEAN DEFAULT false
	);

-- RelayShield Facilities table
CREATE TABLE RSFacilities(
	id INT PRIMARY KEY AUTO_INCREMENT,
	facilityname VARCHAR(30) NOT NULL UNIQUE,
	numberofrelays INT,
	activestatus BOOLEAN DEFAULT false
	);
	
-- RelayShield Device-Facility matching table
CREATE TABLE RSDeviceFacilityMatches(
	id INT PRIMARY KEY AUTO_INCREMENT,
	deviceid INT,	-- NB: this is the device id not the deviceid!
	facilityid INT,
	UNIQUE(deviceid, facilityid),
	FOREIGN KEY (deviceid) REFERENCES RSDevices(id),
	FOREIGN KEY (facilityid) REFERENCES RSFacilities(id)
	);
	
-- RelayShield Facility Group Memberships table
CREATE TABLE RSFacilityGroupMemberships(
	id INT PRIMARY KEY AUTO_INCREMENT,
	facilityid INT,
	groupid INT,
	UNIQUE(facilityid, groupid),
	FOREIGN KEY (facilityid) REFERENCES RSFacilities(id),
	FOREIGN KEY (groupid) REFERENCES RSGroups(id)
	);

-- RelayShield Activity Log table
CREATE TABLE RSActivityLog(
	id INT PRIMARY KEY AUTO_INCREMENT,
	facilityid INT,
	relaynumber INT,		-- 1 to 4
	activitytype VARCHAR(10),	-- auto / manual
	activityduration INT,		-- in seconds
	activityinterval INT,		-- in minutes
	activitystatus BOOLEAN,		-- idle|busy == false|true
	FOREIGN KEY (facilityid) REFERENCES RSFacilities(id)
	-- userid - activity owner (TODO)
	);
	
-- RelayShield Deleted Stuff table
CREATE TABLE RSDeletedStuff(
	id INT PRIMARY KEY AUTO_INCREMENT,
	fromtable VARCHAR(30) NOT NULL,
	recordsummary VARCHAR(255)	-- stringified summary of tuple being deleted
	);

-- Initializing the database
INSERT INTO RSUserTypes (typename, typedescription) VALUES ('regular', 'single-facility access'), ('uber', 'multi-facility access'), ('admin', 'resource allocator'), ('super', 'entity creator/destroyer');
INSERT INTO RSUsers (firstname, lastname, username, encryptedpassword, usertypeid, activestatus) VALUES ('SYSTEM', '', '', '', 99999, true), ('Rick', 'Root', 'rroot', 'Rroot123', 4, true);
INSERT INTO RSHouseKeepingLog (occurredat, remarks) VALUES (now(), 'Initialization of database!');

-- sample data for RSUsers

-- sample data for RSDevices
INSERT INTO RSDevices (deviceid, encryptedaccesstoken, devicedescription, activestatus) VALUES ('ZZZZZZZZZZZZZZZZ', '!@!@#@##$@#$#QWERWERF#$T', 'photon connected to a 4-switch relayshield', true), 
('qqqqqqqqqqqqqqqq', '!skjhsd987fs9fsdfWERF#$T', 'photon connected to a 8-switch photon', true), 
('350042000e51353532343635', '8db83ede2e5eb5b0047413935c796aaf9ab165ff', 'photon connected to a 4-switch relayshield', true), 
('mmmmmmmmmmmmmmmm', 'snl;dkfns;dns;dns;ndlsdn', 'photon connected to a 3-switch electron', true), 
('bBBBBBBBBBBBbbbb', '!kjsadskhfdsklskashdfk$T', 'photon connected to a 5-switch gadget', true);

-- sample data for RSFacilities
INSERT INTO RSFacilities (facilityname, numberofrelays, activestatus) VALUES ('Area 51', 4, true), ('The Triangle', 3, true), ('All dead!', 0, false), ('White house', 2, true);

-- sample data for RSGroups
INSERT INTO RSGroups (groupname, groupdescription, activestatus) VALUES ('area_51', 'level 5 clearance', true);

-- sample data for RSGroupUserMemberships
INSERT INTO RSGroupUserMemberships (groupid, userid) VALUES (1, 1), (1, 3);

-- sample data for RSFacilityGroupMemberships
INSERT INTO RSFacilityGroupMemberships (facilityid, groupid) VALUES (1, 1);

-- sample data for RSDeviceFacilityMatches
INSERT INTO RSDeviceFacilityMatches (deviceid, facilityid) VALUES (1, 2), (2, 3), (3, 1), (4, 4);
