
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

IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'Data'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [Data] (
		[date] datetime,
		jpetl_id int  PRIMARY KEY
	);
END

IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'DataRecord'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [DataRecord] (
		jpetl_idfk int,
		CONSTRAINT fk_DataRecord
			FOREIGN KEY (jpetl_idfk)
			REFERENCES [Data](jpetl_id),
		[id] tinyint,
		jpetl_id int  PRIMARY KEY
	);
END

IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'DataRecordSAMPLE'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [DataRecordSAMPLE] (
		jpetl_idfk int,
		CONSTRAINT fk_DataRecordSAMPLE
			FOREIGN KEY (jpetl_idfk)
			REFERENCES [DataRecord](jpetl_id),
		[id] tinyint,
		[created] datetime,
		[CONTRACT_TERM] varchar(8),
		[PRICE] decimal(6,3),
		[ABSTRACT] varchar(100),
		jpetl_id int  PRIMARY KEY
	);
END

IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'DataRecordSAMPLEADMIN_DEP'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [DataRecordSAMPLEADMIN_DEP] (
		jpetl_idfk int,
		CONSTRAINT fk_DataRecordSAMPLEADMIN_DEP
			FOREIGN KEY (jpetl_idfk)
			REFERENCES [DataRecordSAMPLE](jpetl_id),
		[id] bigint,
		[primaryKey] varchar(10),
		[DEP] varchar(10),
		jpetl_id int  PRIMARY KEY
	);
END

IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'DataRecordSAMPLESUPP_DEP'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [DataRecordSAMPLESUPP_DEP] (
		jpetl_idfk int,
		CONSTRAINT fk_DataRecordSAMPLESUPP_DEP
			FOREIGN KEY (jpetl_idfk)
			REFERENCES [DataRecordSAMPLE](jpetl_id),
		[id] bigint,
		[primaryKey] varchar(19),
		jpetl_id int  PRIMARY KEY
	);
END

IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'DataRecordSAMPLESUPP_DEPDEP'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [DataRecordSAMPLESUPP_DEPDEP] (
		jpetl_idfk int,
		CONSTRAINT fk_DataRecordSAMPLESUPP_DEPDEP
			FOREIGN KEY (jpetl_idfk)
			REFERENCES [DataRecordSAMPLESUPP_DEP](jpetl_id),
		[DEP] varchar(19),
		jpetl_id int  PRIMARY KEY
	);
END

IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'DataRecordSAMPLETITLE'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [DataRecordSAMPLETITLE] (
		jpetl_idfk int,
		CONSTRAINT fk_DataRecordSAMPLETITLE
			FOREIGN KEY (jpetl_idfk)
			REFERENCES [DataRecordSAMPLE](jpetl_id),
		[TITLE] varchar(19),
		jpetl_id int  PRIMARY KEY
	);
END

IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'DataRecordSAMPLESAMPLE_AUTH'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [DataRecordSAMPLESAMPLE_AUTH] (
		jpetl_idfk int,
		CONSTRAINT fk_DataRecordSAMPLESAMPLE_AUTH
			FOREIGN KEY (jpetl_idfk)
			REFERENCES [DataRecordSAMPLE](jpetl_id),
		[id] tinyint,
		[FACULTY_NAME] smallint,
		[FACULTY_NAMEfid] smallint,
		[FNAME] varchar(4),
		[MNAME] varchar(100),
		[LNAME] varchar(3),
		[ISSTUDENT] varchar(100),
		[DISPLAY] varchar(2),
		[INITIATION] datetime,
		jpetl_id int  PRIMARY KEY
	);
END

IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'DataRecordSAMPLESAMPLE_EDITOR'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [DataRecordSAMPLESAMPLE_EDITOR] (
		jpetl_idfk int,
		CONSTRAINT fk_DataRecordSAMPLESAMPLE_EDITOR
			FOREIGN KEY (jpetl_idfk)
			REFERENCES [DataRecordSAMPLE](jpetl_id),
		[id] tinyint,
		[FACULTY_NAME] varchar(100),
		[FNAME] varchar(100),
		[MNAME] varchar(100),
		[LNAME] varchar(100),
		[DISPLAY] varchar(100),
		jpetl_id int  PRIMARY KEY
	);
END
