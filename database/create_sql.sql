CREATE TABLE User (
  user_id INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(255),
  password VARCHAR(255),
  city VARCHAR(255),
  email VARCHAR(255),
  is_admin BOOLEAN
);

CREATE TABLE City (
  city_id INT PRIMARY KEY AUTO_INCREMENT,
  city_name VARCHAR(255)
);

CREATE TABLE Location (
  location_id INT PRIMARY KEY AUTO_INCREMENT,
  location_name VARCHAR(255),
  city_id INT,
  FOREIGN KEY (city_id) REFERENCES City(city_id)
);

CREATE TABLE AirQualitySource (
  source_id INT PRIMARY KEY AUTO_INCREMENT,
  source_name VARCHAR(255),
  source_type VARCHAR(255)
);

CREATE TABLE AirQualityParameter (
  parameter_id INT PRIMARY KEY AUTO_INCREMENT,
  parameter_name VARCHAR(255)
);

CREATE TABLE AirQualityMeasurement (
  measurement_id INT PRIMARY KEY AUTO_INCREMENT,
  city_id INT,
  source_id INT,
  parameter_id INT,
  measurement_value DECIMAL(10, 2),
  measurement_datetime DATETIME,
  user_id INT,
  FOREIGN KEY (city_id) REFERENCES City(city_id),
  FOREIGN KEY (source_id) REFERENCES AirQualitySource(source_id),
  FOREIGN KEY (parameter_id) REFERENCES AirQualityParameter(parameter_id),
  FOREIGN KEY (user_id) REFERENCES User(user_id)
);
