CREATE DATABASE seams_db;

USE seams_db;

CREATE TABLE events (
  id INT AUTO_INCREMENT PRIMARY KEY, 
  event_id VARCHAR(50), 
  event_date DATE, 
  start_time TIME, 
  end_time TIME, 
  status ENUM('Planned', 'Active', 'Completed', 'Cancelled'), 
  expected_attendees INT, description TEXT, 
  venue VARCHAR(100)
);
  
-- DUMMY RECORDS
INSERT INTO events (event_id, event_date, start_time, end_time, status, expected_attendees, description, venue) VALUES
('EVT001', '2026-02-20', '09:00:00', '11:00:00', 'Planned', 50, 'Opening ceremony for the school fair.', 'Main Auditorium'),
('EVT002', '2026-02-21', '14:00:00', '16:00:00', 'Active', 30, 'Workshop on environmental awareness.', 'Room 101'),
('EVT003', '2026-02-22', '10:00:00', '12:00:00', 'Completed', 100, 'Sports day event.', 'School Field'),
('EVT004', '2026-02-23', '13:00:00', '15:00:00', 'Cancelled', 20, 'Cancelled due to weather.', 'Gymnasium'),
('EVT005', '2026-02-24', '08:00:00', '10:00:00', 'Planned', 75, 'Science fair exhibition.', 'Library Hall');