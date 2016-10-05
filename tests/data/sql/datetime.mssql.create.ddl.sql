
IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'dt'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [dt] (
		jpetl_id int IDENTITY PRIMARY KEY
	);
END

IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'dtmixed'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [dtmixed] (
		jpetl_pid int,
		CONSTRAINT fk_dtmixed
			FOREIGN KEY (jpetl_pid)
			REFERENCES [dt](jpetl_id),
		[mixed] datetimeoffset,
		jpetl_id int IDENTITY PRIMARY KEY
	);
END

IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'dttimezone'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [dttimezone] (
		jpetl_pid int,
		CONSTRAINT fk_dttimezone
			FOREIGN KEY (jpetl_pid)
			REFERENCES [dt](jpetl_id),
		[timezone] datetimeoffset,
		jpetl_id int IDENTITY PRIMARY KEY
	);
END

IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'dtdatetime'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [dtdatetime] (
		jpetl_pid int,
		CONSTRAINT fk_dtdatetime
			FOREIGN KEY (jpetl_pid)
			REFERENCES [dt](jpetl_id),
		[datetime] datetime,
		jpetl_id int IDENTITY PRIMARY KEY
	);
END
