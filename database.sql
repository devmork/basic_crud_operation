CREATE DATABASE seams_db;

USE seams_db;

CREATE TABLE attendance (
  id INT AUTO_INCREMENT PRIMARY KEY, 
  event_id VARCHAR(50), 
  phase_date DATE, 
  start_time TIME, 
  end_time TIME, 
  phase_status ENUM('Planned', 'Active', 'Completed', 'Cancelled'), 
  expected_attendees INT, description TEXT, 
  venue VARCHAR(100)
);