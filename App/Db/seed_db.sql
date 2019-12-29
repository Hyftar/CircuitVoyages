USE labernoisdb;
START TRANSACTION;

INSERT INTO languages(name)
VALUES ('FRENCH'), ('ENGLISH'), ('SPANISH');

SELECT @id := id FROM languages WHERE name = 'FRENCH';

INSERT INTO passwords(password_salt, password_hash)
VALUES ('7ddf7fbfe664d535294c5abc58cc1d79f2ffc8b22cb70281101eb32cb2f72acd', '151197a06073cfe29e24d2367b2b1403073fde21401bfd08d9c6dece9f8259d9');

INSERT INTO employees(
    first_name,
    last_name,
    date_of_birth,
    active,
    phone_number,
    email,
    password_id)
VALUES (
           'Mark',
           'Lemay',
           '1982-05-12',
           1,
           '5148394392',
           'john_doe@example.com',
           LAST_INSERT_ID()
       );

INSERT INTO employees_languages(language_id, employee_id)
VALUES (@id, LAST_INSERT_ID());

COMMIT;
