<?php

/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 4/6/2016
 * Time: 8:27 AM
 */
class Seeder extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		// can only be called from the command line
		if (!$this->input->is_cli_request()) {
			exit('Direct access is not allowed');
		}

		// can only be run in the development environment
		if (ENVIRONMENT !== 'development') {
			exit('Wowsers! You don\'t want to do that!');
		}

		// initiate faker
		$this->faker = Faker\Factory::create();

		// load any required models
		$this->load->model('Ohkr_model');
		$this->load->model('Xform_model');
	}

	/**
	 * seed local database
	 */
	function seed()
	{
		// purge existing data
		$this->_truncate_db();

		// seed users
		//$this->_seed_users(25);

		// call dalili za mifugo
		$this->_seed_dalili_za_mifugo_forms(2150);
		$this->_seed_dalili_za_binadamu_forms(2150);
		$this->_seed_diseases(100);
		$this->_seed_species(5);
		$this->_seed_symptoms(200);
		$this->_seed_form_jamii(2150);
	}

	private function _truncate_db()
	{
		$this->db->truncate('ad_build_dalili_za_mifugo_1418895355');
		$this->db->truncate('ad_build_dalili_za_binadamu_1418894655');
		$this->db->truncate('ad_build_fomu_jamii_1459930979');

		$this->db->where("id > 0", NULL);
		$this->db->delete('diseases_symptoms');

		$this->db->where("id > 0", NULL);
		$this->db->delete('symptoms');

		$this->db->where("id > 0", NULL);
		$this->db->delete('diseases');
		//$this->User_model->truncate();
		//$this->db->truncate('users');
	}

	function _seed_dalili_za_mifugo_forms($limit)
	{
		// 'sacids'.'
		$table_name = "ad_build_dalili_za_mifugo_1418895355";

		$sql = "CREATE TABLE IF NOT EXISTS `" . $table_name . "` (
			  `id` int(20) UNSIGNED NOT NULL,
			  `meta_instanceID` varchar(300) DEFAULT NULL,
			  `meta_deviceID` varchar(300) DEFAULT NULL,
			  `taarifa_za_awali_jina_la_mkusanyaji_taarifa` varchar(300) NOT NULL,
			  `taarifa_za_awali_Wilaya` enum('Ngorongoro','Kibaha','Bagamoyo') NOT NULL,
			  `taarifa_za_awali_Kijiji` varchar(300) NOT NULL,
			  `taarifa_za_awali_kitongoji` varchar(300) DEFAULT NULL,
			  `taarifa_za_awali_tarehe_kukusanya_taarifa` date NOT NULL,
			  `dalili_jina_boma` varchar(300) DEFAULT NULL,
			  `dalili_aina_mifugo_dalili` enum('Ng''ombe','Mbuzi','Kondoo','Punda','Mbwa','Kuku') DEFAULT NULL,
			  `dalili_aina_nyingine_mfugo` varchar(300) DEFAULT NULL,
			  `dalili_zilizoonekana` text,
			  `dalili_zingine` varchar(300) DEFAULT NULL,
			  `umri_idadi_Idadi_dalili_wadogo` int(20) NOT NULL,
			  `umri_idadi_Idadi_dalili_wakubwa` int(20) NOT NULL,
			  `umri_idadi_idadi_vifo_wadogo` int(20) NOT NULL,
			  `umri_idadi_Idadi_vifo_wakubwa` int(20) NOT NULL,
			  `GPS_picha_ugonjwa_ugonjwa_unaodhaniwa` varchar(300) DEFAULT NULL,
			  `GPS_picha_ugonjwa_picture` varchar(300) DEFAULT NULL,
			  `GPS_picha_ugonjwa_GPS` varchar(150) NOT NULL,
			  `GPS_picha_ugonjwa_GPS_point` point NOT NULL,
			  `GPS_picha_ugonjwa_GPS_lat` decimal(38,10) NOT NULL,
			  `GPS_picha_ugonjwa_GPS_lng` decimal(38,10) NOT NULL,
			  `GPS_picha_ugonjwa_GPS_acc` decimal(38,10) NOT NULL,
			  `GPS_picha_ugonjwa_GPS_alt` decimal(38,10) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

		$this->db->query($sql);

		echo "seeding $limit dalili za mifugo" . PHP_EOL;

		// create a bunch of base symptoms data
		for ($i = 0; $i < $limit; $i++) {
			$point = $this->_random_lat_and_lon();
			$lat = $point['lat']; //$this->faker->latitude;
			$lon = $point['lon']; //$this->faker->longitude;
			$accuracy = $this->faker->randomFloat(10, 0, 50);
			$altitude = $this->faker->randomFloat(10, 0, 4000);

			$build_dalili_za_mifugo_data = array(
				'meta_instanceID' => 'uuid:' . $this->faker->unique()->uuid,
				'meta_deviceID' => str_replace("-", "", $this->faker->unique()->uuid),
				'taarifa_za_awali_jina_la_mkusanyaji_taarifa' => $this->faker->firstName . " " . $this->faker->lastName,
				'taarifa_za_awali_Wilaya' => $this->_get_random_value_from_array(array('Ngorongoro', 'Kibaha', 'Bagamoyo')),
				'taarifa_za_awali_Kijiji' => $this->faker->streetName,
				'taarifa_za_awali_kitongoji' => $this->faker->word,
				'taarifa_za_awali_tarehe_kukusanya_taarifa' => $this->faker->dateTimeThisYear->format('Y-m-d H:i:s'),
				'dalili_jina_boma' => $this->faker->word,
				'dalili_aina_mifugo_dalili' => $this->_get_random_value_from_array(array('Ng\'ombe', 'Mbuzi', 'Kondoo', 'Punda', 'Mbwa', 'Kuku')),
				'dalili_aina_nyingine_mfugo' => '',
				'dalili_zilizoonekana' => $this->faker->sentence(mt_rand(3, 20)),
				'dalili_zingine' => $this->faker->randomDigit,
				'umri_idadi_Idadi_dalili_wadogo' => $this->faker->randomDigit,
				'umri_idadi_Idadi_dalili_wakubwa' => $this->faker->randomDigit,
				'umri_idadi_idadi_vifo_wadogo' => $this->faker->randomDigit,
				'umri_idadi_Idadi_vifo_wakubwa' => $this->faker->randomDigit,
				'GPS_picha_ugonjwa_ugonjwa_unaodhaniwa' => $this->_get_random_value_from_array(array('RFV', 'FMD', 'ECF', 'PPR', 'CPDP')),
				'GPS_picha_ugonjwa_picture' => '', //$this->faker->image(),
				'GPS_picha_ugonjwa_GPS' => $lat . " " . $lon . " " . $accuracy . " " . $altitude,
				'GPS_picha_ugonjwa_GPS_lat' => $lat,
				'GPS_picha_ugonjwa_GPS_lng' => $lon,
				'GPS_picha_ugonjwa_GPS_acc' => $accuracy,
				'GPS_picha_ugonjwa_GPS_alt' => $altitude
			);
			$this->db->set('`GPS_picha_ugonjwa_GPS_point`', "GeomFromText('POINT(" . $lat . " " . $lon . ")')", FALSE);
			$this->Xform_model->insert_xform_data($table_name, $build_dalili_za_mifugo_data);
		}
	}

	function _random_lat_and_lon($initial_longitude = 37.0720999900, $initial_latitude = -6.4287696900)
	{
		$longitude = (float)$initial_longitude;
		$latitude = (float)$initial_latitude;
		$radius = rand(1, 50); // in miles

		$lng_min = $longitude - $radius / abs(cos(deg2rad($latitude)) * 69);
		$lng_max = $longitude + $radius / abs(cos(deg2rad($latitude)) * 69);
		$lat_min = $latitude - ($radius / 69);
		$lat_max = $latitude + ($radius / 69);

		return array(
			'lon' => $this->_get_random_value_from_array(array($lng_min, $lng_max, $lng_min, $lng_max, $longitude)),
			'lat' => $this->_get_random_value_from_array(array($lat_min, $lat_max, $lat_min, $lat_max, $latitude))
		);
	}

	function _get_random_value_from_array($array = array())
	{
		$rand_key = array_rand($array, 1);
		return $array[$rand_key];
	}

	function _seed_dalili_za_binadamu_forms($limit)
	{
		echo "seeding $limit dalili za binadamu\n";

		$table_name = "ad_build_dalili_za_binadamu_1418894655";

		$sql = "CREATE TABLE IF NOT EXISTS `" . $table_name . "` (
			  `id` int(20) UNSIGNED NOT NULL,
			  `meta_instanceID` varchar(300) DEFAULT NULL,
			  `meta_deviceID` varchar(300) DEFAULT NULL,
			  `taarifa_za_awali_jina_la_mkusanyaji_taarifa` varchar(300) NOT NULL,
			  `taarifa_za_awali_wilaya` enum('Ngorongoro','Kibaha','Bagamoyo') NOT NULL,
			  `taarifa_za_awali_kijiji` varchar(300) NOT NULL,
			  `taarifa_za_awali_kitongoji` varchar(300) DEFAULT NULL,
			  `taarifa_za_awali_tarehe_ya_ukusanyaji_taarifa` date NOT NULL,
			  `dalili_jinsia` enum('mme','mke') NOT NULL,
			  `dalili_zinazoonesha` text,
			  `dalili_zingine` varchar(300) DEFAULT NULL,
			  `Umri_idadi_vifo_umri` enum('Chini ya miaka 5','6 - 18','19 - 25','26 - 35','36 - 45','56 - 65','Zaidi ya 65') NOT NULL,
			  `Umri_idadi_vifo_Idadi_dalili_chini_miaka_5` int(20) NOT NULL,
			  `Umri_idadi_vifo_idadi_dalili_watoto` int(20) NOT NULL,
			  `Umri_idadi_vifo_Idadi_dalili_vijana` int(20) NOT NULL,
			  `Umri_idadi_vifo_Idadi_dalili_wazee` int(20) NOT NULL,
			  `Umri_idadi_vifo_idadi_vifo_chini_5` int(20) NOT NULL,
			  `Umri_idadi_vifo_idadi_vifo_watoto` int(20) NOT NULL,
			  `Umri_idadi_vifo_idadi_vifo_vijana` int(20) NOT NULL,
			  `Umri_idadi_vifo_Idadi_vifo_wazee` int(20) NOT NULL,
			  `GPS_picha_ugonjwa_ugonjwa_unaodhaniwa` varchar(300) DEFAULT NULL,
			  `GPS_picha_ugonjwa_picture` varchar(300) DEFAULT NULL,
			  `GPS_picha_ugonjwa_GPS` varchar(150) NOT NULL,
			  `GPS_picha_ugonjwa_GPS_point` point NOT NULL,
			  `GPS_picha_ugonjwa_GPS_lat` decimal(38,10) NOT NULL,
			  `GPS_picha_ugonjwa_GPS_lng` decimal(38,10) NOT NULL,
			  `GPS_picha_ugonjwa_GPS_acc` decimal(38,10) NOT NULL,
			  `GPS_picha_ugonjwa_GPS_alt` decimal(38,10) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

		$this->db->query($sql);


		for ($i = 0; $i < $limit; $i++) {
			$point = $this->_random_lat_and_lon();
			$lat = $point['lat']; //$this->faker->latitude;
			$lon = $point['lon']; //$this->faker->longitude;
			$accuracy = $this->faker->randomFloat(10, 0, 50);
			$altitude = $this->faker->randomFloat(10, 0, 4000);

			$dalili_za_binadamu_data = array(
				'meta_instanceID' => 'uuid:' . $this->faker->unique()->uuid,
				'meta_deviceID' => str_replace("-", "", $this->faker->unique()->uuid),
				'taarifa_za_awali_jina_la_mkusanyaji_taarifa' => $this->faker->firstName . " " . $this->faker->lastName,
				'taarifa_za_awali_wilaya' => $this->_get_random_value_from_array(array("Ngorongoro", "Kibaha", "Bagamoyo")),
				'taarifa_za_awali_kijiji' => $this->faker->streetName,
				'taarifa_za_awali_kitongoji' => $this->faker->word,
				'taarifa_za_awali_tarehe_ya_ukusanyaji_taarifa' => $this->faker->date("Y-m-d", "now"),
				'dalili_jinsia' => $this->_get_random_value_from_array(array("Mme", "Mke")),
				'dalili_zinazoonesha' => "",
				'dalili_zingine' => "",
				'Umri_idadi_vifo_umri' => $this->_get_random_value_from_array(array('Chini ya miaka 5', '6 - 18', '19 - 25', '26 - 35', '36 - 45', '56 - 65', 'Zaidi ya 65')), //$this->faker->numberBetween(0,100),
				'Umri_idadi_vifo_Idadi_dalili_chini_miaka_5' => $this->faker->randomDigit,
				'Umri_idadi_vifo_idadi_dalili_watoto' => $this->faker->randomDigit,
				'Umri_idadi_vifo_Idadi_dalili_vijana' => $this->faker->randomDigit,
				'Umri_idadi_vifo_Idadi_dalili_wazee' => $this->faker->randomDigit,
				'Umri_idadi_vifo_idadi_vifo_chini_5' => $this->faker->randomDigit,
				'Umri_idadi_vifo_idadi_vifo_watoto' => $this->faker->randomDigit,
				'Umri_idadi_vifo_idadi_vifo_vijana' => $this->faker->randomDigit,
				'Umri_idadi_vifo_Idadi_vifo_wazee' => $this->faker->randomDigit,
				'GPS_picha_ugonjwa_ugonjwa_unaodhaniwa' => $this->_get_random_value_from_array(array('Malaria', 'Cholera', 'Flue', 'ZIKA', 'Bird Flu')),
				'GPS_picha_ugonjwa_picture' => "", //todo find a way to add random images
				'GPS_picha_ugonjwa_GPS' => $lat . " " . $lon . " " . $accuracy . " " . $altitude,
				'GPS_picha_ugonjwa_GPS_lat' => $lat,
				'GPS_picha_ugonjwa_GPS_lng' => $lon,
				'GPS_picha_ugonjwa_GPS_acc' => $accuracy,
				'GPS_picha_ugonjwa_GPS_alt ' => $altitude
			);

			$this->db->set('`GPS_picha_ugonjwa_GPS_point`', "GeomFromText('POINT(" . $lat . " " . $lon . ")')", FALSE);
			$this->Xform_model->insert_xform_data($table_name, $dalili_za_binadamu_data);
		}

	}

	function _seed_diseases($limit)
	{
		echo "Seeding {$limit} diseases\n";

		for ($i = 0; $i < $limit; $i++) {
			$disease_data = array(
				"name" => $this->faker->sentence(mt_rand(1, 10)),
				"description" => $this->faker->realText(mt_rand(50, 500)),
				"date_created" => $this->faker->dateTimeBetween("-10 days", "now")->format('Y-m-d H:i:s')
			);
			$this->Ohkr_model->add_disease($disease_data);
		}
	}

	function _seed_species($limit)
	{
		echo "Seeding {$limit} species\n";

		for ($i = 0; $i < $limit; $i++) {
			$specie_data = array(
				"name" => $this->_get_random_value_from_array(array("Binadamu", "Ng'ombe", "Mbuzi", "Kondoo", "Nguruwe")),
				"date_created" => $this->faker->dateTimeBetween("-10 days", "now")->format('Y-m-d H:i:s')
			);
			$this->Ohkr_model->add_specie($specie_data);
		}
	}

	function _seed_symptoms($limit)
	{
		echo "Seeding {$limit} symptoms\n";

		for ($i = 0; $i < $limit; $i++) {
			$symptom_data = array(
				"name" => $this->faker->sentence(mt_rand(1, 10)),
				"description" => $this->faker->realText(mt_rand(50, 500)),
				"date_created" => $this->faker->dateTimeBetween("-10 days", "now")->format('Y-m-d H:i:s')
			);
			$this->Ohkr_model->add_symptom($symptom_data);
		}
	}

	function _seed_form_jamii($limit)
	{
		$form_jamii_table_name = "ad_build_fomu_jamii_1459930979";
		$create_table_sql = "
 				  CREATE TABLE IF NOT EXISTS `{$form_jamii_table_name}` (
				  `id` int(20) UNSIGNED NOT NULL,
				  `meta_instanceID` varchar(300) DEFAULT NULL,
				  `FirstPage_Name` varchar(300) DEFAULT NULL,
				  `FirstPage_Area` varchar(300) DEFAULT NULL,
				  `FirstPage_Date` date DEFAULT NULL,
				  `FirstPage_Picture` varchar(300) DEFAULT NULL,
				  `FirstPage_Comments` varchar(300) DEFAULT NULL,
				  `FirstPage_Location` varchar(150) DEFAULT NULL,
				  `FirstPage_Location_point` point DEFAULT NULL,
				  `FirstPage_Location_lat` decimal(38,10) DEFAULT NULL,
				  `FirstPage_Location_lng` decimal(38,10) DEFAULT NULL,
				  `FirstPage_Location_acc` decimal(38,10) DEFAULT NULL,
				  `FirstPage_Location_alt` decimal(38,10) DEFAULT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$this->db->query($create_table_sql);

		echo "Seeding {$limit} form jamii" . PHP_EOL;

		for ($i = 0; $i < $limit; $i++) {
			$point = $this->_random_lat_and_lon();
			$lat = $point['lat']; //$this->faker->latitude;
			$lon = $point['lon']; //$this->faker->longitude;
			$accuracy = $this->faker->randomFloat(10, 0, 50);
			$altitude = $this->faker->randomFloat(10, 0, 4000);
			$form_jamii = array(
				'meta_instanceID' => 'uuid:' . $this->faker->unique()->uuid,
				'FirstPage_Name' => $this->faker->firstName . " " . $this->faker->lastName,
				'FirstPage_Area' => $this->faker->streetName,
				'FirstPage_Date' => $this->faker->dateTimeThisYear->format('Y-m-d H:i:s'),
				'FirstPage_Picture' => "",
				'FirstPage_Comments' => $this->faker->realText(mt_rand(100, 1000)),
				'FirstPage_Location' => $lat . " " . $lon . " " . $accuracy . " " . $altitude,
				'FirstPage_Location_lat' => $lat,
				'FirstPage_Location_lng' => $lon,
				'FirstPage_Location_acc' => $accuracy,
				'FirstPage_Location_alt' => $altitude
			);
			$this->db->set('`FirstPage_Location_point`', "GeomFromText('POINT(" . $lat . " " . $lon . ")')", FALSE);
			$this->Xform_model->insert_xform_data($form_jamii_table_name, $form_jamii);
		}
	}

	/**
	 * seed users
	 *
	 * @param int $limit
	 */
	function _seed_users($limit)
	{
		echo "seeding $limit users";

		// create a bunch of base buyer accounts
		for ($i = 0; $i < $limit; $i++) {
			echo ".";

			$data = array(
				'username' => $this->faker->unique()->userName, // get a unique nickname
				'password' => 'awesomepassword', // run this via your password hashing function
				'firstname' => $this->faker->firstName,
				'surname' => $this->faker->lastName,
				'address' => $this->faker->streetAddress,
				'city' => $this->faker->city,
				'state' => $this->faker->state,
				'country' => $this->faker->country,
				'postcode' => $this->faker->postcode,
				'email' => $this->faker->email,
				'email_verified' => mt_rand(0, 1) ? '0' : '1',
				'phone' => $this->faker->phoneNumber,
				'birthdate' => $this->faker->dateTimeThisCentury->format('Y-m-d H:i:s'),
				'registration_date' => $this->faker->dateTimeThisYear->format('Y-m-d H:i:s'),
				'ip_address' => mt_rand(0, 1) ? $this->faker->ipv4 : $this->faker->ipv6,
			);

			//$this->User_model->create($data);
		}

		echo PHP_EOL;
	}
}
