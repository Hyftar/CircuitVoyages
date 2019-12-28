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

SELECT @idAd1 := id FROM addresses WHERE address_line_1 = '9235 Avenue Papineau';

INSERT INTO languages(name)
VALUES ('FRENCH'), ('ENGLISH'), ('SPANISH');

SELECT @idL1 := id FROM languages WHERE name = 'FRENCH';

INSERT INTO passwords(password_salt, password_hash) /* Password Didier1! */
VALUES ('a6248e718af667b63dc6c623e5b7dd04f62136ba445835f8168bc60e0f20607c', '4ef2bd4439611de653e7a4a710c21974d42631c30bceac53332da40485253754');


INSERT INTO members(
 email,
 password_id,
 address_id,
 language_id,
 first_name,
 last_name,
 phone_number,
 date_of_birth)
VALUES (
 'membre1@exemple.com',
 LAST_INSERT_ID(),
 @idAd1,
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
 'image/png',
 'Image de notre guide',
 '/uploaded_files/guide.png',
 0
 ),
(
 'Guide2',
 'image/jpeg',
 'Image de notre guide',
 '/uploaded_files/guideB.jpg',
 0
 );

SELECT @idM1 := id FROM media WHERE name = 'Guide1';
SELECT @idM2 := id FROM media WHERE name = 'Guide2';


INSERT INTO `permissions` (`feature`)
VALUES ('Employé régulier'), ('Admin');

SELECT @idPerm1 := id FROM permissions WHERE feature = 'Employé régulier';


INSERT INTO `roles` (`name`)
VALUES ('Guide'), ('Admin');

SELECT @idR1 := id FROM roles WHERE name = 'Guide';


/* First guide */

INSERT INTO passwords(password_salt, password_hash) /* password from first seed file */
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

INSERT INTO passwords(password_salt, password_hash) /* Password Bidier2! */
VALUES ('3f866183985690b726e4e0c8767fbf1527bc68a063d4d1d893f139fe86205c52', '5a54ea6545bdfdc5db40bc12ecc58c19e0c631ef19b4c54e231987b57b6d542b');

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
 'image/jpeg',
 'Couché de soleil à Hawaii',
 '/uploaded_files/hawaiiHeader.jpg',
 1
 ),
(
 'Italy Header',
 'image/jpeg',
 'Paysage d\'Italie',
 '/uploaded_files/Italy.jpg',
 1
 );

SELECT @idM1 := id FROM media WHERE description = 'Couché de soleil à Hawaii';
SELECT @idM2 := id FROM media WHERE description = 'Paysage d\'Italie';


/* Languages needed for circuits */

INSERT INTO languages(name)
VALUES ('FRENCH'), ('ENGLISH'), ('SPANISH');

SELECT @idL1 := id FROM languages WHERE name = 'FRENCH';


/* Categories needed for circuits */

INSERT INTO categories (name, description)
VALUES
('Les grands lieux d\'histoire','Visitez les lieux des plus importants moments de l\'histoire. Marchez dans les pas des plus grands.'),
('Les plus beaux paysages', 'Voyez la nature comme jamais. Explorez les plus grandes beautés du monde.');

SELECT @idC1 := id FROM categories WHERE name = 'Les grands lieux d\'histoire';
SELECT @idC2 := id FROM categories WHERE name = 'Les plus beaux paysages';


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
 'Découvrez les îles hawaïennes',
 'Découvrez les magnifiques îles d\'Hawaï en participant à une multitude d\'activités. Admirez la culture, l\'histoire et la cuisine locale et laissez-vous surprendre par les paysages inoubliables.',
 1
 ),
(
 @idM1,
 @idL1,
 @idC1,
 'Vivez le style de vie Italien',
 'Vivez l\'expérience italienne authentique en explorant des sites historiques, en profitant de belles balades en gondole relaxantes et en mangeant dans d\'incroyables restaurants locaux.',
 1
 );

SELECT @idCi1 := id FROM circuits WHERE name = 'Découvrez les îles hawaïennes';
SELECT @idCi2 := id FROM circuits WHERE name = 'Vivez le style de vie Italien';


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

SELECT @idM1 := id FROM members WHERE email = 'membre1@exemple.com';

SELECT @idCiT1 := id FROM circuits_trips WHERE circuit_id = @idCi1;
SELECT @idCiT2 := id FROM circuits_trips WHERE circuit_id = @idCi2;


/* for Trips */

 INSERT INTO trips (`member_id`,
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
VALUES (@idE1, @idCiT1, 'Bonjour, je serai votre guide pour ce voyage!');

INSERT INTO `circuits_trips_employees` (`employee_id`, `circuit_trip_id`, `description`)
VALUES (@idE2, @idCiT2, 'Bonjour, je serai votre guide pour ce voyage!');


/* for Inclusions */

INSERT INTO inclusions (`circuit_id`,
 `description`)
VALUES (
 @idCi1,
 'Voyage entre les îles hawaïennes'
 ),
(
 @idCi2,
 'Train à grande vitesse entre Venise et Florence; Florence et Rome en première classe'
 ),
(
 @idCi2,
 'Visite guidée à pied de Rome qui comprend le musée du Vatican et la chapelle Sixtine'
 );


/* for Exclusions */

INSERT INTO exclusions (`circuit_id`,
 `description`)
VALUES (
 @idCi1,
 'Vol / vol de retour vers / de Hawaï'
 ),
(
 @idCi2,
 'Vol pour Venise; vol de retour de Rome'
 );


/* for Steps */

INSERT INTO steps (`circuit_id`,
 `description`,
 `position`,
 `time_after_last_step`)
VALUES (
 @idCi1,
 'Première étape du voyage à Hawaï',
 '01',
 '00'
 ),
(
 @idCi1,
 'Deuxième étape du voyage à Hawaï',
 '02',
 '2880'
 ),
(
 @idCi2,
 'Première étape du voyage en Italie',
 '01',
 '00'
 ),
(
 @idCi2,
 'Deuxième étape du voyage en Italie',
 '02',
 '2880'
 ),
(
 @idCi2,
 'Troisième étape du voyage en Italie',
 '03',
 '2880'
 );

SELECT @idS1 := id FROM steps WHERE description = 'Première étape du voyage à Hawaï';
SELECT @idS2 := id FROM steps WHERE description = 'Deuxième étape du voyage à Hawaï';
SELECT @idS3 := id FROM steps WHERE description = 'Première étape du voyage en Italie';
SELECT @idS4 := id FROM steps WHERE description = 'Deuxième étape du voyage en Italie';
SELECT @idS5 := id FROM steps WHERE description = 'Troisième étape du voyage en Italie';


/* for Periods */

INSERT INTO periods (`step_id`, `time_after_step_start`)
VALUES (@idS1, '480'),
(@idS2, '3360'),
(@idS3, '480'),
(@idS4, '3360'),
(@idS5, '6240');

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
 'image/jpeg',
 'Complexe touristique près d\'un volcan',
 '/uploaded_files/craterEdge.jpg',
 0
 ),
 (
 'Venice Hotel',
 'image/jpeg',
 'image d\'une chambre de l\'hôtel Continental Venice',
 '/uploaded_files/hotelVenice.jpg',
 0
 );

SELECT @idM1 := id FROM media WHERE description = 'Complexe touristique près d\'un volcan';
SELECT @idM2 := id FROM media WHERE description = 'image d\'une chambre de l\'hôtel Continental Venice';


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

SELECT @idA1 := id FROM addresses WHERE address_line_1 = '166 Rio Terà Lista di Spagna';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@idA1, '+39 041 715122');

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

SELECT @idLo1 := id FROM locations WHERE phone_number = '+39 041 715122';
SELECT @idAc1 := id FROM accommodations WHERE name = 'Hotel Continental Venice';

INSERT INTO accommodations_locations (`accommodation_id`, `location_id`)
VALUES (@idAc1, @idLo1);

INSERT INTO accommodations_media (`accommodation_id`, `media_id`)
VALUES (@idAc1, @idM1);

INSERT INTO accommodations_periods (`period_id`, `accommodation_id`)
VALUES (@idP1, @idAc1);

INSERT INTO rooms (`accommodation_id`,
 `description`,
 `occupation`)
VALUES (
 @idAc1,
 'Les chambres sophistiquées sont équipées du Wi-Fi gratuit et de la télévision par satellite ainsi que d\'un minibar et d\'une cafetière. Certains offrent une vue sur le canal ou la rue. Un service en chambre est disponible.',
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

SELECT @idA1 := id FROM addresses WHERE address_line_1 = '1848 Calle del Frutarol';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@idA1, '+39 041 522 0947');

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

SELECT @idLo1 := id FROM locations WHERE phone_number = '+39 041 522 0947';
SELECT @idAc1 := id FROM accommodations WHERE name = 'Hotel Mercurio Venice';

INSERT INTO accommodations_locations (`accommodation_id`, `location_id`)
VALUES (@idAc1, @idLo1);

INSERT INTO accommodations_periods (`period_id`, `accommodation_id`)
VALUES (@idP1, @idAc1);

INSERT INTO rooms (`accommodation_id`,
 `description`,
 `occupation`)
VALUES (
 @idAc1,
 'Les chambres et les suites offrent l\'expérience d\'un confort absolu dans un environnement élégant et sont équipées du confort le plus moderne.',
 '03'
 );

INSERT INTO `circuits_trips_periods_rooms` (`circuit_trip_id`,
 `period_id`,
 `room_id`)
VALUES (
 @idCiT2,
 @idAc1,
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

SELECT @idA1 := id FROM addresses WHERE address_line_1 = '3 Piazza Piave';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@idA1, '+39 055 243668');

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

SELECT @idLo1 := id FROM locations WHERE phone_number = '+39 055 243668';
SELECT @idAc1 := id FROM accommodations WHERE name = 'Home Florence';

INSERT INTO accommodations_locations (`accommodation_id`, `location_id`)
VALUES (@idAc1, @idLo1);

INSERT INTO accommodations_periods (`period_id`, `accommodation_id`)
VALUES (@idP2, @idAc1);

INSERT INTO rooms (`accommodation_id`,
 `description`,
 `occupation`)
VALUES (
 @idAc1,
 'Les chambres et suites minimalistes et modernes sont équipées du Wi-Fi gratuit, de la télévision par satellite et d\'une cafetière. Les chambres de catégorie supérieure disposent de lits à baldaquin et de terrasses privées; les suites sont dotées de stations d\'accueil pour iPod et de coins repas. Un service en chambre est disponible.',
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

SELECT @idA1 := id FROM addresses WHERE address_line_1 = '15 Via Cavour';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@idA1, '+39 06 488 4051');

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

SELECT @idLo1 := id FROM locations WHERE phone_number = '+39 06 488 4051';
SELECT @idAc1 := id FROM accommodations WHERE name = 'Bettoha Hotels Collection';

INSERT INTO accommodations_locations (`accommodation_id`, `location_id`)
VALUES (@idAc1, @idLo1);

INSERT INTO accommodations_periods (`period_id`, `accommodation_id`)
VALUES (@idP2, @idAc1);

INSERT INTO rooms (`accommodation_id`,
 `description`,
 `occupation`)
VALUES (
 @idAc1,
 'À moins d\'être indiqué autrement, les clients séjourneront dans nos chambres standard.',
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

SELECT @idA1 := id FROM addresses WHERE address_line_1 = '2556 Lemon Rd B101';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@idA1, '+1 808 923 9566');

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

SELECT @idLo1 := id FROM locations WHERE phone_number = '+1 808 923 9566';
SELECT @idAc1 := id FROM accommodations WHERE name = 'At the crater’s edge';

INSERT INTO accommodations_locations (`accommodation_id`, `location_id`)
VALUES (@idAc1, @idLo1);

INSERT INTO accommodations_media (`accommodation_id`, `media_id`)
VALUES (@idAc1, @idM2);

INSERT INTO accommodations_periods (`period_id`, `accommodation_id`)
VALUES (@idP3, @idAc1);

INSERT INTO rooms (`accommodation_id`,
 `description`,
 `occupation`)
VALUES (
 @idAc1,
 'Toutes les chambres comprennent une salle de bains privée, un réfrigérateur et un four micro-ondes. Cuisine en chambre selon demande et disponibilité.',
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

SELECT @idA1 := id FROM addresses WHERE address_line_1 = '2058 Kuhio Ave';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@idA1, '+1 808-947-2828');

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

SELECT @idLo1 := id FROM locations WHERE phone_number = '+1 808-947-2828';
SELECT @idAc1 := id FROM accommodations WHERE name = 'Gingerhill Farm Retreat';

INSERT INTO accommodations_locations (`accommodation_id`, `location_id`)
VALUES (@idAc1, @idLo1);

INSERT INTO accommodations_periods (`period_id`, `accommodation_id`)
VALUES (@idP3, @idAc1);

INSERT INTO rooms (`accommodation_id`,
 `description`,
 `occupation`)
VALUES (
 @idAc1,
 'Profitez de nos chambres flambant neuves dotées d\'équipements modernes, dont une connexion Wi-Fi gratuite et un téléviseur HD 49 pouces. Toutes les chambres disposent d\'un réfrigérateur compact, d\'un four micro-ondes et d\'un Keurig avec des dosettes de café et de thé réapprovisionnées quotidiennement.',
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

SELECT @idA1 := id FROM addresses WHERE address_line_1 = '81-6467 Mamalahoa Hwy';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@idA1, '+1 808-427-9972');

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

SELECT @idLo1 := id FROM locations WHERE phone_number = '+1 808-427-9972';
SELECT @idAc1 := id FROM accommodations WHERE name = 'Waikiki Beachside Hostel';

INSERT INTO accommodations_locations (`accommodation_id`, `location_id`)
VALUES (@idAc1, @idLo1);

INSERT INTO accommodations_periods (`period_id`, `accommodation_id`)
VALUES (@idP4, @idAc1);

INSERT INTO rooms (`accommodation_id`,
 `description`,
 `occupation`)
VALUES (
 @idAc1,
 'Les élégantes locations de vacances de Gingerhill allient sans effort luxe et simplicité pour vous servir de maison captivante loin de chez vous.',
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

SELECT @idA1 := id FROM addresses WHERE address_line_1 = '11-3802 12th St';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@idA1, '+1 206-890-9881');

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

SELECT @idLo1 := id FROM locations WHERE phone_number = '+1 206-890-9881';
SELECT @idAc1 := id FROM accommodations WHERE name = 'Holiday Inn Express Waikiki';

INSERT INTO accommodations_locations (`accommodation_id`, `location_id`)
VALUES (@idAc1, @idLo1);

INSERT INTO accommodations_periods (`period_id`, `accommodation_id`)
VALUES (@idP5, @idAc1);

INSERT INTO rooms (`accommodation_id`,
 `description`,
 `occupation`)
VALUES (
 @idAc1,
 'Nos locations de vacances de luxe à Hawaï célèbrent la beauté naturelle de l\'île.',
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
 'image/jpeg',
 'Image d\'un avion de guerre',
 '/uploaded_files/phAviation.jpg',
 0
 ),
(
 'D.K Steak',
 'image/jpeg',
 'Steak de type T-Bone',
 '/uploaded_files/dkSteak.jpg',
 0
 ),
(
 'Gondola',
 'image/jpeg',
 'Gondole sur l\'eau à Venise',
 '/uploaded_files/gondola.jpg',
 0
 ),
(
 'Tower of Pisa',
 'image/jpeg',
 'Tour de pise en Italie',
 '/uploaded_files/pisaTower.jpg',
 0
 ),
(
 'Coliseum',
 'image/jpeg',
 'Photo du Colisée de rome durant la nuit',
 '/uploaded_files/coliseum.jpg',
 0
 );


SELECT @idM1 := id FROM media WHERE description = 'Image d\'un avion de guerre';
SELECT @idM2 := id FROM media WHERE description = 'Steak de type T-Bone';
SELECT @idM3 := id FROM media WHERE description = 'Gondole sur l\'eau à Venise';
SELECT @idM4 := id FROM media WHERE description = 'Tour de pise en Italie';
SELECT @idM5 := id FROM media WHERE description = 'Photo du Colisée de rome durant la nuit';


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

SELECT @idA1 := id FROM addresses WHERE address_line_1 = '943-944 Dorsoduro';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@idA1, '+39 335 600 7513');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'RESTAURANTS',
 'https://osteriaalsquero.wordpress.com/',
 'Excellente cuisine locale',
 'Osteria Al Squero'
 );

SELECT @idLo1 := id FROM locations WHERE phone_number = '+39 335 600 7513';
SELECT @idAct1 := id FROM activities WHERE name = 'Osteria Al Squero';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@idAct1, @idLo1);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @idAct1,
 @idS3,
 '120',
 '90'
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

SELECT @idA1 := id FROM addresses WHERE address_line_1 = '3 Via dei Benci';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@idA1, '+39 055 217833');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'RESTAURANTS',
 'https://www.labuchetta.com/',
 'Cuisine locale, Steakhouse, Italienne, Méditerranéenne, Européenne, Bar à vins',
 'La Buchetta Food & Wine Restaurant'
 );

SELECT @idLo1 := id FROM locations WHERE phone_number = '+39 055 217833';
SELECT @idAct1 := id FROM activities WHERE name = 'La Buchetta Food & Wine Restaurant';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@idAct1, @idLo1);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @idAct1,
 @idS4,
 '2790',
 '90'
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

SELECT @idA1 := id FROM addresses WHERE address_line_1 = 'Box 22, Nuovo Mercato di Testaccio Via Aldo Manunzio, snc';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@idA1, '+39 338 702 6829');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'RESTAURANTS',
 'https://casamanco.it/',
 'Excellentes pizzas italiennes authentiques',
 'Casa Manco'
 );

SELECT @idLo1 := id FROM locations WHERE phone_number = '+39 338 702 6829';
SELECT @idAct1 := id FROM activities WHERE name = 'Casa Manco';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@idAct1, @idLo1);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @idAct1,
 @idS5,
 '720',
 '90'
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

SELECT @idA1 := id FROM addresses WHERE address_line_1 = '2556 Lemon Rd';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@idA1, '1-800-760-7718');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'RESTAURANTS',
 'https://www.waikikibeachsidehostel.com/',
 'Cuisine américaine',
 'Waikiki Beachside Kitchen'
 );

SELECT @idLo1 := id FROM locations WHERE phone_number = '1-800-760-7718';
SELECT @idAct1 := id FROM activities WHERE name = 'Waikiki Beachside Kitchen';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@idAct1, @idLo1);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @idAct1,
 @idS1,
 '720',
 '90'
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

SELECT @idA1 := id FROM addresses WHERE address_line_1 = '2552 Kalakaua Ave';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@idA1, '+1 808-922-6611');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'RESTAURANTS',
 'https://www.marriotthawaii.com/restaurants/d-k-steak-house/',
 'Type de cuisine steakhouse',
 'D.K. Steakhouse'
 );

SELECT @idLo1 := id FROM locations WHERE phone_number = '+1 808-922-6611';
SELECT @idAct1 := id FROM activities WHERE name = 'D.K. Steakhouse';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@idAct1, @idLo1);

INSERT INTO activities_media (`activity_id`, `media_id`)
VALUES (@idAct1, @idM2);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @idAct1,
 @idS1,
 '1140',
 '90'
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

SELECT @idA1 := id FROM addresses WHERE address_line_1 = '1 Crater Rim Drive';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@idA1, '(844) 569-8849');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'RESTAURANTS',
 'https://www.hawaiivolcanohouse.com/dining',
 'Cuisine hawaïenne / américaine',
 'Volcano House'
 );

SELECT @idLo1 := id FROM locations WHERE phone_number = '(844) 569-8849';
SELECT @idAct1 := id FROM activities WHERE name = 'Volcano House';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@idAct1, @idLo1);

 INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @idAct1,
 @idS2,
 '1080',
 '120'
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

SELECT @idA1 := id FROM addresses WHERE address_line_1 = '19-3948 Old Volcano Rd';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@idA1, '+1 808-967-7366');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'RESTAURANTS',
 'https://highwaywestvacations.com/properties/kilauea-lodge?utm_source=tripadvisor&utm_medium=referral',
 'Fruits de mer, Cuisine internationale',
 'Kilauea Lodge Restaurant'
 );

SELECT @idLo1 := id FROM locations WHERE phone_number = '+1 808-967-7366';
SELECT @idAct1 := id FROM activities WHERE name = 'Kilauea Lodge Restaurant';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@idAct1, @idLo1);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @idAct1,
 @idS2,
 '1140',
 '90'
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

SELECT @idA1 := id FROM addresses WHERE address_line_1 = 'Unnamed Road';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@idA1, '+39 041 528 5075');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'RELAXING',
 'https://www.gondola-rides-venice.com/',
 'Profitez d\'une belle balade en gondole relaxante autour de Venise',
 'Balades en gondole'
 );

SELECT @idLo1 := id FROM locations WHERE phone_number = '+39 041 528 5075';
SELECT @idAct1 := id FROM activities WHERE name = 'Balades en gondole';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@idAct1, @idLo1);

INSERT INTO activities_media (`activity_id`, `media_id`)
VALUES (@idAct1, @idM3);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @idAct1,
 @idS3,
 '480',
 '120'
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

SELECT @idA1 := id FROM addresses WHERE address_line_1 = 'Piazza del Duomo';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@idA1, '+39 050 835011');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'DISCOVERY',
 'http://www.towerofpisa.org/visit-tower-of-pisa/',
 'Visitez Pise, connue pour sa célèbre tour penchée',
 'Explorez Pise'
 );

SELECT @idLo1 := id FROM locations WHERE phone_number = '+39 050 835011';
SELECT @idAct1 := id FROM activities WHERE name = 'Explorez Pise';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@idAct1, @idLo1);

INSERT INTO activities_media (`activity_id`, `media_id`)
VALUES (@idAct1, @idM4);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @idAct1,
 @idS4,
 '30',
 '2040'
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

SELECT @idA1 := id FROM addresses WHERE address_line_1 = '30 Vico';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@idA1, '+39 055 294883');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'DISCOVERY',
 'https://www.visitflorence.com/',
 'Profitez d\'une journée libre à Florence',
 'Explorez Florence'
 );

SELECT @idLo1 := id FROM locations WHERE phone_number = '+39 055 294883';
SELECT @idAct1 := id FROM activities WHERE name = 'Explorez Florence';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@idAct1, @idLo1);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @idAct1,
 @idS5,
 '30',
 '600'
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

SELECT @idA1 := id FROM addresses WHERE address_line_1 = '1 Piazza del Colosseo';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@idA1, '+39 06 3996 7700');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'DISCOVERY',
 'https://www.il-colosseo.it/en/informazioni-colosseo.php?',
 'Passez la journée à Rome et visitez le Colisée',
 'Explorez Rome'
 );

 SELECT @idLo1 := id FROM locations WHERE phone_number = '+39 06 3996 7700';
 SELECT @idAct1 := id FROM activities WHERE name = 'Explorez Rome';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@idAct1, @idLo1);

INSERT INTO activities_media (`activity_id`, `media_id`)
VALUES (@idAct1, @idM5);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @idAct1,
 @idS5,
 '00', /* starts whenever the client wants and can explore freely until the end of the day. */
 '1440'
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

SELECT @idA1 := id FROM addresses WHERE address_line_1 = '319 Lexington Blvd';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@idA1, '(808) 441-1000');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'OTHER',
 'https://www.pearlharboraviationmuseum.org/',
 'Musée de l\'aviation relatant l\'attaque de Pearl Harbor et la 2e guerre mondiale',
 'Musée Pearl Harbor'
 );

SELECT @idLo1 := id FROM locations WHERE phone_number = '(808) 441-1000';
SELECT @idAct1 := id FROM activities WHERE name = 'Musée Pearl Harbor';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@idAct1, @idLo1);

INSERT INTO activities_media (`activity_id`, `media_id`)
VALUES (@idAct1, @idM1);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @idAct1,
 @idS1,
 '30',
 '180'
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

SELECT @idA1 := id FROM addresses WHERE address_line_1 = '2863 Kalakaua Ave';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@idA1, '+1 808-923-1555');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'RELAXING',
 'https://www.gohawaii.com/islands/oahu/things-to-do/beaches/sans-souci-kaimana-beach-park',
 'Plage familiale idéale où vous pouvez faire du kayak, de la plongée avec tuba ou simplement nager en paix',
 'Plage Sans souci'
 );

SELECT @idLo1 := id FROM locations WHERE phone_number = '+1 808-923-1555';
SELECT @idAct1 := id FROM activities WHERE name = 'Plage Sans souci';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@idAct1, @idLo1);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @idAct1,
 @idS1,
 '30',
 '240'
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

SELECT @idA1 := id FROM addresses WHERE address_line_1 = '82-6199 Mamalahoa Hwy';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@idA1, '+1 808-323-3222');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'OTHER',
 'https://konahistorical.org/kona-coffee-living-history-farm',
 'Ferme historique où vous pouvez en apprendre davantage sur la production de café',
 'Kona Coffee Living History Farm'
 );

SELECT @idLo1 := id FROM locations WHERE phone_number = '+1 808-323-3222';
SELECT @idAct1 := id FROM activities WHERE name = 'Kona Coffee Living History Farm';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@idAct1, @idLo1);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @idAct1,
 @idS2,
 '30',
 '150'
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

SELECT @idA1 := id FROM addresses WHERE address_line_1 = '11-3802 12th St';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@idA1, '+1 206-890-9881');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'DISCOVERY',
 'http://visitthevolcano.com/adventures/',
 'Randonnée en montagne pour admirer les volcans de l\'île d\'Hawaï',
 'Volcan Kilauea'
 );

SELECT @idLo1 := id FROM locations WHERE phone_number = '+1 206-890-9881';
SELECT @idAct1 := id FROM activities WHERE name = 'Volcan Kilauea';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@idAct1, @idLo1);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @idAct1,
 @idS2,
 '1440',
 '150'
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

SELECT @idA1 := id FROM addresses WHERE address_line_1 = '35 Piimauna Dr, Volcano';

INSERT INTO locations (`address_id`, `phone_number`)
VALUES (@idA1, '+1 808-967-7772');

INSERT INTO activities (`activity_type`,
 `link`,
 `description`,
 `name`)
VALUES (
 'OTHER',
 'https://volcanowinery.com/',
 'Vignoble où vous pourrez déguster des vins hawaïens authentiques inspirés par les fruits des îles',
 'Volcano Winery'
 );

SELECT @idLo1 := id FROM locations WHERE phone_number = '+1 808-967-7772';
SELECT @idAct1 := id FROM activities WHERE name = 'Volcano Winery';

INSERT INTO activities_locations (`activity_id`, `location_id`)
VALUES (@idAct1, @idLo1);

INSERT INTO steps_activities (`activity_id`,
 `step_id`,
 `time_after_last_step`,
 `duration`)
VALUES (
 @idAct1,
 @idS2,
 '30',
 '120'
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
