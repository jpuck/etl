
INSERT INTO [Data] (
	[date],
	jpetl_id
) SELECT
	[date],
	jpetl_id
FROM [tmpData];

INSERT INTO [DataRecord] (
	jpetl_idfk,
	[id],
	jpetl_id
) SELECT
	jpetl_idfk,
	[id],
	jpetl_id
FROM [tmpDataRecord];

INSERT INTO [DataRecordSAMPLE] (
	jpetl_idfk,
	[id],
	[created],
	[CONTRACT_TERM],
	[PRICE],
	[ABSTRACT],
	jpetl_id
) SELECT
	jpetl_idfk,
	[id],
	[created],
	[CONTRACT_TERM],
	[PRICE],
	[ABSTRACT],
	jpetl_id
FROM [tmpDataRecordSAMPLE];

INSERT INTO [DataRecordSAMPLEADMIN_DEP] (
	jpetl_idfk,
	[id],
	[primaryKey],
	[DEP],
	jpetl_id
) SELECT
	jpetl_idfk,
	[id],
	[primaryKey],
	[DEP],
	jpetl_id
FROM [tmpDataRecordSAMPLEADMIN_DEP];

INSERT INTO [DataRecordSAMPLESUPP_DEP] (
	jpetl_idfk,
	[id],
	[primaryKey],
	jpetl_id
) SELECT
	jpetl_idfk,
	[id],
	[primaryKey],
	jpetl_id
FROM [tmpDataRecordSAMPLESUPP_DEP];

INSERT INTO [DataRecordSAMPLESUPP_DEPDEP] (
	jpetl_idfk,
	[DEP],
	jpetl_id
) SELECT
	jpetl_idfk,
	[DEP],
	jpetl_id
FROM [tmpDataRecordSAMPLESUPP_DEPDEP];

INSERT INTO [DataRecordSAMPLETITLE] (
	jpetl_idfk,
	[TITLE],
	jpetl_id
) SELECT
	jpetl_idfk,
	[TITLE],
	jpetl_id
FROM [tmpDataRecordSAMPLETITLE];

INSERT INTO [DataRecordSAMPLESAMPLE_AUTH] (
	jpetl_idfk,
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
	jpetl_idfk,
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
	jpetl_idfk,
	[id],
	[FACULTY_NAME],
	[FNAME],
	[MNAME],
	[LNAME],
	[DISPLAY],
	jpetl_id
) SELECT
	jpetl_idfk,
	[id],
	[FACULTY_NAME],
	[FNAME],
	[MNAME],
	[LNAME],
	[DISPLAY],
	jpetl_id
FROM [tmpDataRecordSAMPLESAMPLE_EDITOR];
