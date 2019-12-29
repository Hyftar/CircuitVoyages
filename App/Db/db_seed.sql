USE labernoisdb;
START TRANSACTION;

/* for Members */

INSERT INTO addresses(`country`,
    `city`,
    `region`,
    `address_line_1`)
VALUES (
           'Canada',
           'Montréal',
           'QC',
           '9235 Avenue Papineau'
		   );

SELECT @id1 := id FROM addresses WHERE address_line_1 = '9235 Avenue Papineau';

INSERT INTO passwords(password_salt, password_hash) /* Values were manually changed! */
VALUES ('7ddf7fbfe664d535294c5abc58cc1d79f2ffc8b22cb70281101eb32cb2f72acf', '151197a06073cfe29e24d2367b2b1403073fde21401bfd08d9c6dece9f8259d0');


INSERT INTO members(   /* Facebook_id & Google_id missing */
    email,
    password_id,
    address_id,
    language_id,
    first_name,
    last_name,
	phone_number,
	date_of_birth)
VALUES (
           'member1@exemple.com',
           LAST_INSERT_ID(),
           @id1,
           @idL1,
           'Jerry',
		   'Bertrand',
           '5148398565',
		   '1983-04-17'
       );


/* for Employees */

/* Medias needed for employees */

INSERT INTO media (`name`,
 `media_type`,
 `description`,
 `path`,
 `header`)
VALUES (
 'Guide1',
 'image',
 'Picture of our guide',
 '/images/guide.png',
 0
 ),
(
 'Guide2',
 'image',
 'Picture of our guide',
 '/images/guideB.jpg',
 0
 );

SELECT @idM1 := id FROM media WHERE name = 'Guide1';
SELECT @idM2 := id FROM media WHERE name = 'Guide2';


INSERT INTO `permissions` (`feature`)
VALUES ('Regular employee'), ('Admin');

SELECT @idPerm1 := id FROM permissions WHERE feature = 'Regular employee';


INSERT INTO `roles` (`name`)
VALUES ('Guide'), ('Admin');

SELECT @idR1 := id FROM roles WHERE name = 'Guide';


/* First guide */

INSERT INTO passwords(password_salt, password_hash)
VALUES ('7ddf7fbfe664d535294c5abc58cc1d79f2ffc8b22cb70281101eb32cb2f72acd', '151197a06073cfe29e24d2367b2b1403073fde21401bfd08d9c6dece9f8259d9');

INSERT INTO employees(
    first_name,
    last_name,
    date_of_birth,
    active,
    media_id,
    phone_number,
    email,
    role_id,
    password_id)
VALUES (
           'Melanie',
           'Francoeur',
           '1982-05-12',
           1,
           @idM1,
           '5148398564',
           'john_doe@example.com',
           @idR1,
           LAST_INSERT_ID()
       );

SELECT @idE1 := id FROM employees WHERE email = 'john_doe@example.com';


INSERT INTO employees_languages(language_id, employee_id)
VALUES (@idL1, @idE1);

INSERT INTO `roles_permissions` (`role_id`, `permission_id`)
VALUES (@idR1, @idPerm1);


/* Second guide */

INSERT INTO passwords(password_salt, password_hash) /* Values were manually changed */
VALUES ('5ddf7fbfe664d535294c5abc58cc1d79f2ffc8b22cb70281101eb32cb2f72acd', '121197a06073cfe29e24d2367b2b1403073fde21401bfd08d9c6dece9f8259d9');

INSERT INTO employees(
    first_name,
    last_name,
    date_of_birth,
    active,
    media_id,
    phone_number,
    email,
    role_id,
    password_id)
VALUES (
           'Guillaume',
           'Bourgeois',
           '1984-05-18',
           1,
           @idM2,
           '5148398563',
           'john_doe2@example.com',
           @idR1,
           LAST_INSERT_ID()
       );

SELECT @idE2 := id FROM employees WHERE email = 'john_doe2@example.com';


INSERT INTO employees_languages(language_id, employee_id)
VALUES (@idL1, @idE2);

INSERT INTO `roles_permissions` (`role_id`, `permission_id`)
VALUES (@idR1, @idPerm1);


/* Medias needed for circuits */

INSERT INTO media (`name`,
 `media_type`,
 `description`,
 `path`,
 `header`)
VALUES (
 'Hawaii Header',
 'image',
 'Sunset in Hawaii',
 '/images/hawaiiHeader.jpg',
 1
 ),
(
 'Italy Header',
 'image',
 'Italian Landscape',
 '/images/Italy.jpg',
 1
 );

SELECT @idM1 := id FROM media WHERE description = 'Sunset in Hawaii';
SELECT @idM2 := id FROM media WHERE description = 'Italian Landscape';


/* Languages needed for circuits */

INSERT INTO languages(name)
VALUES ('FRENCH'), ('ENGLISH'), ('SPANISH');

SELECT @idL1 := id FROM languages WHERE name = 'FRENCH';


/* Categories needed for circuits */

INSERT INTO categories (name, description)
VALUES
("Les grands lieux d'histoire","Visitez les lieux des plus importants moments de l'histoire. Marchez dans les pas des plus grands."),
("Les plus beaux paysages", "Voyez la nature comme jamais. Explorez les plus grandes beautés du monde.");

SELECT @idC1 := id FROM categories WHERE name = "Les grands lieux d'histoire";
SELECT @idC2 := id FROM categories WHERE name = "Les plus beaux paysages";


/* for Circuits */

INSERT INTO circuits (`media_id`,
 `language_id`,
 `category_id`,
 `name`,
 `description`,
 `is_public`)
VALUES (
 @idM1,
 @idL1,
 @idC2,
 'Discover the hawaiian islands',
 'Discover the beautiful islands of Hawaii by participating in a multitude of activities. Admire the local culture, history and cuisine and be amazed by the unforgetable landscapes.',
 1
 ),
(
 @idM1,
 @idL1,
 @idC1,
 'Live the italian lifestyle',
 'Live the authentic italian experience by exploring historic sites, enjoying nice relaxing gondola rides and eating at amazing authentic local restaurants.',
 1
 );

SELECT @idCi1 := id FROM circuits WHERE name = "Discover the hawaiian islands";
SELECT @idCi2 := id FROM circuits WHERE name = "Live the italian lifestyle";


/* for Circuits Trips */

INSERT INTO circuits_trips (`circuit_id`,
 `departure_date`,
 `price`,
 `refund_date`,
 `cancellation_date`,
 `cancellation_fee`,
 `places`,
 `quorum`,
 `is_public`)
VALUES (
 @idCi1,
 '2020-03-22',
 '20000',
 '2020-03-02',
 '2020-02-22',
 '200',
 '15',
 '05',
 1
 ),
(
 @idCi2,
 '2020-05-21',
 '22000',
 '2020-05-01',
 '2020-04-21',
 '200',
 '15',
 '06',
 1
 );

SELECT @idM1 := id FROM members WHERE email = 'member1@exemple.com';

SELECT @idCiT1 := id FROM circuits_trips WHERE circuit_id = @idCi1;
SELECT @idCiT2 := id FROM circuits_trips WHERE circuit_id = @idCi2;


/* for Trips */

 INSERT INTO `trips` (`member_id`,
 `circuit_trip_id`,
 `departure_date`,
 `return_date`)
VALUES (
 @idM1,
 @idCiT1,
 '2020-03-02',
 '2020-03-07'
 );


/* Circuit medias */

INSERT INTO circuits_media (`circuit_id`, `media_id`)
VALUES (@idCi1, @idM1);

INSERT INTO circuits_media (`circuit_id`, `media_id`)
VALUES (@idCi2, @idM2);


/* Circuits trips employees */

INSERT INTO `circuits_trips_employees` (`employee_id`, `circuit_trip_id`, `description`)
VALUES (@idE1, @idCiT1, 'Hello, I will be your guide for this trip!');

INSERT INTO `circuits_trips_employees` (`employee_id`, `circuit_trip_id`, `description`)
VALUES (@idE2, @idCiT2, 'Hello, I will be your guide for this trip!');

/* for Inclusions */

INSERT INTO inclusions (`circuit_id`,
 `description`)
VALUES (
 @idCi1,
 'Trip between the Hawaiian Islands'
 ),
(
 @idCi2,
 'High-speed train between Venice and Florence; Florence and Rome in first class'
 ),
(
 @idCi2,
 'Guided walking tour of Rome with Vatican Museum and Sistine Chapel'
 );

/* for Exclusions */

INSERT INTO exclusions (`circuit_id`,
 `description`)
VALUES (
 @idCi1,
 'Flight/ return flight to/ from Hawaii'
 ),
(
 @idCi2,
 'Flight to Venice; return flight from Rome'
 );


/* for Steps */

INSERT INTO steps (`circuit_id`,
 `description`,
 `position`,
 `time_after_last_step`)
VALUES (
 @idCi1,
 'First step of Hawaii trip',
 '01',
 '00'
 ),
(
 @idCi1,
 'Second step of Hawaii trip',
 '02',
 '02'
 ),
(
 @idCi2,
 'First step of Italy trip',
 '01',
 '00'
 ),
(
 @idCi2,
 'Second step of Italy trip',
 '02',
 '02'
 ),
(
 @idCi2,
 'Third step of Italy trip',
 '03',
 '02'
 );

SELECT @idS1 := id FROM steps WHERE description = "First step of Hawaii trip";
SELECT @idS2 := id FROM steps WHERE description = "Second step of Hawaii trip";
SELECT @idS3 := id FROM steps WHERE description = "First step of Italy trip";
SELECT @idS4 := id FROM steps WHERE description = "Second step of Italy trip";
SELECT @idS5 := id FROM steps WHERE description = "Third step of Italy trip";


/* for Periods */

INSERT INTO periods (`step_id`, `time_after_step_start`)
VALUES (@idS1, '02'),
(@idS2, '03'),
(@idS3, '02'),
(@idS4, '02'),
(@idS5, '02');

SELECT @idP1 := id FROM periods WHERE step_id = @idS1;
SELECT @idP2 := id FROM periods WHERE step_id = @idS2;
SELECT @idP3 := id FROM periods WHERE step_id = @idS3;
SELECT @idP4 := id FROM periods WHERE step_id = @idS4;
SELECT @idP5 := id FROM periods WHERE step_id = @idS5;


/* Medias needed for accommodations */

INSERT INTO media (`name`,
 `media_type`,
 `description`,
 `path`,
 `header`)
VALUES (
 'Hawaii Resort',
 'image',
 'Volcano Resort',
 '/images/craterEdge.jpg',
 0
 ),
 (
 'Venice Hotel',
 'image',
 'image of a room in Hotel Continental Venice',
 '/images/hotelVenice.jpg',
 0
 );

SELECT @idM1 := id FROM media WHERE description = 'Volcano Resort';
SELECT @idM2 := id FROM media WHERE description = 'image of a room in Hotel Continental Venice';


/* Accommodations for Italy */

INSERT INTO addresses (`country`,
 `city`,
 `region`,
 `address_line_1`)
VALUES (
 'Italy',
 'Venezia',
 'VE',
 '166 Rio Terà Lista di Spagna'
 );

SELECT @id := id FROM addresses WHERE address_line_1 = '166 Rio Terà Lista di Spagna';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@id, '+39 041 715122');

INSERT INTO accommodations (`location_id`,
	`accommodation_type`,
	`link`,
	`rating`,
	`name`)
VALUES (
				LAST_INSERT_ID(),
				'HOTEL',
				'https://www.hotelcontinentalvenice.com/',
				'4',
				'Hotel Continental Venice'
				);

SELECT @id2 := id FROM locations WHERE phone_number = '+39 041 715122';
SELECT @id3 := id FROM accommodations WHERE name = 'Hotel Continental Venice';

INSERT INTO accommodations_locations (`accommodation_id`, `location_id`)
VALUES (@id3, @id2);

INSERT INTO accommodations_media (`accommodation_id`, `media_id`)
VALUES (@id3, @idM1);

INSERT INTO accommodations_periods (`period_id`, `accommodation_id`)
VALUES (@idP1, @id3);

INSERT INTO rooms (`accommodation_id`,
 `description`,
 `occupation`)
VALUES (
 @id3,
 'Sophisticated rooms come with free Wi-Fi and satellite TV, as well as minibars and coffeemakers. Some offer canal or street views. Room service is available.',
 '03');

INSERT INTO `circuits_trips_periods_rooms` (`circuit_trip_id`,
 `period_id`,
 `room_id`)
VALUES (
 @idCiT2,
 @idP3,
 LAST_INSERT_ID()
 );



INSERT INTO addresses (`country`,
 `city`,
 `region`,
 `address_line_1`)
VALUES (
 'Italy',
 'Venezia',
 'VE',
 '1848 Calle del Frutarol'
 );

SELECT @id := id FROM addresses WHERE address_line_1 = '1848 Calle del Frutarol';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@id, '+39 041 522 0947');

INSERT INTO accommodations (`location_id`,
	`accommodation_type`,
	`link`,
	`rating`,
	`name`)
VALUES (
				LAST_INSERT_ID(),
				'HOTEL',
				'https://www.hotelmercurio.com/',
				'3',
				'Hotel Mercurio Venice'
				);

SELECT @id2 := id FROM locations WHERE phone_number = '+39 041 522 0947';
SELECT @id3 := id FROM accommodations WHERE name = 'Hotel Mercurio Venice';

INSERT INTO accommodations_locations (`accommodation_id`, `location_id`)
VALUES (@id3, @id2);

INSERT INTO accommodations_periods (`period_id`, `accommodation_id`)
VALUES (@idP1, @id3);

INSERT INTO rooms (`accommodation_id`,
 `description`,
 `occupation`)
VALUES (
 @id3,
 'Rooms and Suites offer the experience of absolute comfort in a stylish environment and they come equipped with the most modern comforts.',
 '03'
 );

INSERT INTO `circuits_trips_periods_rooms` (`circuit_trip_id`,
 `period_id`,
 `room_id`)
VALUES (
 @idCiT2,
 @idP3,
 LAST_INSERT_ID()
 );



INSERT INTO addresses (`country`,
 `city`,
 `region`,
 `address_line_1`)
VALUES (
 'Italy',
 'Firenze',
 'FI',
 '3 Piazza Piave'
 );

SELECT @id := id FROM addresses WHERE address_line_1 = '3 Piazza Piave';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@id, '+39 055 243668');

INSERT INTO accommodations (`location_id`,
	`accommodation_type`,
	`link`,
	`rating`,
	`name`)
VALUES (
				LAST_INSERT_ID(),
				'HOTEL',
				'http://www.hhflorence.com/it/',
				'4',
				'Home Florence'
				);

SELECT @id2 := id FROM locations WHERE phone_number = '+39 055 243668';
SELECT @id3 := id FROM accommodations WHERE name = 'Home Florence';

INSERT INTO accommodations_locations (`accommodation_id`, `location_id`)
VALUES (@id3, @id2);

INSERT INTO accommodations_periods (`period_id`, `accommodation_id`)
VALUES (@idP2, @id3);

INSERT INTO rooms (`accommodation_id`,
 `description`,
 `occupation`)
VALUES (
 @id3,
 'The minimalist, modern rooms and suites come with free Wi-Fi, satellite TV and coffeemakers. Upgraded rooms feature canopy beds and private terraces; suites add iPod docks and dining areas. Room service is available.',
 '03'
 );

INSERT INTO `circuits_trips_periods_rooms` (`circuit_trip_id`,
 `period_id`,
 `room_id`)
VALUES (
 @idCiT2,
 @idP4,
 LAST_INSERT_ID()
 );



INSERT INTO addresses (`country`,
 `city`,
 `region`,
 `address_line_1`)
VALUES (
 'Italy',
 'Roma',
 'RM',
 '15 Via Cavour'
 );

SELECT @id := id FROM addresses WHERE address_line_1 = '15 Via Cavour';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@id, '+39 06 488 4051');

INSERT INTO accommodations (`location_id`,
	`accommodation_type`,
	`link`,
	`rating`,
	`name`)
VALUES (
				LAST_INSERT_ID(),
				'HOTEL',
				'https://www.bettojahotels.it/en',
				'4',
				'Bettoha Hotels Collection'
				);

SELECT @id2 := id FROM locations WHERE phone_number = '+39 06 488 4051';
SELECT @id3 := id FROM accommodations WHERE name = 'Bettoha Hotels Collection';

INSERT INTO accommodations_locations (`accommodation_id`, `location_id`)
VALUES (@id3, @id2);

INSERT INTO accommodations_periods (`period_id`, `accommodation_id`)
VALUES (@idP2, @id3);

INSERT INTO rooms (`accommodation_id`,
 `description`,
 `occupation`)
VALUES (
 @id3,
 'Otherwise indicated, guests will stay in our Standard Rooms.',
 '03'
 );

INSERT INTO `circuits_trips_periods_rooms` (`circuit_trip_id`,
 `period_id`,
 `room_id`)
VALUES (
 @idCiT2,
 @idP5,
 LAST_INSERT_ID()
 );


/* Accommodations for Hawaii */

INSERT INTO addresses (`country`,
 `city`,
 `region`,
 `address_line_1`)
VALUES (
 'United States',
 'Honolulu',
 'HI',
 '2556 Lemon Rd B101'
 );

SELECT @id := id FROM addresses WHERE address_line_1 = '2556 Lemon Rd B101';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@id, '+1 808 923 9566');

INSERT INTO accommodations (`location_id`,
	`accommodation_type`,
	`link`,
	`rating`,
	`name`)
VALUES (
				LAST_INSERT_ID(),
				'HOUSE',
				'http://visitthevolcano.com/aloha-welcome-craters-edge-luxury-lodging-near-volcanoes-national-park/',
				'5',
				'At the crater’s edge'
				);

SELECT @id2 := id FROM locations WHERE phone_number = '+1 808 923 9566';
SELECT @id3 := id FROM accommodations WHERE name = 'At the crater’s edge';

INSERT INTO accommodations_locations (`accommodation_id`, `location_id`)
VALUES (@id3, @id2);

INSERT INTO accommodations_media (`accommodation_id`, `media_id`)
VALUES (@id3, @idM2);

INSERT INTO accommodations_periods (`period_id`, `accommodation_id`)
VALUES (@idP3, @id3);

INSERT INTO rooms (`accommodation_id`,
 `description`,
 `occupation`)
VALUES (
 @id3,
 'All rooms include private bathrooms, fridge and microwave. In-room kitchens based on request and availability.',
 '04'
 );

INSERT INTO `circuits_trips_periods_rooms` (`circuit_trip_id`,
 `period_id`,
 `room_id`)
VALUES (
 @idCiT1,
 @idP1,
 LAST_INSERT_ID()
 );



INSERT INTO addresses (`country`,
 `city`,
 `region`,
 `address_line_1`)
VALUES (
 'United States',
 'Honolulu',
 'HI',
 '2058 Kuhio Ave'
 );

SELECT @id := id FROM addresses WHERE address_line_1 = '2058 Kuhio Ave';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@id, '+1 808-947-2828');

INSERT INTO accommodations (`location_id`,
	`accommodation_type`,
	`link`,
	`rating`,
	`name`)
VALUES (
				LAST_INSERT_ID(),
				'CONDO',
				'https://gingerhillfarm.com/',
				'3',
				'Gingerhill Farm Retreat'
				);

SELECT @id2 := id FROM locations WHERE phone_number = '+1 808-947-2828';
SELECT @id3 := id FROM accommodations WHERE name = 'Gingerhill Farm Retreat';

INSERT INTO accommodations_locations (`accommodation_id`, `location_id`)
VALUES (@id3, @id2);

INSERT INTO accommodations_periods (`period_id`, `accommodation_id`)
VALUES (@idP3, @id3);

INSERT INTO rooms (`accommodation_id`,
 `description`,
 `occupation`)
VALUES (
 @id3,
 'Enjoy our brand new guest rooms with modern amenities including complimentary WiFi internet access and a 49” HDTV. All rooms have compact refrigerator, microwave and Keurig with coffee and tea pods replenished daily.',
 '03'
 );

INSERT INTO `circuits_trips_periods_rooms` (`circuit_trip_id`,
 `period_id`,
 `room_id`)
VALUES (
 @idCiT1,
 @idP1,
 LAST_INSERT_ID()
 );



INSERT INTO addresses (`country`,
 `city`,
 `region`,
 `address_line_1`)
VALUES (
 'United States',
 'Kealakekua',
 'HI',
 '81-6467 Mamalahoa Hwy'
 );

SELECT @id := id FROM addresses WHERE address_line_1 = '81-6467 Mamalahoa Hwy';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@id, '+1 808-427-9972');

INSERT INTO accommodations (`location_id`,
	`accommodation_type`,
	`link`,
	`rating`,
	`name`)
VALUES (
				LAST_INSERT_ID(),
				'HOTEL',
				'https://www.waikikibeachsidehostel.com/',
				'3',
				'Waikiki Beachside Hostel'
				);

SELECT @id2 := id FROM locations WHERE phone_number = '+1 808-427-9972';
SELECT @id3 := id FROM accommodations WHERE name = 'Waikiki Beachside Hostel';

INSERT INTO accommodations_locations (`accommodation_id`, `location_id`)
VALUES (@id3, @id2);

INSERT INTO accommodations_periods (`period_id`, `accommodation_id`)
VALUES (@idP4, @id3);

INSERT INTO rooms (`accommodation_id`,
 `description`,
 `occupation`)
VALUES (
 @id3,
 'Gingerhill’s elegant vacation rentals effortlessly fuse luxury and simplicity to serve as your captivating home away from home.',
 '06'
 );

INSERT INTO `circuits_trips_periods_rooms` (`circuit_trip_id`,
 `period_id`,
 `room_id`)
VALUES (
 @idCiT1,
 @idP2,
 LAST_INSERT_ID()
 );



INSERT INTO addresses (`country`,
 `city`,
 `region`,
 `address_line_1`)
VALUES (
 'United States',
 'Volcano',
 'HI',
 '11-3802 12th St'
 );

SELECT @id := id FROM addresses WHERE address_line_1 = '11-3802 12th St';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@id, '+1 206-890-9881');

INSERT INTO accommodations (`location_id`,
	`accommodation_type`,
	`link`,
	`rating`,
	`name`)
VALUES (
				LAST_INSERT_ID(),
				'HOTEL',
				'https://www.hiexpress.com/hotels/us/en/honolulu/hnlka/hoteldetail?fromRedirect=true&qSrt=sBR&qIta=99504425&icdv=99504425&glat=SEAR&qSlH=HNLKA&setPMCookies=true&qSHBrC=EX&qDest=2058%20Kuhio%20Avenue,%20Honolulu,%20HI,%20US&dp=true&gclid=Cj0KCQiArdLvBRCrARIsAGhB_sx5JHFZ7A88LAs2d1zAq3cUIuZyttT3Mk_A3ut7dFLjozeIPaVB9QYaAnoFEALw_wcB&cid=55660&srb_u=1',
				'4',
				'Holiday Inn Express Waikiki'
				);

SELECT @id2 := id FROM locations WHERE phone_number = '+1 206-890-9881';
SELECT @id3 := id FROM accommodations WHERE name = 'Holiday Inn Express Waikiki';

INSERT INTO accommodations_locations (`accommodation_id`, `location_id`)
VALUES (@id3, @id2);

INSERT INTO accommodations_periods (`period_id`, `accommodation_id`)
VALUES (@idP5, @id3);

INSERT INTO rooms (`accommodation_id`,
 `description`,
 `occupation`)
VALUES (
 @id3,
 'Our luxury vacation rentals in Hawaii celebrate the island’s natural beauty.',
 '02'
 );

INSERT INTO `circuits_trips_periods_rooms` (`circuit_trip_id`,
 `period_id`,
 `room_id`)
VALUES (
 @idCiT1,
 @idP2,
 LAST_INSERT_ID()
 );


/* Medias needed for activities */

INSERT INTO media (`name`,
 `media_type`,
 `description`,
 `path`,
 `header`)
VALUES (
 'War Plane',
 'image',
 'Image of a war plane',
 '/images/phAviation.jpg',
 0
 ),
(
 'D.K Steak',
 'image',
 'T-Bone Steak',
 '/images/dkSteak.jpg',
 0
 ),
(
 'Gondola',
 'image',
 'Gondola on the water in Venice',
 '/images/gondola.jpg',
 0
 ),
(
 'Tower of Pisa',
 'image',
 'Tower of pisa in Italy',
 '/images/pisaTower.jpg',
 0
 ),
(
 'Coliseum',
 'image',
 'Picture of the coliseum at night',
 '/images/coliseum.jpg',
 0
 );


SELECT @idM1 := id FROM media WHERE description = 'Image of a war plane';
SELECT @idM2 := id FROM media WHERE description = 'T-Bone Steak';
SELECT @idM3 := id FROM media WHERE description = 'Gondola on the water in Venice';
SELECT @idM4 := id FROM media WHERE description = 'Tower of pisa in Italy';
SELECT @idM5 := id FROM media WHERE description = 'Picture of the coliseum at night';


/* For restaurants (Italy) */

INSERT INTO addresses (`country`,
 `city`,
 `region`,
 `address_line_1`)
VALUES (
 'Italy',
 'Venezia',
 'VE',
 '943-944 Dorsoduro'
 );

SELECT @id := id FROM addresses WHERE address_line_1 = '943-944 Dorsoduro';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@id, '+39 335 600 7513');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'RESTAURANTS',
 'https://osteriaalsquero.wordpress.com/',
 'Excellent local food',
 'Osteria Al Squero'
 );

SELECT @id2 := id FROM locations WHERE phone_number = '+39 335 600 7513';
SELECT @id3 := id FROM activities WHERE name = 'Osteria Al Squero';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@id3, @id2);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @id3,
 @idS3,
 '00',
 '02'
 );



 INSERT INTO addresses (`country`,
 `city`,
 `region`,
 `address_line_1`)
VALUES (
 'Italy',
 'Firenze',
 'FI',
 '3 Via dei Benci'
 );

SELECT @id := id FROM addresses WHERE address_line_1 = '3 Via dei Benci';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@id, '+39 055 217833');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'RESTAURANTS',
 'https://www.labuchetta.com/',
 'Local cuisine, Steakhouse, Italian, Mediterranean, European, Wine Bar',
 'La Buchetta Food & Wine Restaurant'
 );

SELECT @id2 := id FROM locations WHERE phone_number = '+39 055 217833';
SELECT @id3 := id FROM activities WHERE name = 'La Buchetta Food & Wine Restaurant';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@id3, @id2);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @id3,
 @idS4,
 '02',
 '02'
 );



  INSERT INTO addresses (`country`,
 `city`,
 `region`,
 `address_line_1`)
VALUES (
 'Italy',
 'Roma',
 'RM',
 'Box 22, Nuovo Mercato di Testaccio Via Aldo Manunzio, snc'
 );

SELECT @id := id FROM addresses WHERE address_line_1 = 'Box 22, Nuovo Mercato di Testaccio Via Aldo Manunzio, snc';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@id, '+39 338 702 6829');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'RESTAURANTS',
 'https://casamanco.it/',
 'Excellent authentic italian pizzas',
 'Casa Manco'
 );

SELECT @id2 := id FROM locations WHERE phone_number = '+39 338 702 6829';
SELECT @id3 := id FROM activities WHERE name = 'Casa Manco';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@id3, @id2);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @id3,
 @idS5,
 '02',
 '02'
 );


/* For restaurants (Hawaii) */

 INSERT INTO addresses (`country`,
 `city`,
 `region`,
 `address_line_1`)
VALUES (
 'United States',
 'Honolulu',
 'HI',
 '2556 Lemon Rd'
 );

SELECT @id := id FROM addresses WHERE address_line_1 = '2556 Lemon Rd';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@id, '1-800-760-7718');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'RESTAURANTS',
 'https://www.waikikibeachsidehostel.com/',
 'American style of cuisine',
 'Waikiki Beachside Kitchen'
 );

SELECT @id2 := id FROM locations WHERE phone_number = '1-800-760-7718';
SELECT @id3 := id FROM activities WHERE name = 'Waikiki Beachside Kitchen';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@id3, @id2);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @id3,
 @idS1,
 '00',
 '01'
 );



 INSERT INTO addresses (`country`,
 `city`,
 `region`,
 `address_line_1`)
VALUES (
 'United States',
 'Honolulu',
 'HI',
 '2552 Kalakaua Ave'
 );

SELECT @id := id FROM addresses WHERE address_line_1 = '2552 Kalakaua Ave';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@id, '+1 808-922-6611');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'RESTAURANTS',
 'https://www.marriotthawaii.com/restaurants/d-k-steak-house/',
 'Steakhouse type of cuisine',
 'D.K. Steakhouse'
 );

SELECT @id2 := id FROM locations WHERE phone_number = '+1 808-922-6611';
SELECT @id3 := id FROM activities WHERE name = 'D.K. Steakhouse';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@id3, @id2);

INSERT INTO activities_media (`activity_id`, `media_id`)
VALUES (@id3, @idM2);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @id3,
 @idS1,
 '01',
 '01'
 );



 INSERT INTO addresses (`country`,
 `city`,
 `region`,
 `address_line_1`)
VALUES (
 'United States',
 'Hawaii Volcanoes National Park',
 'HI',
 '1 Crater Rim Drive'
 );

SELECT @id := id FROM addresses WHERE address_line_1 = '1 Crater Rim Drive';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@id, '(844) 569-8849');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'RESTAURANTS',
 'https://www.hawaiivolcanohouse.com/dining',
 'Hawaiian/ American type of cuisine',
 'Volcano House'
 );

SELECT @id2 := id FROM locations WHERE phone_number = '(844) 569-8849';
SELECT @id3 := id FROM activities WHERE name = 'Volcano House';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@id3, @id2);

 INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @id3,
 @idS2,
 '02',
 '02'
 );



 INSERT INTO addresses (`country`,
 `city`,
 `region`,
 `address_line_1`)
VALUES (
 'United States',
 'Volcano',
 'HI',
 '19-3948 Old Volcano Rd'
 );

SELECT @id := id FROM addresses WHERE address_line_1 = '19-3948 Old Volcano Rd';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@id, '+1 808-967-7366');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'RESTAURANTS',
 'https://highwaywestvacations.com/properties/kilauea-lodge?utm_source=tripadvisor&utm_medium=referral',
 'Seafood, International cuisine',
 'Kilauea Lodge Restaurant'
 );

SELECT @id2 := id FROM locations WHERE phone_number = '+1 808-967-7366';
SELECT @id3 := id FROM activities WHERE name = 'Kilauea Lodge Restaurant';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@id3, @id2);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @id3,
 @idS2,
 '01',
 '01'
 );


/* For other activities (Italy) */

 INSERT INTO addresses (`country`,
 `city`,
 `region`,
 `address_line_1`)
VALUES (
 'Italy',
 'Venezia',
 'VE',
 'Unnamed Road'
 );

SELECT @id := id FROM addresses WHERE address_line_1 = 'Unnamed Road';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@id, '+39 041 528 5075');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'RELAXING',
 'https://www.gondola-rides-venice.com/',
 'Enjoy a nice relaxing gondola ride around Venice',
 'Gondola Rides'
 );

SELECT @id2 := id FROM locations WHERE phone_number = '+39 041 528 5075';
SELECT @id3 := id FROM activities WHERE name = 'Gondola Rides';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@id3, @id2);

INSERT INTO activities_media (`activity_id`, `media_id`)
VALUES (@id3, @idM3);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @id3,
 @idS3,
 '00',
 '02'
 );



 INSERT INTO addresses (`country`,
 `city`,
 `region`,
 `address_line_1`)
VALUES (
 'Italy',
 'Pisa',
 'PI',
 'Piazza del Duomo'
 );

SELECT @id := id FROM addresses WHERE address_line_1 = 'Piazza del Duomo';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@id, '+39 050 835011');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'DISCOVERY',
 'http://www.towerofpisa.org/visit-tower-of-pisa/',
 'Visit Pisa, known for its famous Leaning Tower',
 'Explore Pisa'
 );

SELECT @id2 := id FROM locations WHERE phone_number = '+39 050 835011';
SELECT @id3 := id FROM activities WHERE name = 'Explore Pisa';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@id3, @id2);

INSERT INTO activities_media (`activity_id`, `media_id`)
VALUES (@id3, @idM4);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @id3,
 @idS4,
 '02',
 '02'
 );



 INSERT INTO addresses (`country`,
 `city`,
 `region`,
 `address_line_1`)
VALUES (
 'Italy',
 'Florence',
 'FI',
 '30 Vico'
 );

SELECT @id := id FROM addresses WHERE address_line_1 = '30 Vico';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@id, '+39 055 294883');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'DISCOVERY',
 'https://www.visitflorence.com/',
 'Spend the day at leisure in Florence',
 'Explore Florence'
 );

SELECT @id2 := id FROM locations WHERE phone_number = '+39 055 294883';
SELECT @id3 := id FROM activities WHERE name = 'Explore Florence';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@id3, @id2);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @id3,
 @idS5,
 '02',
 '02'
 );



 INSERT INTO addresses (`country`,
 `city`,
 `region`,
 `address_line_1`)
VALUES (
 'Italy',
 'Roma',
 'RM',
 '1 Piazza del Colosseo'
 );

SELECT @id := id FROM addresses WHERE address_line_1 = '1 Piazza del Colosseo';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@id, '+39 06 3996 7700');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'DISCOVERY',
 'https://www.il-colosseo.it/en/informazioni-colosseo.php?',
 'Spend the day in Rome and visit the coliseum',
 'Explore Rome'
 );

 SELECT @id2 := id FROM locations WHERE phone_number = '+39 06 3996 7700';
 SELECT @id3 := id FROM activities WHERE name = 'Explore Rome';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@id3, @id2);

INSERT INTO activities_media (`activity_id`, `media_id`)
VALUES (@id3, @idM5);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @id3,
 @idS1,
 '00',
 '01'
 );


/* For other activities (Hawaii) */

 INSERT INTO addresses (`country`,
 `city`,
 `region`,
 `address_line_1`)
VALUES (
 'United States',
 'Honolulu',
 'HI',
 '319 Lexington Blvd'
 );

SELECT @id := id FROM addresses WHERE address_line_1 = '319 Lexington Blvd';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@id, '(808) 441-1000');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'OTHER',
 'https://www.pearlharboraviationmuseum.org/',
 'Aviation museum relating the attack on Pearl Harbor and the 2nd World War',
 'Pearl Harbor Museum'
 );

SELECT @id2 := id FROM locations WHERE phone_number = '(808) 441-1000';
SELECT @id3 := id FROM activities WHERE name = 'Pearl Harbor Museum';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@id3, @id2);

INSERT INTO activities_media (`activity_id`, `media_id`)
VALUES (@id3, @idM1);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @id3,
 @idS1,
 '01',
 '00'
 );



 INSERT INTO addresses (`country`,
 `city`,
 `region`,
 `address_line_1`)
VALUES (
 'United States',
 'Honolulu',
 'HI',
 '2863 Kalakaua Ave'
 );

SELECT @id := id FROM addresses WHERE address_line_1 = '2863 Kalakaua Ave';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@id, '+1 808-923-1555');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'RELAXING',
 'https://www.gohawaii.com/islands/oahu/things-to-do/beaches/sans-souci-kaimana-beach-park',
 'Ideal family beach where you can kayak, snorkel or just swim in peace',
 'Sans souci beach'
 );

SELECT @id2 := id FROM locations WHERE phone_number = '+1 808-923-1555';
SELECT @id3 := id FROM activities WHERE name = 'Sans souci beach';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@id3, @id2);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @id3,
 @idS1,
 '01',
 '01'
 );



 INSERT INTO addresses (`country`,
 `city`,
 `region`,
 `address_line_1`)
VALUES (
 'United States',
 'Captain Cook',
 'HI',
 '82-6199 Mamalahoa Hwy'
 );

SELECT @id := id FROM addresses WHERE address_line_1 = '82-6199 Mamalahoa Hwy';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@id, '+1 808-323-3222');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'OTHER',
 'https://konahistorical.org/kona-coffee-living-history-farm',
 'Historic farm where you can learn more about coffee production',
 'Kona Coffee Living History Farm'
 );

SELECT @id2 := id FROM locations WHERE phone_number = '+1 808-323-3222';
SELECT @id3 := id FROM activities WHERE name = 'Kona Coffee Living History Farm';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@id3, @id2);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @id3,
 @idS2,
 '01',
 '01'
 );



 INSERT INTO addresses (`country`,
 `city`,
 `region`,
 `address_line_1`)
VALUES (
 'United States',
 'Volcano',
 'HI',
 '11-3802 12th St'
 );

SELECT @id := id FROM addresses WHERE address_line_1 = '11-3802 12th St';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@id, '+1 206-890-9881');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'DISCOVERY',
 'http://visitthevolcano.com/adventures/',
 'Mountain hike to admire the volcanoes of the island of Hawaii',
 'Kilauea Volcano'
 );

SELECT @id2 := id FROM locations WHERE phone_number = '+1 206-890-9881';
SELECT @id3 := id FROM activities WHERE name = 'Kilauea Volcano';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@id3, @id2);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @id3,
 @idS2,
 '01',
 '01'
 );



 INSERT INTO addresses (`country`,
 `city`,
 `region`,
 `address_line_1`)
VALUES (
 'United States',
 'Volcano',
 'HI',
 '35 Piimauna Dr, Volcano'
 );

SELECT @id := id FROM addresses WHERE address_line_1 = '35 Piimauna Dr, Volcano';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@id, '+1 808-967-7772');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'OTHER',
 'https://volcanowinery.com/',
 'Vineyard where you can taste authentic Hawaiian wines inspired by the fruits of the islands',
 'Volcano Winery'
 );

SELECT @id2 := id FROM locations WHERE phone_number = '+1 808-967-7772';
SELECT @id3 := id FROM activities WHERE name = 'Volcano Winery';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@id3, @id2);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @id3,
 @idS2,
 '01',
 '01'
 );

 /* FROM promotions .sql file */

 INSERT INTO promotions_types (name, is_percentage_based, is_gift_based, is_exclusive, group_discount_travelers_count) VALUES
 ('Rabais en dollars', 0, 0, 0, 0),
 ('Rabais en dollars avec code', 0, 0, 1, 0),
 ('Rabais en pourcentage', 1, 0, 0, 0),
 ('Rabais en pourcentage avec code', 1, 0, 1, 0),
 ('Cadeau gratuit', 0, 1, 0, 0),
 ('Cadeau gratuit avec code', 0, 1, 0, 0),
 ('Rabais en dollars pour couple', 0, 0, 0, 2),
 ('Rabais en dollars avec code pour couple', 0, 0, 1, 2),
 ('Rabais en pourcentage pour couple', 1, 0, 0, 2),
 ('Rabais en pourcentage avec code pour couple', 1, 0, 1, 2),
 ('Cadeau gratuit pour couple', 0, 1, 0, 2),
 ('Cadeau gratuit avec code pour couple', 0, 1, 0, 2),
 ('Rabais en dollars pour famille', 0, 0, 0, 4),
 ('Rabais en dollars avec code pour famille', 0, 0, 1, 4),
 ('Rabais en pourcentage pour famille', 1, 0, 0, 4),
 ('Rabais en pourcentage avec code pour famille', 1, 0, 1, 4),
 ('Cadeau gratuit pour famille', 0, 1, 0, 4),
 ('Cadeau gratuit avec code pour famille', 0, 1, 0, 4),
 ('Rabais en dollars pour groupe de 10', 0, 0, 0, 10),
 ('Rabais en dollars avec code pour groupe de 10', 0, 0, 1, 10),
 ('Rabais en pourcentage pour groupe de 10', 1, 0, 0, 10),
 ('Rabais en pourcentage avec code pour groupe de 10', 1, 0, 1, 10),
 ('Cadeau gratuit pour groupe de 10', 0, 1, 0, 10),
 ('Cadeau gratuit avec code pour groupe de 10', 0, 1, 0, 10);

COMMIT;
