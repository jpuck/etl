
INSERT INTO [Data] (
	[date],
	jpetl_id
) SELECT
	[date],
	jpetl_id
FROM [tmpData];

INSERT INTO [DataRecord] (
	jpetl_pid,
	[id],
	jpetl_id
) SELECT
	jpetl_pid,
	[id],
	jpetl_id
FROM [tmpDataRecord];

INSERT INTO [DataRecordSAMPLE] (
	jpetl_pid,
	[id],
	[created],
	[CONTRACT_TERM],
	[PRICE],
	[ABSTRACT],
	jpetl_id
) SELECT
	jpetl_pid,
	[id],
	[created],
	[CONTRACT_TERM],
	[PRICE],
	[ABSTRACT],
	jpetl_id
FROM [tmpDataRecordSAMPLE];

INSERT INTO [DataRecordSAMPLEADMIN_DEP] (
	jpetl_pid,
	[id],
	[primaryKey],
	[DEP],
	jpetl_id
) SELECT
	jpetl_pid,
	[id],
	[primaryKey],
	[DEP],
	jpetl_id
FROM [tmpDataRecordSAMPLEADMIN_DEP];

INSERT INTO [DataRecordSAMPLESUPP_DEP] (
	jpetl_pid,
	[id],
	[primaryKey],
	jpetl_id
) SELECT
	jpetl_pid,
	[id],
	[primaryKey],
	jpetl_id
FROM [tmpDataRecordSAMPLESUPP_DEP];

INSERT INTO [DataRecordSAMPLESUPP_DEPDEP] (
	jpetl_pid,
	[DEP],
	jpetl_id
) SELECT
	jpetl_pid,
	[DEP],
	jpetl_id
FROM [tmpDataRecordSAMPLESUPP_DEPDEP];

INSERT INTO [DataRecordSAMPLETITLE] (
	jpetl_pid,
	[TITLE],
	jpetl_id
) SELECT
	jpetl_pid,
	[TITLE],
	jpetl_id
FROM [tmpDataRecordSAMPLETITLE];

INSERT INTO [DataRecordSAMPLESAMPLE_AUTH] (
	jpetl_pid,
	[id],
	[FACULTY_NAME],
	[FACULTY_NAMEfid],
	[FNAME],
	[MNAME],
	[LNAME],
	[ISSTUDENT],
	[DISPLAY],
	[INITIATION],
	jpetl_id
) SELECT
	jpetl_pid,
	[id],
	[FACULTY_NAME],
	[FACULTY_NAMEfid],
	[FNAME],
	[MNAME],
	[LNAME],
	[ISSTUDENT],
	[DISPLAY],
	[INITIATION],
	jpetl_id
FROM [tmpDataRecordSAMPLESAMPLE_AUTH];

INSERT INTO [DataRecordSAMPLESAMPLE_EDITOR] (
	jpetl_pid,
	[id],
	[FACULTY_NAME],
	[FNAME],
	[MNAME],
	[LNAME],
	[DISPLAY],
	jpetl_id
) SELECT
	jpetl_pid,
	[id],
	[FACULTY_NAME],
	[FNAME],
	[MNAME],
	[LNAME],
	[DISPLAY],
	jpetl_id
FROM [tmpDataRecordSAMPLESAMPLE_EDITOR];
