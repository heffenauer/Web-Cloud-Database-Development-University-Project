create table users (
	user_id int primary key,
	username varchar(255),
	pword varchar(255),
	email varchar(255),
	is_admin varchar(1)	
);

create table cities (
	city_id int primary key,
	city_name varchar(255)
);

create table aq_parameters (
	parameter_id int primary key,
	parameter_name varchar(255)	
);

create table aq_sources (
	source_id int primary key,
	source_name varchar(255),
	source_type varchar(255),
	address varchar(255)
);

create table locations (
	location_id int not null primary key,
	location_name varchar(255),
	fk_city int references cities(city_id)
);

create table aq_measurements (
    measurement_id  int NOT NULL,
    measurement_val double ,
    measurement_date date,
    fk_location int references locations(location_id),
    fk_source int references aq_sources(source_id),
    fk_parameter int references aq_parameters(parameter_id),
    fk_user int references users(user_id),
    PRIMARY KEY (measurment_id)
);