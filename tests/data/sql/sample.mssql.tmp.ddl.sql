
IF (
	EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'tmpDataRecordSAMPLESUPP_DEPDEP'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	DROP TABLE [tmpDataRecordSAMPLESUPP_DEPDEP];
END

IF (
	EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'tmpDataRecordSAMPLEADMIN_DEP'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	DROP TABLE [tmpDataRecordSAMPLEADMIN_DEP];
END

IF (
	EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'tmpDataRecordSAMPLESUPP_DEP'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	DROP TABLE [tmpDataRecordSAMPLESUPP_DEP];
END

IF (
	EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'tmpDataRecordSAMPLETITLE'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	DROP TABLE [tmpDataRecordSAMPLETITLE];
END

IF (
	EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'tmpDataRecordSAMPLESAMPLE_AUTH'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	DROP TABLE [tmpDataRecordSAMPLESAMPLE_AUTH];
END

IF (
	EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'tmpDataRecordSAMPLESAMPLE_EDITOR'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	DROP TABLE [tmpDataRecordSAMPLESAMPLE_EDITOR];
END

IF (
	EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'tmpDataRecordSAMPLE'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	DROP TABLE [tmpDataRecordSAMPLE];
END

IF (
	EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'tmpDataRecord'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	DROP TABLE [tmpDataRecord];
END

IF (
	EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'tmpData'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	DROP TABLE [tmpData];
END

IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'tmpData'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [tmpData] (
		[date] datetime,
		jpetl_id int IDENTITY PRIMARY KEY
	);
END

IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'tmpDataRecord'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [tmpDataRecord] (
		jpetl_idfk int,
		CONSTRAINT fk_tmpDataRecord
			FOREIGN KEY (jpetl_idfk)
			REFERENCES [tmpData](jpetl_id),
		[id] tinyint,
		jpetl_id int IDENTITY PRIMARY KEY
	);
END

IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'tmpDataRecordSAMPLE'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [tmpDataRecordSAMPLE] (
		jpetl_idfk int,
		CONSTRAINT fk_tmpDataRecordSAMPLE
			FOREIGN KEY (jpetl_idfk)
			REFERENCES [tmpDataRecord](jpetl_id),
		[id] tinyint,
		[created] datetime,
		[CONTRACT_TERM] varchar(8),
		[PRICE] decimal(6,3),
		[ABSTRACT] varchar(100),
		jpetl_id int IDENTITY PRIMARY KEY
	);
END

IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'tmpDataRecordSAMPLEADMIN_DEP'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [tmpDataRecordSAMPLEADMIN_DEP] (
		jpetl_idfk int,
		CONSTRAINT fk_tmpDataRecordSAMPLEADMIN_DEP
			FOREIGN KEY (jpetl_idfk)
			REFERENCES [tmpDataRecordSAMPLE](jpetl_id),
		[id] bigint,
		[primaryKey] varchar(10),
		[DEP] varchar(10),
		jpetl_id int IDENTITY PRIMARY KEY
	);
END

IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'tmpDataRecordSAMPLESUPP_DEP'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [tmpDataRecordSAMPLESUPP_DEP] (
		jpetl_idfk int,
		CONSTRAINT fk_tmpDataRecordSAMPLESUPP_DEP
			FOREIGN KEY (jpetl_idfk)
			REFERENCES [tmpDataRecordSAMPLE](jpetl_id),
		[id] bigint,
		[primaryKey] varchar(19),
		jpetl_id int IDENTITY PRIMARY KEY
	);
END

IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'tmpDataRecordSAMPLESUPP_DEPDEP'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [tmpDataRecordSAMPLESUPP_DEPDEP] (
		jpetl_idfk int,
		CONSTRAINT fk_tmpDataRecordSAMPLESUPP_DEPDEP
			FOREIGN KEY (jpetl_idfk)
			REFERENCES [tmpDataRecordSAMPLESUPP_DEP](jpetl_id),
		[DEP] varchar(19),
		jpetl_id int IDENTITY PRIMARY KEY
	);
END

IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'tmpDataRecordSAMPLETITLE'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [tmpDataRecordSAMPLETITLE] (
		jpetl_idfk int,
		CONSTRAINT fk_tmpDataRecordSAMPLETITLE
			FOREIGN KEY (jpetl_idfk)
			REFERENCES [tmpDataRecordSAMPLE](jpetl_id),
		[TITLE] varchar(19),
		jpetl_id int IDENTITY PRIMARY KEY
	);
END

IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'tmpDataRecordSAMPLESAMPLE_AUTH'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [tmpDataRecordSAMPLESAMPLE_AUTH] (
		jpetl_idfk int,
		CONSTRAINT fk_tmpDataRecordSAMPLESAMPLE_AUTH
			FOREIGN KEY (jpetl_idfk)
			REFERENCES [tmpDataRecordSAMPLE](jpetl_id),
		[id] tinyint,
		[FACULTY_NAME] smallint,
		[FACULTY_NAMEfid] smallint,
		[FNAME] varchar(4),
		[MNAME] varchar(100),
		[LNAME] varchar(3),
		[ISSTUDENT] varchar(100),
		[DISPLAY] varchar(2),
		[INITIATION] datetime,
		jpetl_id int IDENTITY PRIMARY KEY
	);
END

IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'tmpDataRecordSAMPLESAMPLE_EDITOR'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [tmpDataRecordSAMPLESAMPLE_EDITOR] (
		jpetl_idfk int,
		CONSTRAINT fk_tmpDataRecordSAMPLESAMPLE_EDITOR
			FOREIGN KEY (jpetl_idfk)
			REFERENCES [tmpDataRecordSAMPLE](jpetl_id),
		[id] tinyint,
		[FACULTY_NAME] varchar(100),
		[FNAME] varchar(100),
		[MNAME] varchar(100),
		[LNAME] varchar(100),
		[DISPLAY] varchar(100),
		jpetl_id int IDENTITY PRIMARY KEY
	);
END
