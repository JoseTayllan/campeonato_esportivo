# SQLite Migration for Championship Sports App

This branch (`feature/sqlite`) includes a migration from MySQL to SQLite to simplify deployment and reduce infrastructure requirements.

## Changes Made

1. **Database Configuration**
   - Replaced MySQL connection with SQLite in `config/database.php`
   - Added compatibility layer for MySQL-specific code

2. **Schema Conversion**
   - Created SQLite-compatible schema in `db/schema.sqlite.sql` 
   - Converted MySQL types to SQLite equivalents
   - Added proper indices and constraints

3. **Database Initialization**
   - Added `init_sqlite_db.php` script to create and initialize the database
   - Script includes options for sample data

## Benefits of SQLite

- **Simpler Deployment**: No separate database server needed
- **Zero Configuration**: No user management or network setup
- **Single File**: The entire database is contained in one file
- **Cross-Platform**: Works on all operating systems
- **Lower Resource Usage**: Ideal for development and testing
- **Reduced Hosting Costs**: No need for a separate database service on GCP

## How to Use

1. **Initialize the Database**
   ```
   php init_sqlite_db.php
   ```

2. **Verify Database**
   The SQLite database will be created at `db/championship.sqlite`

3. **Test the Application**
   The application should work without further configuration changes.

## SQLite Limitations

While SQLite is powerful for most use cases, be aware of these limitations:

1. **Concurrency**: SQLite has limited support for multiple concurrent writes
2. **No User Management**: No built-in user permissions system
3. **Limited ALTER TABLE**: Some schema changes require table recreation
4. **Size Limitations**: Not ideal for very large databases (>100GB)

## Deployment on GCP

With SQLite, deployment on GCP is simplified:

1. Deploy to a single Compute Engine instance
2. No need for Cloud SQL
3. Ensure proper backup of the SQLite database file

## Reverting to MySQL

If needed, you can revert to MySQL by:

1. Switching back to the main branch
2. Restoring the original MySQL `config/database.php`
3. Setting up a MySQL database server

## Performance Considerations

For production use with many concurrent users, consider:

1. Using proper indices (already included in schema)
2. Setting up regular database maintenance
3. Implementing proper backup strategies
4. Monitoring database file size growth 