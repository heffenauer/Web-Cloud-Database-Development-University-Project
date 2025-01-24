-- Query 1: Retrieve all measurements for a specific city
SELECT aqm.*, c.city_name
FROM AirQualityMeasurement AS aqm
JOIN City AS c ON aqm.city_id = c.city_id
WHERE c.city_name = 'YourCityName';

-- Query 2: Retrieve the average measurement value for a specific parameter
SELECT AVG(measurement_value) AS avg_value, ap.parameter_name
FROM AirQualityMeasurement AS aqm
JOIN AirQualityParameter AS ap ON aqm.parameter_id = ap.parameter_id
WHERE ap.parameter_name = 'YourParameterName'
GROUP BY ap.parameter_name;

-- Query 3: Retrieve the top 10 cities with the highest average measurement values
SELECT AVG(measurement_value) AS avg_value, c.city_name
FROM AirQualityMeasurement AS aqm
JOIN City AS c ON aqm.city_id = c.city_id
GROUP BY c.city_name
ORDER BY avg_value DESC
LIMIT 10;

-- Query 4: Retrieve the measurements logged by a specific user
SELECT aqm.*, u.username
FROM AirQualityMeasurement AS aqm
JOIN User AS u ON aqm.user_id = u.user_id
WHERE u.username = 'YourUsername';

-- Query 5: Retrieve the measurements logged within a specific date range
SELECT aqm.*
FROM AirQualityMeasurement AS aqm
WHERE aqm.measurement_datetime >= '2023-01-01'
  AND aqm.measurement_datetime < '2023-02-01';
