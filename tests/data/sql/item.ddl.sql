
IF (
	EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'item__cost_changesprice01'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	DROP TABLE [item__cost_changesprice01];
END

IF (
	EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'item__pricing_tiers'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	DROP TABLE [item__pricing_tiers];
END

IF (
	EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'item__cost_changes'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	DROP TABLE [item__cost_changes];
END

IF (
	EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'item__quantity_changes'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	DROP TABLE [item__quantity_changes];
END

IF (
	EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'item'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	DROP TABLE [item];
END

IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'item'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [item] (
		[item_id] int,
		[product_id] int,
		[supplier_id] smallint,
		[msrp] tinyint,
		[quantity_available] tinyint,
		[sku] varchar(9),
		[title] varchar(50),
		[status] varchar(8),
		[country_of_origin] varchar(2),
		[gift_wrap_available_flag] tinyint,
		[ships_alone_flag] tinyint,
		[postal_carrier_service_flag] tinyint,
		[ground_carrier_service_flag] tinyint,
		[air_carrier_service_flag] tinyint,
		[freight_carrier_service_flag] tinyint,
		[featured_sku_flag] tinyint,
		[pers_available_flag] tinyint,
		[product_group] varchar(9),
		[product_title] varchar(50),
		[__create_date] datetimeoffset,
		[__last_inventory_update] datetimeoffset,
		[__last_job_run] datetimeoffset,
		[__last_non_inventory_update] datetimeoffset,
		[__last_status_update] datetimeoffset,
		[__last_quantity_update] datetimeoffset,
		[__last_cost_update] datetimeoffset,
		[__last_update] datetimeoffset,
		[__product_item_cnt] tinyint,
		jpetl_id int  PRIMARY KEY
	);
END

IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'item__pricing_tiers'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [item__pricing_tiers] (
		jpetl_idfk int,
		CONSTRAINT fk_item__pricing_tiers
			FOREIGN KEY (jpetl_idfk)
			REFERENCES [item](jpetl_id),
		[price01] tinyint,
		jpetl_id int  PRIMARY KEY
	);
END

IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'item__cost_changes'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [item__cost_changes] (
		jpetl_idfk int,
		CONSTRAINT fk_item__cost_changes
			FOREIGN KEY (jpetl_idfk)
			REFERENCES [item](jpetl_id),
		jpetl_id int  PRIMARY KEY
	);
END

IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'item__cost_changesprice01'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [item__cost_changesprice01] (
		jpetl_idfk int,
		CONSTRAINT fk_item__cost_changesprice01
			FOREIGN KEY (jpetl_idfk)
			REFERENCES [item__cost_changes](jpetl_id),
		[key] int,
		[value] tinyint,
		jpetl_id int  PRIMARY KEY
	);
END

IF (
	NOT EXISTS (
		SELECT *
		FROM INFORMATION_SCHEMA.TABLES
		WHERE TABLE_NAME = 'item__quantity_changes'
		-- AND TABLE_SCHEMA = 'dbo'
	)
)
BEGIN
	CREATE TABLE [item__quantity_changes] (
		jpetl_idfk int,
		CONSTRAINT fk_item__quantity_changes
			FOREIGN KEY (jpetl_idfk)
			REFERENCES [item](jpetl_id),
		[key] int,
		[value] tinyint,
		jpetl_id int  PRIMARY KEY
	);
END
