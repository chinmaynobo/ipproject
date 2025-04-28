CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    contact VARCHAR(20) NOT NULL,
    location VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    attendance_date DATE NOT NULL,
    attendance_month VARCHAR(20) NOT NULL,
    attendance_year INT NOT NULL,
    attendance VARCHAR(50) NOT NULL,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE (student_id, attendance_date)
);

CREATE TABLE pdf_files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    uploaded_by INT NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE courses (
    code VARCHAR(10) PRIMARY KEY,
    name VARCHAR(100),
    instructor VARCHAR(50),
    schedule VARCHAR(50),
    credits INT
);

CREATE TABLE timetable (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    course_code VARCHAR(20),
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (course_code) REFERENCES courses(code)
);

CREATE TABLE student_courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course_code VARCHAR(10) NOT NULL,
    FOREIGN KEY (student_id) REFERENCES users(id),
    FOREIGN KEY (course_code) REFERENCES courses(code),
    UNIQUE (student_id, course_code)
);

INSERT INTO courses (code, name, instructor, schedule, credits) VALUES
('CSE101', 'Introduction to Programming', 'Dr. Alice Smith', 'Mon-Wed 9:00-10:00', 3),
('CSE102', 'Data Structures nitrotype speed hack and Algorithms', 'Dr. Bob Johnson', 'Tue-Thu 10:00-11:00', 4),
('CSE201', 'Object-Oriented Programming', 'Dr. Clara Lee', 'Mon-Wed 11:00-12:00', 3),
('CSE202', 'Database Systems', 'Dr. David Brown', 'Tue-Thu 1:00-2:00', 4),
('CSE301', 'Operating Systems', 'Dr. Emma Wilson', 'Mon-Wed 2:00-3:00', 3),
('CSE302', 'Computer Networks', 'Dr. Frank Davis', 'Tue-Thu 9:00-10:00', 4),
('CSE401', 'Software Engineering', 'Dr. Grace Taylor', 'Mon-Wed 10:00-11:00', 3),
('CSE402', 'Artificial Intelligence', 'Dr. Henry Clark', 'Tue-Thu 11:00-12:00', 4),
('CSE403', 'Machine Learning', 'Dr. Ivy Martinez', 'Mon-Wed 1:00-2:00', 3),
('CSE404', 'Cybersecurity Fundamentals', 'Dr. Jack White', 'Tue-Thu 2:00-3:00', 3);