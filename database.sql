-- Student Management System Database
-- Ye simple aur clean database structure hai
-- Sirf zaroori tables hain

-- Create database
CREATE DATABASE IF NOT EXISTS student_ms;
USE student_ms;

-- Create admin table
CREATE TABLE admin (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create classes table
CREATE TABLE classes (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    class_name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create batches table
CREATE TABLE batches (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    class_id INT(11) NOT NULL,
    batch_name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    UNIQUE KEY unique_class_batch (class_id, batch_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create students table
CREATE TABLE students (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    roll_number VARCHAR(20) UNIQUE,
    college_id VARCHAR(20) UNIQUE,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    dob DATE NULL,
    gender VARCHAR(10) NULL,
    address TEXT,
    blood_group VARCHAR(10),
    photo VARCHAR(255) DEFAULT 'uploads/default.jpg',
    class_id INT(11),
    batch_id INT(11),
    session VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL,
    FOREIGN KEY (batch_id) REFERENCES batches(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create notices table
CREATE TABLE notices (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    class_id INT(11),
    batch_id INT(11),
    notice_date DATE DEFAULT CURRENT_DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL,
    FOREIGN KEY (batch_id) REFERENCES batches(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create public_notices table
CREATE TABLE public_notices (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    notice_date DATE DEFAULT CURRENT_DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin
INSERT INTO admin (name, email, password, phone, address) VALUES 
('Administrator', 'admin@studentms.com', 'Arshad@123', '9876543210', 'Admin Office, College Campus');

-- Insert sample classes
INSERT INTO classes (class_name, description) VALUES 
('BCA', 'Bachelor of Computer Applications'),
('BBA', 'Bachelor of Business Administration'),
('MCA', 'Master of Computer Applications');

-- Insert sample batches for BCA
INSERT INTO batches (class_id, batch_name, description) VALUES 
(1, 'batch-1', 'BCA First Year'),
(1, 'batch-2', 'BCA Second Year'),
(1, 'batch-3', 'BCA Third Year');

-- Insert sample batches for BBA
INSERT INTO batches (class_id, batch_name, description) VALUES 
(2, 'batch-1', 'BBA First Year'),
(2, 'batch-2', 'BBA Second Year'),
(2, 'batch-3', 'BBA Third Year');

-- Insert sample students
INSERT INTO students (roll_number, college_id, name, email, password, phone, dob, gender, address, blood_group, class_id, batch_id, session) VALUES 
('BCA001', 'COL2023001', 'Rahul Kumar', 'rahul@studentms.com', 'Arshad@123', '9876543211', '2000-05-15', 'Male', '123 Main St, Patna', 'B+', 1, 1, '2023-26'),
('BCA002', 'COL2023002', 'Priya Singh', 'priya@studentms.com', 'Arshad@123', '9876543212', '2001-03-20', 'Female', '456 Park Ave, Patna', 'O+', 1, 2, '2023-26'),
('BBA001', 'COL2023003', 'Amit Kumar', 'amit@studentms.com', 'Arshad@123', '9876543213', '2000-08-10', 'Male', '789 Road, Patna', 'A+', 2, 2, '2023-26');

-- Insert sample notices
INSERT INTO notices (title, content, class_id, batch_id) VALUES 
('Welcome to BCA Program', 'Welcome to the Bachelor of Computer Applications program. We are excited to have you join us.', 1, 1),
('First Year Orientation', 'Orientation program for first year students will be held on Monday at 10 AM.', 1, 1),
('Assignment Submission', 'Please submit your first assignment by end of this week.', 1, 2);

-- Insert sample public notices
INSERT INTO public_notices (title, content) VALUES 
('College Annual Function', 'Annual function will be held on 25th December 2023. All students are invited.'),
('Admission Open 2024', 'Admissions for 2024-25 session are now open. Apply online.'),
('Holiday Notice', 'College will remain closed on 26th January 2024 due to Republic Day.');

-- Create contact_messages table for contact form submissions
CREATE TABLE contact_messages (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
