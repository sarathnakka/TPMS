<?php

	/*************************************************************************
	*	Ajax Full Featured Calendar
	*	- Add Event To Calendar
	*	- Edit Event On Calendar
	*	- Delete Event On Calendar
	*	- View Event On Calendar
	*	- Update Event On Rezise
	*	- Update Event On Drag
	*
	*	Author: Paulo Regina
	*	Version: 1.5
	*	
	**************************************************************************/
	
	class calendar
	{
		
		###############################################################################################
		#### Properties
		###############################################################################################
		
		// Initializes A Container Array For All Of The Calendar Events
		var $json_array = array();
		var $categories = '';
		var $connection = '';
		
		############################################################################################### 
		#### Methods
		###############################################################################################
		
		/**
		* Construct
		* Returns connection
		*/
		public function __construct($db_server, $db_username, $db_password, $db_name, $table, $condition=false)
		{
			// Set Internal Variables
			$this->db_server = $db_server;	
			$this->db_username = $db_username;
			$this->db_password = $db_password;
			$this->db_name = $db_name;
			$this->table = $table;	
			
			$this->condition = $condition;
			
			// Connection @params 'Server', 'Username', 'Password'
			$this->connection = mysqli_connect($this->db_server, $this->db_username, $this->db_password, $this->db_name);
			
			// Display Friend Error Message On Connection Failure
			if(!$this->connection) 
			{
				die('Could not connect: ' . mysqli_error($this->connection));
			}
			
			// Internal UTF-8
			mysqli_query($this->connection, "SET NAMES 'utf8'");
			mysqli_query($this->connection, 'SET character_set_connection=utf8');
			mysqli_query($this->connection, 'SET character_set_client=utf8');
			mysqli_query($this->connection, 'SET character_set_results=utf8');
			
			// Run The Query
			if($this->condition == false)
			{
				$this->result = mysqli_query($this->connection, "SELECT * FROM $this->table ");
			} else {
				$this->result = mysqli_query($this->connection, "SELECT * FROM $this->table WHERE $this->condition");	
			}
			
		}
		
		/**
		* Function To Transform MySQL Results To jQuery Calendar Json
		* Returns converted json
		*/
		public function json_transform($js = true)
		{
			
			while($this->row = mysqli_fetch_array($this->result, MYSQL_ASSOC))
			{
				 // Set Variables Data from DB
				 $event_id = $this->row['id'];
				 $event_title = $this->row['title'];
				 $event_description = $this->row['description'];
				 $event_start = $this->row['start'];
				 $event_end = $this->row['end'];
				 $event_allDay = $this->row['allDay'];
				 $event_color = $this->row['color'];
				 $event_url = $this->row['url'];
				 
				 if($js == true) 
				 {
				 	 // JS MODE
					
					 // When allDay = false the allDay options appears on the script, when its true it doesnot appear 
					 if($event_url == 'false' && $event_allDay == 'false')
					 {
						 // Build it Without URL & allDay
						 
						 // Stores Each Database Record To An Array (Without URL)
						$build_json = array('id' => $event_id, 'title' => $event_title, 'description' => $event_description, 'start' => $event_start, 'end' => $event_end, 'allDay' => $event_allDay, 'color' => $event_color);
	
						// Adds Each Array Into The Container Array
						array_push($this->json_array, $build_json);
						
					 } elseif($event_url == 'false' && $event_allDay == 'true') {
						 
						 // Build it Without URL 
						 
						 // Stores Each Database Record To An Array (Without URL)
						$build_json = array('id' => $event_id, 'title' => $event_title, 'description' => $event_description, 'start' => $event_start, 'end' => $event_end, 'color' => $event_color);
	
						// Adds Each Array Into The Container Array
						array_push($this->json_array, $build_json);
					  
					 } elseif($event_url == 'true' && $event_allDay == 'false') {
						 
						 // Built it Without URL & allDay True
						 
						// Stores Each Database Record To An Array
						$build_json = array('id' => $event_id, 'title' => $event_title, 'description' => $event_description, 'start' => $event_start, 'end' => $event_end, 'allDay' => $event_allDay, 'color' => $event_color, 'url' => $event_url);
						
						// Adds Each Array Into The Container Array
						array_push($this->json_array, $build_json);
						
					 } else {
						 
						 if($event_allDay == 'false') {
							// Built it With URL & allDay false
							 
							// Stores Each Database Record To An Array
							$build_json = array('id' => $event_id, 'title' => $event_title, 'description' => $event_description, 'start' => $event_start, 'end' => $event_end, 'allDay' => $event_allDay, 'color' => $event_color, 'url' => $event_url);
							
							// Adds Each Array Into The Container Array
							array_push($this->json_array, $build_json);
						 } else {
							// Built it With URL & allDay True
							 
							// Stores Each Database Record To An Array
							$build_json = array('id' => $event_id, 'title' => $event_title, 'description' => $event_description, 'start' => $event_start, 'end' => $event_end, 'color' => $event_color, 'url' => $event_url);
							
							// Adds Each Array Into The Container Array
							array_push($this->json_array, $build_json);	 
						 }
						 
					 }
				 
				 } else {
						
					// PHP MODE
					
					// When allDay = false the allDay options appears on the script, when its true it doesnot appear 
					 if($event_url == 'false' && $event_allDay == 'false')
					 {
						 // Build it Without URL & allDay
						 
						 // Stores Each Database Record To An Array (Without URL)
						$build_json = array('id' => $event_id, 'title' => $event_title, 'description' => $event_description, 'start' => $event_start, 'end' => $event_end, 'allDay' => $event_allDay, 'color' => $event_color);
	
						// Adds Each Array Into The Container Array
						array_push($this->json_array, $build_json);
						
					 } elseif($event_url == 'false' && $event_allDay == 'true') {
						 
						 // Build it Without URL 
						 
						 // Stores Each Database Record To An Array (Without URL)
						$build_json = array('id' => $event_id, 'title' => $event_title, 'description' => $event_description, 'start' => $event_start, 'end' => $event_end, 'color' => $event_color);
	
						// Adds Each Array Into The Container Array
						array_push($this->json_array, $build_json);
					  
					 } elseif($event_url == 'true' && $event_allDay == 'false') {
						 
						 // Built it Without URL & allDay True
						 
						// Stores Each Database Record To An Array
						$build_json = array('id' => $event_id, 'title' => $event_title, 'description' => $event_description, 'start' => $event_start, 'end' => $event_end, 'allDay' => $event_allDay, 'color' => $event_color, 'url' => $event_url);
						
						// Adds Each Array Into The Container Array
						array_push($this->json_array, $build_json);
						
					 } else {
						 
						 if($event_allDay == 'false' && substr($event_url, -4, 1) == '.' || substr($event_url, -3, 1) == '.') { // domain top level checking
							// Built it With URL & allDay false
							 
							// Stores Each Database Record To An Array
							$build_json = array('id' => $event_id, 'title' => $event_title, 'description' => $event_description, 'start' => $event_start, 'end' => $event_end, 'allDay' => $event_allDay, 'color' => $event_color, 'url' => $event_url);
							
							// Adds Each Array Into The Container Array
							array_push($this->json_array, $build_json);
							
						 } elseif($event_allDay == 'true' && substr($event_url, -4, 1) == '.' || substr($event_url, -3, 1) == '.') {
							
							// Built it With URL & allDay true
							 
							// Stores Each Database Record To An Array
							$build_json = array('id' => $event_id, 'title' => $event_title, 'description' => $event_description, 'start' => $event_start, 'end' => $event_end,  'color' => $event_color, 'url' => $event_url);
							
							// Adds Each Array Into The Container Array
							array_push($this->json_array, $build_json);
							
						 } elseif($event_allDay == 'false' && isset($event_url)) {
						 	
							// Built it With any URL and allDay false
							
							// Stores Each Database Record To An Array
							$build_json = array('id' => $event_id, 'title' => $event_title, 'description' => $event_description, 'start' => $event_start, 'end' => $event_end,  'allDay' => $event_allDay, 'color' => $event_color, 'url' => $event_url . $event_id);
							
							// Adds Each Array Into The Container Array
							array_push($this->json_array, $build_json);
							
					 	 } else {
							// Built it With URL & allDay True
							 
							// Stores Each Database Record To An Array
							$build_json = array('id' => $event_id, 'title' => $event_title, 'description' => $event_description, 'start' => $event_start, 'end' => $event_end, 'color' => $event_color, 'url' => $event_url . $event_id);
							
							// Adds Each Array Into The Container Array
							array_push($this->json_array, $build_json);	 
						 }
						 
					 }
					
					 
				 }
				 	  
			} // end while loop
			
			// Output The Json Formatted Data So That The jQuery Call Can Read It
			return json_encode($this->json_array);	
		}
		
		/**
		* This function updates event drag, resize from jquery fullcalendar
		* Returns true
		*/
		public function update($allDay, $start, $end, $id)
		{			
			// Convert Date Time
			$start = strftime('%Y-%m-%d %H:%M:%S', strtotime(substr($start, 0, 24)));
			$end = strftime('%Y-%m-%d %H:%M:%S', strtotime(substr($end, 0, 24)));
			
			if($allDay == 'false') {
				$allDay_value = 'true';
			} elseif($allDay == 'true') {
				$allDay_value = 'false';	
			}
			
			// The update query
			$query = sprintf('UPDATE %s 
									SET 
										start = "%s",
										end = "%s",
										allDay = "%s"
									WHERE
										id = %s
						',
										mysqli_real_escape_string($this->connection, $this->table),
										mysqli_real_escape_string($this->connection, $start),
										mysqli_real_escape_string($this->connection, $end),
										mysqli_real_escape_string($this->connection, $allDay_value),
										mysqli_real_escape_string($this->connection, $id)
						);
			
			// The result
			return $this->result = mysqli_query($this->connection, $query);
		}
		
		/**
		* This function updates events to the database
		* Returns true
		*/
		public function updates($id, $title, $description, $url)
		{			
			// The update query
			$query = sprintf('UPDATE %s 
									SET 
										title = "%s",
										description = "%s",
										url = "%s"
									WHERE
										id = %s
						',
										mysqli_real_escape_string($this->connection, $this->table),
										mysqli_real_escape_string($this->connection, htmlentities($title)),
										mysqli_real_escape_string($this->connection, htmlentities($description)),
										mysqli_real_escape_string($this->connection, htmlentities($url)),
										mysqli_real_escape_string($this->connection, $id)
						);
			
			// The result
			return $this->result = mysqli_query($this->connection, $query);
		}
		
		/**
		* This function adds events to the database
		* Returns true
		*/
		public function addEvent($title, $description, $start_date, $start_time, $end_date, $end_time, $color, $allDay, $url, $extra=false)
		{			
			// Convert Date Time
			$start = $start_date.' '.$start_time.':00';
			$end = $end_date.' '.$end_time.':00';
			
			// Checking
			if(empty($url)) 
			{
				$url = 'false';
			}
			
			// Check for empty data
			if(empty($title) && empty($start_date))
			{
				return false;	
			}
			
			// Add Data to Database based on users $extra field
			if(isset($extra) && is_array($extra))
			{	
				################### - All Your Extra Fields both from 'quickSave' and from 'Add Event', catch here and procede from here
				
				// Catch extra fields from $_POST
				$category = $extra['categorie'];

				# your own fields would be: $field = $extra['field_name']; and add them below on the $query as others are
				
				// The Advanced Database - Add Event Query
				$query = sprintf('INSERT INTO %s 
										SET 
											title = "%s",
											description = "%s",
											start = "%s",
											end = "%s",
											allDay = "%s",
											color = "%s",
											url = "%s",
											category = "%s"
							',
											mysqli_real_escape_string($this->connection, $this->table),
											mysqli_real_escape_string($this->connection, htmlentities($title)),
											mysqli_real_escape_string($this->connection, htmlentities($description)),
											mysqli_real_escape_string($this->connection, htmlentities($start)),
											mysqli_real_escape_string($this->connection, htmlentities($end)),
											mysqli_real_escape_string($this->connection, $allDay),
											mysqli_real_escape_string($this->connection, htmlentities($color)),
											mysqli_real_escape_string($this->connection, htmlentities($url)),
											mysqli_real_escape_string($this->connection, htmlentities($category))
							);
							
				################################################################################################################# --- End
				
			} else {

				// The Basic Database - Add Event Query
				$query = sprintf('INSERT INTO %s 
										SET 
											title = "%s",
											description = "%s",
											start = "%s",
											end = "%s",
											allDay = "%s",
											color = "%s",
											url = "%s"
							',
											mysqli_real_escape_string($this->connection, $this->table),
											mysqli_real_escape_string($this->connection, htmlentities($title)),
											mysqli_real_escape_string($this->connection, htmlentities($description)),
											mysqli_real_escape_string($this->connection, htmlentities($start)),
											mysqli_real_escape_string($this->connection, htmlentities($end)),
											mysqli_real_escape_string($this->connection, $allDay),
											mysqli_real_escape_string($this->connection, htmlentities($color)),
											mysqli_real_escape_string($this->connection, htmlentities($url))
	
							);
			}
			
			// The result
			$this->result = mysqli_query($this->connection, $query);
			
			if($this->result) 
			{
				return true;
			} else {
				return false;	
			}
		}
		
		/**
		* Gets all Categories - since version 1.4
		* Returns array
		*/
		public function getCategories()
		{
			// Set default category in case the user do not have categories with events
			$results = $this->categories;
			asort($results);
			$return = array_unique(array_filter($results));
			
			if(count($return) == 0)
			{
				return false;
			} else {
				return $return;	
			}
		}
		
		/**
		* This function deletes event from database
		* Returns true
		*/
		public function delete($id)
		{
			// Delete Query
			$query = "DELETE FROM $this->table WHERE id = $id";	
			
			// Result
			$this->result = mysqli_query($this->connection, $query);
			
			if($this->result) 
			{
				return true;
			} else {
				return false;	
			}
			
		}
		
		/**
		* This function exports each event to the icalendar format and forces a download
		* Returns true
		*/		
		public function icalExport($id, $title, $description, $start_date, $end_date, $url=false)
		{
			
			if($url == 'undefined') 
			{
				$url = '';
			} else {
				$url = ' '.$url.' ';	
			}
			
			$description_fn = $str = str_replace(array("\r","\n","\t"),'\n',$description);;
			
			// Build the ics file
$ical = 'BEGIN:VCALENDAR
PRODID:-//Paulo Regina//Ajax Calendar 1.6 MIMEDIR//EN
VERSION:2.0
BEGIN:VEVENT
CREATED:'.date('Ymd\This', time()).'Z'.'
DESCRIPTION:'.$description_fn.$url.'
DTEND:'.$end_date.'
DTSTAMP:'.date('Ymd\This', time()).'Z'.'
DTSTART:'.$start_date.'
LAST-MODIFIED:'.date('Ymd\This', time()).'Z'.'
SUMMARY:'.addslashes($title).'
END:VEVENT
END:VCALENDAR';
			 
			if(isset($id)) {
				return $ical;
			} else {
				return false;
			}
		}
		
		/**
		* This function retrieves calendar data
		* Returns true
		*/
		public function retrieve($id)
		{
			// Result Query
			$this->result = mysqli_query($this->connection, sprintf("SELECT * FROM $this->table WHERE id = %s", mysqli_real_escape_string($this->connection, $id)));
			
			if($this->result) {
				return mysqli_fetch_assoc($this->result);
			} else {
				return false;	
			}
				
		}
				
	}

?>