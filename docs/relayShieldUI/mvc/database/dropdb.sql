-- for use where we can't drop the whole database
-- drop targets of FKs after tables with the FKs

DROP TABLE IF EXISTS RSGroupUserMemberships;
DROP TABLE IF EXISTS RSActivityLog;
DROP TABLE IF EXISTS RSFacilityGroupMemberships;
DROP TABLE IF EXISTS RSDeviceFacilityMatches;
DROP TABLE IF EXISTS RSUsers;
DROP TABLE IF EXISTS RSDeletedStuff;
DROP TABLE IF EXISTS RSFacilities;
DROP TABLE IF EXISTS RSDevices;
DROP TABLE IF EXISTS RSGroups;
DROP TABLE IF EXISTS RSUserTypes;
DROP TABLE IF EXISTS RSHouseKeepingLog;
