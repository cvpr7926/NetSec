CREATE TABLE Profile (
    ID SERIAL PRIMARY KEY,  -- Use SERIAL for auto-increment in PostgreSQL
    Username VARCHAR(50) UNIQUE NOT NULL,
    Email VARCHAR(100) UNIQUE NOT NULL,
    PasswordHash VARCHAR(255) NOT NULL,
    Biography TEXT NULL,
    ProfileImagePath VARCHAR(255) NULL, 
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);