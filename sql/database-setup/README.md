# Database Setup for User Management

This project provides SQL scripts to set up a user management system with role-based access. It includes the creation of a `users` table and seeding it with initial data.

## Project Structure

```
database-setup
├── sql
│   ├── create_users_table.sql
│   └── seed_users.sql
└── README.md
```

## Setup Instructions

1. **Create the Database**: 
   Before running the SQL scripts, ensure you have a MySQL database created. You can create a database using the following command:
   ```sql
   CREATE DATABASE your_database_name;
   ```

2. **Run the Create Table Script**:
   Execute the `create_users_table.sql` script to create the `users` table. You can do this using a MySQL client or command line:
   ```sql
   SOURCE path/to/database-setup/sql/create_users_table.sql;
   ```

3. **Seed the Users Table**:
   After creating the table, run the `seed_users.sql` script to insert initial user data:
   ```sql
   SOURCE path/to/database-setup/sql/seed_users.sql;
   ```

## SQL Scripts Overview

- **create_users_table.sql**: This script creates the `users` table with the following columns:
  - `id`: INT, Primary Key, Auto Increment
  - `username`: VARCHAR(50), Unique
  - `email`: VARCHAR(100), Unique
  - `password`: VARCHAR(255)
  - `role`: ENUM('admin', 'employee', 'customer')

- **seed_users.sql**: This script inserts sample users into the `users` table with different roles.

## Conclusion

Follow the instructions above to set up the database for user management. Ensure that you have the necessary permissions to create tables and insert data in your MySQL database.