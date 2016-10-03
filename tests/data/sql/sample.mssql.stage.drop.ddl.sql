
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
	EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'DataRecordSAMPLESUPP_DEPDEP'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	DROP TABLE [DataRecordSAMPLESUPP_DEPDEP];
END

IF (
	EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'DataRecordSAMPLEADMIN_DEP'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	DROP TABLE [DataRecordSAMPLEADMIN_DEP];
END

IF (
	EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'DataRecordSAMPLESUPP_DEP'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	DROP TABLE [DataRecordSAMPLESUPP_DEP];
END

IF (
	EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'DataRecordSAMPLETITLE'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	DROP TABLE [DataRecordSAMPLETITLE];
END

IF (
	EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'DataRecordSAMPLESAMPLE_AUTH'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	DROP TABLE [DataRecordSAMPLESAMPLE_AUTH];
END

IF (
	EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'DataRecordSAMPLESAMPLE_EDITOR'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	DROP TABLE [DataRecordSAMPLESAMPLE_EDITOR];
END

IF (
	EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'DataRecordSAMPLE'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	DROP TABLE [DataRecordSAMPLE];
END

IF (
	EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'DataRecord'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	DROP TABLE [DataRecord];
END

IF (
	EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'Data'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	DROP TABLE [Data];
END