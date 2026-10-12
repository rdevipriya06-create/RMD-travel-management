# RMD - Reach More Destinations (Travel Booking System)

## Project Title
RMD – Reach More Destinations: Server-Side Extension (Assignment-3)

## Application Domain
Travel & Tour Booking Website

## Technologies Used
- Frontend (Assignment-2, unchanged): HTML5, CSS3, JavaScript
- Backend (Assignment-3): PHP 8, MySQLi
- Database: MySQL
- Data Interchange: XML (SimpleXML)

## Features Implemented (Assignment-3)
- PHP form processing and server-side validation for login, registration, booking, enquiry and review forms
- MySQL database (`rmd_travel`) with tables: users, packages, bookings, enquiries, reviews
- Insert operations: register, book package, submit enquiry, submit review
- Retrieve operations: list bookings, list reviews, list/search packages
- Update operation: edit an existing booking (date, persons, status)
- Delete operation: cancel a booking
- Search/filter: search packages by name or destination
- XML creation: exports current bookings to `xml/bookings_export.xml`
- XML reading/parsing: `packages.xml` is parsed with SimpleXML to serve the package catalog

## Setup Instructions
1. Install XAMPP / WAMP (PHP + MySQL + Apache).
2. Copy this folder into `htdocs/rmd-backend`.
3. Import the database:
   - Open phpMyAdmin, create nothing manually — just run `sql/schema.sql` (it creates the `rmd_travel` database and tables, and seeds sample packages).
4. Edit `config/db.php` if your MySQL username/password differ from the defaults.
5. Start Apache + MySQL, then visit `http://localhost/rmd-backend/`.
6. Update the frontend's JavaScript `fetch()` calls to point at these PHP endpoints (see below).

## Endpoints
| Endpoint | Method | Purpose |
|---|---|---|
| register.php | POST | Create user account |
| login.php | POST | Authenticate user, starts session |
| logout.php | GET/POST | Ends session |
| book.php | POST | Insert a new booking |
| get_bookings.php | GET | Retrieve bookings (optional `?email=`) |
| update_booking.php | POST | Update a booking |
| cancel_booking.php | POST | Delete a booking |
| enquiry.php | POST | Insert contact enquiry |
| add_review.php | POST | Insert a review |
| get_reviews.php | GET | Retrieve latest reviews |
| search_packages.php | GET | Search packages (`?q=`) |
| read_packages_xml.php | GET | Parses xml/packages.xml, returns JSON |
| export_bookings_xml.php | GET | Creates & downloads bookings_export.xml |

## Screenshots
_(Add screenshots here: form submission, phpMyAdmin table records, update/delete demo, search results, and the generated XML file open in a browser.)_
