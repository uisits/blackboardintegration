<?php
namespace uisits\blackboardintegration\Http\Controllers\classes;
class Course {
	public $id;
	public $externalId = 'BB-TEST';
	public $courseId = 'BB-TEST';
	public $name = 'Course Used For BB-TEST';
	public $description = 'Course Used For BB-TEST';
	public $allowGuests = TRUE;
	public $readOnly = FALSE;
	public $termId = '';
	public $dataSourceId = '';
	public $uuid;
	public $created;
	public $organization = '';
	public $availability = '';
	public $enrollment = '';
	public $locale =  '';
}
