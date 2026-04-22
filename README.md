# Student Management System

A comprehensive web-based student management system built with PHP, MySQL, and modern web technologies. This system provides complete student administration capabilities with responsive design and user-friendly interface.

## Features

### Admin Panel
- **Student Management**: Add, edit, delete students with complete information
- **Class & Batch Management**: Organize students by classes and batches
- **Notice System**: Create class-specific and public notices
- **Export Functionality**: Export student data to Excel format
- **Search & Filter**: Quick student search by multiple criteria
- **Responsive Design**: Works seamlessly on desktop and mobile devices

### Student Panel
- **Profile Management**: View and edit personal information
- **Notice Viewing**: Access class and public notices
- **Password Management**: Change login password securely
- **Photo Upload**: Manage profile pictures
- **Mobile Responsive**: Access from any device

## Quick Start

### Prerequisites
- XAMPP (Apache + MySQL + PHP)
- Modern web browser (Chrome, Firefox, Safari, Edge)
- Minimum 4GB RAM, 2GB storage

### Installation

1. **Install XAMPP**
   ```
   Download from: https://www.apachefriends.org
   Install with default settings
   ```

2. **Setup Project**
   ```
   Extract to: C:\xampp1\htdocs\collegeproject\student-ms\
   ```

3. **Start Services**
   ```
   Open XAMPP Control Panel
   Start Apache service
   Start MySQL service
   ```

4. **Database Setup**
   ```
   Go to: http://localhost/phpmyadmin
   Create database: student_management
   Import file: database.sql
   ```

5. **Access System**
   ```
   Home: http://localhost/collegeproject/student-ms/
   ```

## Login Credentials

### Admin Access
- **Email**: arshadshaikhofficial0@gmail.com
- **Password**: Arshad@123
- **URL**: http://localhost/collegeproject/student-ms/frontend/admin_login.php

### Student Access
- **Email**: arshadshaikhofficial0@gmail.com
- **Password**: Arshad@123
- **URL**: http://localhost/collegeproject/student-ms/frontend/student_login.php

## Project Structure

```
student-ms/
|
|-- backend/
|   |-- admin_process.php      # Admin operations handler
|   |-- connection_simple.php  # Database connection
|   |-- login_process.php      # Login authentication
|   |-- export_students.php    # Excel export functionality
|   |-- error_handler.php      # Error management
|   `-- validation_helper.php  # Input validation
|
|-- frontend/
|   |-- admin_dashboard.php    # Admin main interface
|   |-- student_dashboard.php  # Student main interface
|   |-- admin_login.php        # Admin login page
|   |-- student_login.php      # Student login page
|   `-- index.php              # Home page
|
|-- database.sql               # Database schema and sample data
|-- README.md                  # This file
|-- LOGIN_CREDENTIALS.md       # Login reference
`-- SETUP_GUIDE.md            # Detailed setup instructions
```

## Database Schema

### Tables
- **admin**: Administrator accounts
- **students**: Student records with complete information
- **classes**: Academic classes (BCA, BBA, MCA)
- **batches**: Class batches (batch-1, batch-2, batch-3)
- **notices**: Class-specific notices
- **public_notices**: General announcements

### Key Features
- Foreign key relationships for data integrity
- Unique constraints for email, roll number, college ID
- Proper indexing for performance
- Sample data for testing

## Usage Guide

### For Administrators
1. Login with admin credentials
2. Add/edit students with complete information
3. Manage classes and batches
4. Create notices for specific classes or public announcements
5. Export student data to Excel for reporting
6. Search and filter students as needed

### For Students
1. Login with student credentials
2. View and update personal profile
3. Access class-specific notices
4. Read public announcements
5. Change password and manage profile photo

## Technical Specifications

### Backend
- **Language**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Security**: Prepared statements, input validation
- **Error Handling**: Centralized error management
- **Session Management**: Secure authentication

### Frontend
- **HTML5**: Semantic markup
- **CSS3**: Modern styling with responsive design
- **JavaScript**: Interactive features and validation
- **Font Awesome**: Icon library
- **Mobile First**: Responsive design approach

### Features
- **Responsive Design**: Works on all screen sizes
- **Form Validation**: Client-side and server-side validation
- **Export Functionality**: Excel/CSV export capability
- **Search System**: Real-time search and filtering
- **Security**: SQL injection protection, XSS prevention

## Troubleshooting

### Common Issues

#### Login Failed
- Check email and password spelling
- Verify database import completed successfully
- Ensure Apache and MySQL services are running

#### Database Connection Error
- Verify MySQL service is running
- Check database name: `student_management`
- Ensure database.sql was imported correctly

#### Page Not Found (404)
- Confirm Apache service is running
- Check project folder path
- Verify URL is correct

#### Notices Not Showing
- Ensure student is assigned to a class
- Verify notices are created for correct class
- Check database table population

### Quick Tests
1. **Database Test**: Access `test_admin_login.php` to verify database connection
2. **Basic Functions**: Try adding a student as admin
3. **Export Test**: Use Excel export feature
4. **Mobile Test**: Access system from mobile device

## Security Features

- **Prepared Statements**: SQL injection prevention
- **Input Validation**: XSS protection
- **Session Management**: Secure authentication
- **Password Hashing**: Secure password storage
- **Error Handling**: Secure error display

## Browser Compatibility

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
- Mobile browsers (iOS Safari, Chrome Mobile)

## Performance

- **Optimized Queries**: Efficient database operations
- **Responsive Images**: Proper image handling
- **Caching**: Browser caching implemented
- **Minified Code**: Optimized CSS and JavaScript

## Support

For issues and questions:
1. Check this README file first
2. Review SETUP_GUIDE.md for detailed instructions
3. Refer to LOGIN_CREDENTIALS.md for access details
4. Test with sample data before production use

## Version History

- **v1.0** (April 2026): Initial release with complete functionality
  - Student management system
  - Admin and student panels
  - Notice system
  - Export functionality
  - Mobile responsive design

## License

This project is developed for educational purposes. Feel free to use and modify according to your needs.

---

**Developer**: Student Management System Team  
**Last Updated**: April 2026  
**Version**: 1.0  
**Framework**: PHP + MySQL + HTML5 + CSS3 + JavaScript
