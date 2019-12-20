USE labernoisdb;

START TRANSACTION;
/* Categories */

INSERT INTO `categories` (`id`, `name`, `description`)
VALUES (1, 'DÉTENTE', 'Circuit de voyage o vous pourrez relaxer et profiter de votre temps autours dun verre de vin!');

INSERT INTO `categories` (`id`, `name`, `description`)
VALUES (2, 'ACTION', 'Circuit de voyage ou vous pourrez participer dans des aventures tumultueuses!');

/* Medias */

INSERT INTO `media` (`id`, `name`, `media_type`, `description`, `path`, `header`)
VALUES (1, 'Hawaii Header', 'image', 'Sunset in Hawaii', '/images/hawaiiHeader.jpg', 1);

INSERT INTO `media` (`id`, `name`, `media_type`, `description`, `path`, `header`)
VALUES (2, 'War Plane', 'image', 'Image of a war plane', '/images/phAviation.jpg', 0);

INSERT INTO `media` (`id`, `name`, `media_type`, `description`, `path`, `header`)
VALUES (3, 'D.K Steak', 'image', 'T-Bone Steak', '/images/dkSteak.jpg', 0);

INSERT INTO `media` (`id`, `name`, `media_type`, `description`, `path`, `header`)
VALUES (4, 'Hawaii Resort', 'image', 'Volcano Resort', '/images/craterEdge.jpg', 0);

INSERT INTO `media` (`id`, `name`, `media_type`, `description`, `path`, `header`)
VALUES (5, 'Venice Hotel', 'image', 'image of a room in Hotel Continental Venice', '/images/hotelVenice.jpg', 0);

INSERT INTO `media` (`id`, `name`, `media_type`, `description`, `path`, `header`)
VALUES (6, 'Gondola', 'image', 'Gondola on the water in Venice', '/images/gondola.jpg', 0);

INSERT INTO `media` (`id`, `name`, `media_type`, `description`, `path`, `header`)
VALUES (7, 'Tower of Pisa', 'image', 'Tower of pisa in Italy', '/images/pisaTower.jpg', 0);

INSERT INTO `media` (`id`, `name`, `media_type`, `description`, `path`, `header`)
VALUES (8, 'Coliseum', 'image', 'Picture of the coliseum at night', '/images/coliseum.jpg', 0);


/* Addresses  (address_line 2 & Postal Code will default to null.)  */

/* Accommodation addresses */

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES (1, 'Italy', 'Venezia', 'VE', '166 Rio Terà Lista di Spagna');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES (2, 'Italy', 'Venezia', 'VE', '1848 Calle del Frutarol');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES (3, 'Italy', 'Firenze', 'FI', '3 Piazza Piave');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES (4, 'Italy', 'Roma', 'RM', '15 Via Cavour');


INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES (5, 'United States', 'Honolulu', 'HI', '2556 Lemon Rd B11');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES (6, 'United States', 'Honolulu', 'HI', '258 Kuhio Ave');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES (7, 'United States', ' Kealakekua', 'HI', '81-6467 Mamalahoa Hwy');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES (8, 'United States', 'Volcano', 'HI', '11-382 12th St');


/* Restaurant addresses */

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES (9, 'Italy', 'Venezia', 'VE', '943-944 Dorsoduro');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES (10, 'Italy', 'Firenze', 'FI', '3 Via dei Benci');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES (11, 'Italy', 'Roma', 'RM', 'Box 22, Nuovo Mercato di Testaccio Via Aldo Manunzio, snc');


INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES (12, 'United States', 'Honolulu', 'HI', '2556 Lemon Rd');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES (13, 'United States', 'Honolulu', 'HI', '2552 Kalakaua Ave');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES (14, 'United States', 'Hawaii Volcanoes National Park', 'HI', '1 Crater Rim Drive');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES (15, 'United States', 'Volcano', 'HI', '19-3948 Old Volcano Rd');


/* All other activities addresses */

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES (16, 'Italy', 'Venezia', 'VE', 'Unnamed Road');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES (17, 'Italy', 'Pisa', 'PI', 'Piazza del Duomo');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES (18, 'Italy', 'Florence', 'FI', '30 Vico');


INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES (19, 'United States', 'Honolulu', 'HI', '319 Lexington Blvd');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES (20, 'United States', 'Honolulu', 'HI', '2863 Kalakaua Ave');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES (21, 'United States', 'Captain Cook', 'HI', '82-6199 Mamalahoa Hwy');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES (22, 'United States', 'Volcano', 'HI', '11-382 12th St');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES (23, 'United States', 'Volcano', 'HI', '35 Piimauna Dr, Volcano');


INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES (24, 'Italy', 'Roma', 'RM', '1 Piazza del Colosseo');


/* Locations  (Email will default to null.) */

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES (1, 1, '+39 41 715122');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES (2, 2, '+39 41 522 947');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES (3, 3, '+39 55 243668');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES (4, 4, '+39 6 488 451');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES (5, 5, '+1 88 923 9566');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES (6, 6, '+1 88-947-2828');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES (7, 7, '+1 88-427-9972');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES (8, 8, '+1 26-890-9881');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES (9, 9, '+39 335 60 7513');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES (10, 10, '+39 55 217833');

INSERT INTO `locations` (`id`, `address_id`)
VALUES (11, 11);

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES (12, 12, '1-80-760-7718');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES (13, 13, '+1 88-922-6611');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES (14, 14, '(844) 569-8849');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES (15, 15, '+1 88-967-7366');

INSERT INTO `locations` (`id`, `address_id`)
VALUES (16, 16);

INSERT INTO `locations` (`id`, `address_id`)
VALUES (17, 17);

INSERT INTO `locations` (`id`, `address_id`)
VALUES (18, 18);

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES (19, 19, '(88) 441-100');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES (20, 20, '+1 88-923-1555');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES (21, 21, '+1 88-323-3222');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES (22, 22, '+1 26-890-9881');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES (23, 23, '+1 88-967-7772');

INSERT INTO `locations` (`id`, `address_id`)
VALUES (24, 24);


/* Circuits */

INSERT INTO `circuits` (`id`, `media_id`, `language_id`, `category_id`, `name`, `description`, `is_public`)
VALUES (1, 1, 2, 2, 'Discover the hawaiian islands', 'Discover the beautiful islands of Hawaii by participating in a multitude of activities. Admire the local culture, history and cuisine and be amazed by the unforgetable landscapes.', 1);

INSERT INTO `circuits` (`id`, `media_id`, `language_id`, `category_id`, `name`, `description`, `is_public`)
VALUES (2, 1, 2, 1, 'Live the italian lifestyle', 'Live the authentic italian experience by exploring historic sites, enjoying nice relaxing gondola rides and eating at amazing authentic local restaurants.', 1);


/* Accommodations */

INSERT INTO `accommodations` (`id`, `location_id`, `accommodation_type`, `link`, `rating`, `name`)
VALUES (1, 1, 'HOTEL', 'https://www.hotelcontinentalvenice.com/', 4, 'Hotel Continental Venice');

INSERT INTO `accommodations` (`id`, `location_id`, `accommodation_type`, `link`, `rating`, `name`)
VALUES (2, 2, 'HOTEL', 'https://www.hotelmercurio.com/', 3, 'Hotel Mercurio Venice');

INSERT INTO `accommodations` (`id`, `location_id`, `accommodation_type`, `link`, `rating`, `name`)
VALUES (3, 3, 'HOTEL', 'http://www.hhflorence.com/it/', 4, 'Home Florence');

INSERT INTO `accommodations` (`id`, `location_id`, `accommodation_type`, `link`, `rating`, `name`)
VALUES (4, 4, 'HOTEL', 'https://www.bettojahotels.it/en', 4, 'Bettoha Hotels Collection');


INSERT INTO `accommodations` (`id`, `location_id`, `accommodation_type`, `link`, `rating`, `name`)
VALUES (5, 5, 'HOUSE', 'http://visitthevolcano.com/aloha-welcome-craters-edge-luxury-lodging-near-volcanoes-national-park/', 5, 'At the crater’s edge');

INSERT INTO `accommodations` (`id`, `location_id`, `accommodation_type`, `link`, `rating`, `name`)
VALUES (6, 6, 'CONDO', 'https://gingerhillfarm.com/', 3, 'Gingerhill Farm Retreat');

INSERT INTO `accommodations` (`id`, `location_id`, `accommodation_type`, `link`, `rating`, `name`)
VALUES (7, 7, 'HOTEL', 'https://www.waikikibeachsidehostel.com/', 3, 'Waikiki Beachside Hostel');

INSERT INTO `accommodations` (`id`, `location_id`, `accommodation_type`, `link`, `rating`, `name`)
VALUES (8, 8, 'HOTEL', 'https://www.hiexpress.com/hotels/us/en/honolulu/hnlka/hoteldetail?fromRedirect=true&qSrt=sBR&qIta=9954425&icdv=9954425&glat=SEAR&qSlH=HNLKA&setPMCookies=true&qSHBrC=EX&qDest=258%20Kuhio%20Avenue,%20Honolulu,%20HI,%20US&dp=true&gclid=Cj0KCQiArdLvBRCrARIsAGhB_sx5JHFZ7A88LAs2d1zAq3cUIuZyttT3Mk_A3ut7dFLjozeIPaVB9QYaAnoFEALw_wcB&cid=55660&srb_u=1', 4, 'Holiday Inn Express Waikiki');


/* Restaurants */

INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES (1, 'RESTAURANTS', 'https://osteriaalsquero.wordpress.com/', 'Excellent local food', 'Osteria Al Squero');

INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES (2, 'RESTAURANTS', 'https://www.labuchetta.com/', 'Local cuisine, Steakhouse, Italian, Mediterranean, European, Wine Bar', 'La Buchetta Food & Wine Restaurant');

INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES (3, 'RESTAURANTS', 'https://casamanco.it/', 'Excellent authentic italian pizzas', 'Casa Manco');


INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES (4, 'RESTAURANTS', 'https://www.waikikibeachsidehostel.com/', 'American style of cuisine', 'Waikiki Beachside Kitchen');

INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES (5, 'RESTAURANTS', 'https://www.marriotthawaii.com/restaurants/d-k-steak-house/', 'Steakhouse type of cuisine', 'D.K. Steakhouse');

INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES (6, 'RESTAURANTS', 'https://www.hawaiivolcanohouse.com/dining', 'Hawaiian / American type of cuisine', 'Volcano House');

INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES (7, 'RESTAURANTS', 'https://highwaywestvacations.com/properties/kilauea-lodge?utm_source=tripadvisor&utm_medium=referral', '
Seafood, International cuisine', 'Kilauea Lodge Restaurant');


/* All other activities */

INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES (8, 'RELAXING', 'https://www.gondola-rides-venice.com/', '
Enjoy a nice relaxing gondola ride around Venice.', 'Gondola Rides');

INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES (9, 'DISCOVERY', 'http://www.towerofpisa.org/visit-tower-of-pisa/', '
Visit Pisa, known for its famous Leaning Tower.', 'Explore Pisa');

INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES (10, 'DISCOVERY', 'https://www.visitflorence.com/', '
Spend the day at leisure in Florence.', 'Explore Florence');


INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES (11, 'OTHER', 'https://www.pearlharboraviationmuseum.org/', '
Aviation museum relating the attack on Pearl Harbor and the 2nd World War.', 'Pearl Harbor Museum');

INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES (12, 'RELAXING', 'https://www.gohawaii.com/islands/oahu/things-to-do/beaches/sans-souci-kaimana-beach-park', '
Ideal family beach where you can kayak, snorkel or just swim in peace.', 'Sans souci beach');

INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES (13, 'OTHER', 'https://konahistorical.org/kona-coffee-living-history-farm', '
Historic farm where you can learn more about coffee production', 'Kona Coffee Living History Farm');

INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES (14, 'DISCOVERY', 'http://visitthevolcano.com/adventures/', '
Mountain hike to admire the volcanoes of the island of Hawaii', 'Kilauea Volcano');

INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES (15, 'OTHER', 'https://volcanowinery.com/', '
Vineyard where you can taste authentic Hawaiian wines inspired by the fruits of the islands', 'Volcano Winery');


INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES (16, 'DISCOVERY', 'https://www.il-colosseo.it/en/informazioni-colosseo.php?', '
Spend the day in Rome and visit the coliseum.', 'Explore Rome');


/* Rooms */

INSERT INTO `rooms` (`id`, `accommodation_id`, `description`, `occupation`)
VALUES (1, 1, 'Sophisticated rooms come with free Wi-Fi and satellite TV, as well as minibars and coffeemakers. Some offer canal or street views. Room service is available.', 3);

INSERT INTO `rooms` (`id`, `accommodation_id`, `description`, `occupation`)
VALUES (2, 2, 'Rooms and Suites offer the experience of absolute comfort in a stylish environment and they come equipped with the most modern comforts.', 3);

INSERT INTO `rooms` (`id`, `accommodation_id`, `description`, `occupation`)
VALUES (3, 3, 'The minimalist, modern rooms and suites come with free Wi-Fi, satellite TV and coffeemakers. Upgraded rooms feature canopy beds and private terraces; suites add iPod docks and dining areas. Room service is available.', 3);

INSERT INTO `rooms` (`id`, `accommodation_id`, `description`, `occupation`)
VALUES (4, 4, 'Otherwise indicated, guests will stay in our Standard Rooms.', 3);


INSERT INTO `rooms` (`id`, `accommodation_id`, `description`, `occupation`)
VALUES (5, 5, 'All rooms include private bathrooms, fridge and microwave. In-room kitchens based on request and availability.', 4);

INSERT INTO `rooms` (`id`, `accommodation_id`, `description`, `occupation`)
VALUES (6, 6, 'Enjoy our brand new guest rooms with modern amenities including complimentary WiFi internet access and a 49” HDTV. All rooms have compact refrigerator, microwave and Keurig with coffee and tea pods replenished daily.', 3);

INSERT INTO `rooms` (`id`, `accommodation_id`, `description`, `occupation`)
VALUES (7, 7, 'Gingerhill’s elegant vacation rentals effortlessly fuse luxury and simplicity to serve as your captivating home away from home.', 6);

INSERT INTO `rooms` (`id`, `accommodation_id`, `description`, `occupation`)
VALUES (8, 8, 'Our luxury vacation rentals in Hawaii celebrate the island’s natural beauty.', 2);


/* Steps */

INSERT INTO `steps` (`id`, `circuit_id`, `description`, `position`, `time_after_last_step`)
VALUES (1, 1, '', 1, 0);

INSERT INTO `steps` (`id`, `circuit_id`, `description`, `position`, `time_after_last_step`)
VALUES (2, 1, '', 2, 2);


INSERT INTO `steps` (`id`, `circuit_id`, `description`, `position`, `time_after_last_step`)
VALUES (3, 2, '', 1, 0);

INSERT INTO `steps` (`id`, `circuit_id`, `description`, `position`, `time_after_last_step`)
VALUES (4, 2, '', 2, 2);

INSERT INTO `steps` (`id`, `circuit_id`, `description`, `position`, `time_after_last_step`)
VALUES (5, 2, '', 3, 2);


/* Periods */

INSERT INTO `periods` (`id`, `step_id`, `time_after_step_start`)
VALUES (1, 1, 2);

INSERT INTO `periods` (`id`, `step_id`, `time_after_step_start`)
VALUES (2, 2, 3);


INSERT INTO `periods` (`id`, `step_id`, `time_after_step_start`)
VALUES (3, 3, 2);

INSERT INTO `periods` (`id`, `step_id`, `time_after_step_start`)
VALUES (4, 4, 2);

INSERT INTO `periods` (`id`, `step_id`, `time_after_step_start`)
VALUES (5, 5, 2);


/* Inclusions */

INSERT INTO `inclusions` (`id`, `circuit_id`, `description`)
VALUES (1, 1, 'Trip between the Hawaiian Islands');

INSERT INTO `inclusions` (`id`, `circuit_id`, `description`)
VALUES (2, 2, 'High-speed train between Venice and Florence; Florence and Rome in first class');

INSERT INTO `inclusions` (`id`, `circuit_id`, `description`)
VALUES (3, 2, 'Guided walking tour of Rome with Vatican Museum and Sistine Chapel');

/* Exclusions */

INSERT INTO `exclusions` (`id`, `circuit_id`, `description`)
VALUES (1, 1, 'Flight/ return flight to/ from Hawaii');

INSERT INTO `exclusions` (`id`, `circuit_id`, `description`)
VALUES (2, 2, 'Flight to Venice; return flight from Rome');



/* Link tables */

INSERT INTO `accommodations_locations` (`id`, `accommodation_id`, `location_id`)
VALUES (1, 1, 1);

INSERT INTO `accommodations_locations` (`id`, `accommodation_id`, `location_id`)
VALUES (2, 2, 2);

INSERT INTO `accommodations_locations` (`id`, `accommodation_id`, `location_id`)
VALUES (3, 3, 3);

INSERT INTO `accommodations_locations` (`id`, `accommodation_id`, `location_id`)
VALUES (4, 4, 4);

INSERT INTO `accommodations_locations` (`id`, `accommodation_id`, `location_id`)
VALUES (5, 5, 5);

INSERT INTO `accommodations_locations` (`id`, `accommodation_id`, `location_id`)
VALUES (6, 6, 6);

INSERT INTO `accommodations_locations` (`id`, `accommodation_id`, `location_id`)
VALUES (7, 7, 7);

INSERT INTO `accommodations_locations` (`id`, `accommodation_id`, `location_id`)
VALUES (8, 8, 8);


/* For the restaurants*/

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES (1, 1, 9);

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES (2, 2, 10);

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES (3, 3, 11);

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES (4, 4, 12);

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES (5, 5, 13);

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES (6, 6, 14);

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES (7, 7, 15);


/* For all the other activities */

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES (8, 8, 16);

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES (9, 9, 17);

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES (10, 10, 18);

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES (11, 11, 19);

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES (12, 12, 20);

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES (13, 13, 21);

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES (14, 14, 22);

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES (15, 15, 23);

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES (16, 16, 24);


/* For the medias */

INSERT INTO `accommodations_media` (`id`, `accommodation_id`, `media_id`)
VALUES (1, 1, 4);

INSERT INTO `accommodations_media` (`id`, `accommodation_id`, `media_id`)
VALUES (2, 5, 5);


INSERT INTO `activities_media` (`id`, `activity_id`, `media_id`)
VALUES (3, 11, 2);

INSERT INTO `activities_media` (`id`, `activity_id`, `media_id`)
VALUES (4, 5, 3);

INSERT INTO `activities_media` (`id`, `activity_id`, `media_id`)
VALUES (5, 8, 6);

INSERT INTO `activities_media` (`id`, `activity_id`, `media_id`)
VALUES (6, 9, 7);

INSERT INTO `activities_media` (`id`, `activity_id`, `media_id`)
VALUES (7, 16, 8);


/* For periods */

INSERT INTO `accommodations_periods` (`id`, `period_id`, `accommodation_id`)
VALUES (1, 1, 1);

INSERT INTO `accommodations_periods` (`id`, `period_id`, `accommodation_id`)
VALUES (2, 1, 2);

INSERT INTO `accommodations_periods` (`id`, `period_id`, `accommodation_id`)
VALUES (3, 2, 3);

INSERT INTO `accommodations_periods` (`id`, `period_id`, `accommodation_id`)
VALUES (4, 2, 4);


INSERT INTO `accommodations_periods` (`id`, `period_id`, `accommodation_id`)
VALUES (5, 3, 5);

INSERT INTO `accommodations_periods` (`id`, `period_id`, `accommodation_id`)
VALUES (6, 3, 6);

INSERT INTO `accommodations_periods` (`id`, `period_id`, `accommodation_id`)
VALUES (7, 4, 7);

INSERT INTO `accommodations_periods` (`id`, `period_id`, `accommodation_id`)
VALUES (8, 5, 8);

COMMIT;
