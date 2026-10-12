-- ===============================================
-- RMD - Reach More Destinations
-- Database: rmd_travel
-- ===============================================

CREATE DATABASE IF NOT EXISTS rmd_travel;
USE rmd_travel;

-- USERS TABLE
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- PACKAGES TABLE
CREATE TABLE IF NOT EXISTS packages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    destination VARCHAR(100) NOT NULL,
    duration VARCHAR(50),
    price DECIMAL(10,2) NOT NULL,
    description TEXT
);

-- BOOKINGS TABLE
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_ref VARCHAR(20) NOT NULL UNIQUE,
    customer_name VARCHAR(100) NOT NULL,
    customer_email VARCHAR(150) NOT NULL,
    customer_phone VARCHAR(15) NOT NULL,
    package_name VARCHAR(150) NOT NULL,
    travel_date DATE NOT NULL,
    persons INT NOT NULL,
    room_type VARCHAR(50),
    room_price DECIMAL(10,2),
    food_plan VARCHAR(50),
    food_price DECIMAL(10,2),
    special_request TEXT,
    total_amount DECIMAL(10,2) NOT NULL,
    status VARCHAR(20) DEFAULT 'Confirmed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ENQUIRIES TABLE (Contact form)
CREATE TABLE IF NOT EXISTS enquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    subject VARCHAR(150),
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- REVIEWS TABLE
CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- SAMPLE PACKAGE DATA (matches the frontend's package cards)
INSERT INTO packages (name, destination, duration, price, description) VALUES
('Goa Beach Escape', 'Goa', '4 Days / 3 Nights', 8500.00, 'Hotel & Breakfast, Sightseeing, Local Transport'),
('Manali Adventure', 'Manali', '6 Days / 5 Nights', 12500.00, 'Hotel Stay, Mountain Tour, Transport'),
('Kerala Backwater', 'Kerala', '3 Days / 2 Nights', 6500.00, 'Houseboat, Breakfast, Sightseeing');
