USE labernoisdb;

/* Categories */

INSERT INTO `categories` (`id`, `name`, `description`)
VALUES ('01', 'DÉTENTE', 'Circuit de voyage o vous pourrez relaxer et profiter de votre temps autours dun verre de vin!');

INSERT INTO `categories` (`id`, `name`, `description`)
VALUES ('02', 'ACTION', 'Circuit de voyage ou vous pourrez participer dans des aventures tumultueuses!');


/* Languages */

INSERT INTO `languages` (`id`, `name`)
VALUES ('01', 'FRENCH');

INSERT INTO `languages` (`id`, `name`)
VALUES ('02', 'ENGLISH');

INSERT INTO `languages` (`id`, `name`)
VALUES ('03', 'SPANISH');


/* Medias */

INSERT INTO `media` (`id`, `name`, `media_type`, `description`, `path`, `header`)
VALUES ('01', 'Hawaii Header', 'image', 'Sunset in Hawaii', '/images/hawaiiHeader.jpg', '01');

INSERT INTO `media` (`id`, `name`, `media_type`, `description`, `path`, `header`)
VALUES ('02', 'War Plane', 'image', 'Image of a war plane', '/images/phAviation.jpg', '00');

INSERT INTO `media` (`id`, `name`, `media_type`, `description`, `path`, `header`)
VALUES ('03', 'D.K Steak', 'image', 'T-Bone Steak', '/images/dkSteak.jpg', '00');

INSERT INTO `media` (`id`, `name`, `media_type`, `description`, `path`, `header`)
VALUES ('04', 'Hawaii Resort', 'image', 'Volcano Resort', '/images/craterEdge.jpg', '00');

INSERT INTO `media` (`id`, `name`, `media_type`, `description`, `path`, `header`)
VALUES ('05', 'Venice Hotel', 'image', 'image of a room in Hotel Continental Venice', '/images/hotelVenice.jpg', '00');

INSERT INTO `media` (`id`, `name`, `media_type`, `description`, `path`, `header`)
VALUES ('06', 'Gondola', 'image', 'Gondola on the water in Venice', '/images/gondola.jpg', '00');

INSERT INTO `media` (`id`, `name`, `media_type`, `description`, `path`, `header`)
VALUES ('07', 'Tower of Pisa', 'image', 'Tower of pisa in Italy', '/images/pisaTower.jpg', '00');

INSERT INTO `media` (`id`, `name`, `media_type`, `description`, `path`, `header`)
VALUES ('08', 'Coliseum', 'image', 'Picture of the coliseum at night', '/images/coliseum.jpg', '00');


/* Addresses  (address_line 2 & Postal Code will default to null.)  */

/* Accommodation addresses */

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES ('01', 'Italy', 'Venezia', 'VE', '166 Rio Terà Lista di Spagna'); 

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES ('02', 'Italy', 'Venezia', 'VE', '1848 Calle del Frutarol');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES ('03', 'Italy', 'Firenze', 'FI', '3 Piazza Piave');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES ('04', 'Italy', 'Roma', 'RM', '15 Via Cavour');


INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES ('05', 'United States', 'Honolulu', 'HI', '2556 Lemon Rd B101');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES ('06', 'United States', 'Honolulu', 'HI', '2058 Kuhio Ave');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES ('07', 'United States', ' Kealakekua', 'HI', '81-6467 Mamalahoa Hwy');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES ('08', 'United States', 'Volcano', 'HI', '11-3802 12th St');


/* Restaurant addresses */

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES ('09', 'Italy', 'Venezia', 'VE', '943-944 Dorsoduro');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES ('10', 'Italy', 'Firenze', 'FI', '3 Via dei Benci');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES ('11', 'Italy', 'Roma', 'RM', 'Box 22, Nuovo Mercato di Testaccio Via Aldo Manunzio, snc');


INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES ('12', 'United States', 'Honolulu', 'HI', '2556 Lemon Rd');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES ('13', 'United States', 'Honolulu', 'HI', '2552 Kalakaua Ave');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES ('14', 'United States', 'Hawaii Volcanoes National Park', 'HI', '1 Crater Rim Drive');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES ('15', 'United States', 'Volcano', 'HI', '19-3948 Old Volcano Rd');


/* All other activities addresses */

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES ('16', 'Italy', 'Venezia', 'VE', 'Unnamed Road');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES ('17', 'Italy', 'Pisa', 'PI', 'Piazza del Duomo');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES ('18', 'Italy', 'Florence', 'FI', '30 Vico');


INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES ('19', 'United States', 'Honolulu', 'HI', '319 Lexington Blvd');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES ('20', 'United States', 'Honolulu', 'HI', '2863 Kalakaua Ave');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES ('21', 'United States', 'Captain Cook', 'HI', '82-6199 Mamalahoa Hwy');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES ('22', 'United States', 'Volcano', 'HI', '11-3802 12th St');

INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES ('23', 'United States', 'Volcano', 'HI', '35 Piimauna Dr, Volcano');


INSERT INTO `addresses` (`id`, `country`, `city`, `region`, `address_line_1`)
VALUES ('24', 'Italy', 'Roma', 'RM', '1 Piazza del Colosseo');


/* Locations  (Email will default to null.) */

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES ('01', '01', '+39 041 715122');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES ('02', '02', '+39 041 522 0947');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES ('03', '03', '+39 055 243668');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES ('04', '04', '+39 06 488 4051');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES ('05', '05', '+1 808 923 9566');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES ('06', '06', '+1 808-947-2828');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES ('07', '07', '+1 808-427-9972');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES ('08', '08', '+1 206-890-9881');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES ('09', '09', '+39 335 600 7513');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES ('10', '10', '+39 055 217833');

INSERT INTO `locations` (`id`, `address_id`)
VALUES ('11', '11');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES ('12', '12', '1-800-760-7718');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES ('13', '13', '+1 808-922-6611');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES ('14', '14', '(844) 569-8849');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES ('15', '15', '+1 808-967-7366');

INSERT INTO `locations` (`id`, `address_id`)
VALUES ('16', '16');

INSERT INTO `locations` (`id`, `address_id`)
VALUES ('17', '17');

INSERT INTO `locations` (`id`, `address_id`)
VALUES ('18', '18');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES ('19', '19', '(808) 441-1000');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES ('20', '20', '+1 808-923-1555');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES ('21', '21', '+1 808-323-3222');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES ('22', '22', '+1 206-890-9881');

INSERT INTO `locations` (`id`, `address_id`, `phone_number`)
VALUES ('23', '23', '+1 808-967-7772');

INSERT INTO `locations` (`id`, `address_id`)
VALUES ('24', '24');


/* Circuits */

INSERT INTO `circuits_trips` (`id`, `media_id`, `language_id`, `category_id`, `name`, `description`, `is_public`)
VALUES ('01', '01', '02', '02', 'Discover the hawaiian islands', 'Discover the beautiful islands of Hawaii by participating in a multitude of activities. Admire the local culture, history and cuisine and be amazed by the unforgetable landscapes.', '01'); 

INSERT INTO `circuits_trips` (`id`, `media_id`, `language_id`, `category_id`, `name`, `description`, `is_public`)
VALUES ('02', '01', '02', '01', 'Live the italian lifestyle', 'Live the authentic italian experience by exploring historic sites, enjoying nice relaxing gondola rides and eating at amazing authentic local restaurants.', '01'); 


/* Accommodations */

INSERT INTO `accommodations` (`id`, `location_id`, `accommodation_type`, `link`, `rating`, `name`)
VALUES ('01', '01', 'HOTEL', 'https://www.hotelcontinentalvenice.com/', '4', 'Hotel Continental Venice');  

INSERT INTO `accommodations` (`id`, `location_id`, `accommodation_type`, `link`, `rating`, `name`)
VALUES ('02', '02', 'HOTEL', 'https://www.hotelmercurio.com/', '3', 'Hotel Mercurio Venice');

INSERT INTO `accommodations` (`id`, `location_id`, `accommodation_type`, `link`, `rating`, `name`)
VALUES ('03', '03', 'HOTEL', 'http://www.hhflorence.com/it/', '4', 'Home Florence');  

INSERT INTO `accommodations` (`id`, `location_id`, `accommodation_type`, `link`, `rating`, `name`)
VALUES ('04', '04', 'HOTEL', 'https://www.bettojahotels.it/en', '4', 'Bettoha Hotels Collection');  


INSERT INTO `accommodations` (`id`, `location_id`, `accommodation_type`, `link`, `rating`, `name`)
VALUES ('05', '05', 'HOUSE', 'http://visitthevolcano.com/aloha-welcome-craters-edge-luxury-lodging-near-volcanoes-national-park/', '5', 'At the crater’s edge');  

INSERT INTO `accommodations` (`id`, `location_id`, `accommodation_type`, `link`, `rating`, `name`)
VALUES ('06', '06', 'CONDO', 'https://gingerhillfarm.com/', '3', 'Gingerhill Farm Retreat');  

INSERT INTO `accommodations` (`id`, `location_id`, `accommodation_type`, `link`, `rating`, `name`)
VALUES ('07', '07', 'HOTEL', 'https://www.waikikibeachsidehostel.com/', '3', 'Waikiki Beachside Hostel');  

INSERT INTO `accommodations` (`id`, `location_id`, `accommodation_type`, `link`, `rating`, `name`)
VALUES ('08', '08', 'HOTEL', 'https://www.hiexpress.com/hotels/us/en/honolulu/hnlka/hoteldetail?fromRedirect=true&qSrt=sBR&qIta=99504425&icdv=99504425&glat=SEAR&qSlH=HNLKA&setPMCookies=true&qSHBrC=EX&qDest=2058%20Kuhio%20Avenue,%20Honolulu,%20HI,%20US&dp=true&gclid=Cj0KCQiArdLvBRCrARIsAGhB_sx5JHFZ7A88LAs2d1zAq3cUIuZyttT3Mk_A3ut7dFLjozeIPaVB9QYaAnoFEALw_wcB&cid=55660&srb_u=1', '4', 'Holiday Inn Express Waikiki');  


/* Restaurants */

INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES ('01', 'RESTAURANTS', 'https://osteriaalsquero.wordpress.com/', 'Excellent local food', 'Osteria Al Squero');  

INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES ('02', 'RESTAURANTS', 'https://www.labuchetta.com/', 'Local cuisine, Steakhouse, Italian, Mediterranean, European, Wine Bar', 'La Buchetta Food & Wine Restaurant');  

INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES ('03', 'RESTAURANTS', 'https://casamanco.it/', 'Excellent authentic italian pizzas', 'Casa Manco');  


INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES ('04', 'RESTAURANTS', 'https://www.waikikibeachsidehostel.com/', 'American style of cuisine', 'Waikiki Beachside Kitchen');  

INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES ('05', 'RESTAURANTS', 'https://www.marriotthawaii.com/restaurants/d-k-steak-house/', 'Steakhouse type of cuisine', 'D.K. Steakhouse');  

INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES ('06', 'RESTAURANTS', 'https://www.hawaiivolcanohouse.com/dining', 'Hawaiian / American type of cuisine', 'Volcano House');  

INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES ('07', 'RESTAURANTS', 'https://highwaywestvacations.com/properties/kilauea-lodge?utm_source=tripadvisor&utm_medium=referral', '
Seafood, International cuisine', 'Kilauea Lodge Restaurant'); 


/* All other activities */

INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES ('08', 'RELAXING', 'https://www.gondola-rides-venice.com/', '
Enjoy a nice relaxing gondola ride around Venice.', 'Gondola Rides'); 

INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES ('09', 'DISCOVERY', 'http://www.towerofpisa.org/visit-tower-of-pisa/', '
Visit Pisa, known for its famous Leaning Tower.', 'Explore Pisa'); 

INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES ('10', 'DISCOVERY', 'https://www.visitflorence.com/', '
Spend the day at leisure in Florence.', 'Explore Florence'); 


INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES ('11', 'OTHER', 'https://www.pearlharboraviationmuseum.org/', '
Aviation museum relating the attack on Pearl Harbor and the 2nd World War.', 'Pearl Harbor Museum'); 

INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES ('12', 'RELAXING', 'https://www.gohawaii.com/islands/oahu/things-to-do/beaches/sans-souci-kaimana-beach-park', '
Ideal family beach where you can kayak, snorkel or just swim in peace.', 'Sans souci beach'); 

INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES ('13', 'OTHER', 'https://konahistorical.org/kona-coffee-living-history-farm', '
Historic farm where you can learn more about coffee production', 'Kona Coffee Living History Farm'); 

INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES ('14', 'DISCOVERY', 'http://visitthevolcano.com/adventures/', '
Mountain hike to admire the volcanoes of the island of Hawaii', 'Kilauea Volcano'); 

INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES ('15', 'OTHER', 'https://volcanowinery.com/', '
Vineyard where you can taste authentic Hawaiian wines inspired by the fruits of the islands', 'Volcano Winery'); 


INSERT INTO `activities` (`id`, `activity_type`, `link`, `description`, `name`)
VALUES ('16', 'DISCOVERY', 'https://www.il-colosseo.it/en/informazioni-colosseo.php?', '
Spend the day in Rome and visit the coliseum.', 'Explore Rome'); 


/* Rooms */

INSERT INTO `rooms` (`id`, `accommodation_id`, `description`, `occupation`)
VALUES ('01', '01', 'Sophisticated rooms come with free Wi-Fi and satellite TV, as well as minibars and coffeemakers. Some offer canal or street views. Room service is available.', '03');

INSERT INTO `rooms` (`id`, `accommodation_id`, `description`, `occupation`)
VALUES ('02', '02', 'Rooms and Suites offer the experience of absolute comfort in a stylish environment and they come equipped with the most modern comforts.', '03');

INSERT INTO `rooms` (`id`, `accommodation_id`, `description`, `occupation`)
VALUES ('03', '03', 'The minimalist, modern rooms and suites come with free Wi-Fi, satellite TV and coffeemakers. Upgraded rooms feature canopy beds and private terraces; suites add iPod docks and dining areas. Room service is available.', '03');

INSERT INTO `rooms` (`id`, `accommodation_id`, `description`, `occupation`)
VALUES ('04', '04', 'Otherwise indicated, guests will stay in our Standard Rooms.', '03');


INSERT INTO `rooms` (`id`, `accommodation_id`, `description`, `occupation`)
VALUES ('05', '05', 'All rooms include private bathrooms, fridge and microwave. In-room kitchens based on request and availability.', '04');

INSERT INTO `rooms` (`id`, `accommodation_id`, `description`, `occupation`)
VALUES ('06', '06', 'Enjoy our brand new guest rooms with modern amenities including complimentary WiFi internet access and a 49” HDTV. All rooms have compact refrigerator, microwave and Keurig with coffee and tea pods replenished daily.', '03');

INSERT INTO `rooms` (`id`, `accommodation_id`, `description`, `occupation`)
VALUES ('07', '07', 'Gingerhill’s elegant vacation rentals effortlessly fuse luxury and simplicity to serve as your captivating home away from home.', '06');

INSERT INTO `rooms` (`id`, `accommodation_id`, `description`, `occupation`)
VALUES ('08', '08', 'Our luxury vacation rentals in Hawaii celebrate the island’s natural beauty.', '02');


/* Steps */

INSERT INTO `steps` (`id`, `circuit_id`, `description`, `position`, `time_after_last_step`)
VALUES ('01', '01', '', '01', '00');

INSERT INTO `steps` (`id`, `circuit_id`, `description`, `position`, `time_after_last_step`)
VALUES ('02', '01', '', '02', '02');


INSERT INTO `steps` (`id`, `circuit_id`, `description`, `position`, `time_after_last_step`)
VALUES ('03', '02', '', '01', '00');

INSERT INTO `steps` (`id`, `circuit_id`, `description`, `position`, `time_after_last_step`)
VALUES ('04', '02', '', '02', '02');

INSERT INTO `steps` (`id`, `circuit_id`, `description`, `position`, `time_after_last_step`)
VALUES ('05', '02', '', '03', '02');


/* Periods */

INSERT INTO `periods` (`id`, `step_id`, `time_after_step_start`)
VALUES ('01', '01', '02');

INSERT INTO `periods` (`id`, `step_id`, `time_after_step_start`)
VALUES ('02', '02', '03');


INSERT INTO `periods` (`id`, `step_id`, `time_after_step_start`)
VALUES ('03', '03', '02');

INSERT INTO `periods` (`id`, `step_id`, `time_after_step_start`)
VALUES ('04', '04', '02');

INSERT INTO `periods` (`id`, `step_id`, `time_after_step_start`)
VALUES ('05', '05', '02');


/* Inclusions */

INSERT INTO `inclusions` (`id`, `circuit_id`, `description`)
VALUES ('01', '01', 'Trip between the Hawaiian Islands');

INSERT INTO `inclusions` (`id`, `circuit_id`, `description`)
VALUES ('02', '02', 'High-speed train between Venice and Florence; Florence and Rome in first class');

INSERT INTO `inclusions` (`id`, `circuit_id`, `description`)
VALUES ('03', '02', 'Guided walking tour of Rome with Vatican Museum and Sistine Chapel');

/* Exclusions */

INSERT INTO `exclusions` (`id`, `circuit_id`, `description`)
VALUES ('01', '01', 'Flight/ return flight to/ from Hawaii');

INSERT INTO `exclusions` (`id`, `circuit_id`, `description`)
VALUES ('02', '02', 'Flight to Venice; return flight from Rome');



/* Link tables */

INSERT INTO `accommodations_locations` (`id`, `accommodation_id`, `location_id`)
VALUES ('01', '01', '01'); 

INSERT INTO `accommodations_locations` (`id`, `accommodation_id`, `location_id`)
VALUES ('02', '02', '02');

INSERT INTO `accommodations_locations` (`id`, `accommodation_id`, `location_id`)
VALUES ('03', '03', '03');

INSERT INTO `accommodations_locations` (`id`, `accommodation_id`, `location_id`)
VALUES ('04', '04', '04');

INSERT INTO `accommodations_locations` (`id`, `accommodation_id`, `location_id`)
VALUES ('05', '05', '05');

INSERT INTO `accommodations_locations` (`id`, `accommodation_id`, `location_id`)
VALUES ('06', '06', '06');

INSERT INTO `accommodations_locations` (`id`, `accommodation_id`, `location_id`)
VALUES ('07', '07', '07');

INSERT INTO `accommodations_locations` (`id`, `accommodation_id`, `location_id`)
VALUES ('08', '08', '08');


/* For the restaurants*/

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES ('01', '01', '09');

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES ('02', '02', '10');

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES ('03', '03', '11');

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES ('04', '04', '12');

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES ('05', '05', '13');

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES ('06', '06', '14');

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES ('07', '07', '15');


/* For all the other activities */

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES ('08', '08', '16');

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES ('09', '09', '17');

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES ('10', '10', '18');

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES ('11', '11', '19');

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES ('12', '12', '20');

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES ('13', '13', '21');

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES ('14', '14', '22');

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES ('15', '15', '23');

INSERT INTO `activities_locations` (`id`, `activity_id`, `location_id`)
VALUES ('16', '16', '24');


/* For the medias */

INSERT INTO `accommodations_media` (`id`, `accommodation_id`, `media_id`)
VALUES ('01', '01', '04');

INSERT INTO `accommodations_media` (`id`, `accommodation_id`, `media_id`)
VALUES ('02', '05', '05');


INSERT INTO `activities_media` (`id`, `activity_id`, `media_id`)
VALUES ('03', '11', '02');

INSERT INTO `activities_media` (`id`, `activity_id`, `media_id`)
VALUES ('04', '05', '03');

INSERT INTO `activities_media` (`id`, `activity_id`, `media_id`)
VALUES ('05', '08', '06');

INSERT INTO `activities_media` (`id`, `activity_id`, `media_id`)
VALUES ('06', '09', '07');

INSERT INTO `activities_media` (`id`, `activity_id`, `media_id`)
VALUES ('07', '16', '08');


/* For periods */

INSERT INTO `accommodations_periods` (`id`, `period_id`, `accommodation_id`)
VALUES ('01', '01', '01');

INSERT INTO `accommodations_periods` (`id`, `period_id`, `accommodation_id`)
VALUES ('02', '01', '02');

INSERT INTO `accommodations_periods` (`id`, `period_id`, `accommodation_id`)
VALUES ('03', '02', '03');

INSERT INTO `accommodations_periods` (`id`, `period_id`, `accommodation_id`)
VALUES ('04', '02', '04');


INSERT INTO `accommodations_periods` (`id`, `period_id`, `accommodation_id`)
VALUES ('05', '03', '05');

INSERT INTO `accommodations_periods` (`id`, `period_id`, `accommodation_id`)
VALUES ('06', '03', '06');

INSERT INTO `accommodations_periods` (`id`, `period_id`, `accommodation_id`)
VALUES ('07', '04', '07');

INSERT INTO `accommodations_periods` (`id`, `period_id`, `accommodation_id`)
VALUES ('08', '05', '08');