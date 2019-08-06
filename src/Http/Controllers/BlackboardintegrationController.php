<?php

namespace uisits\blackboardintegration\Http\Controllers;

require_once 'classes/Availability.php';
require_once 'classes/Contact.php';
require_once 'classes/Name.php';
require_once 'classes/Coursegrade.php';
require_once 'classes/Score.php';
require_once 'classes/Coursegradeentry.php';

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Config; 

class BlackboardintegrationController extends Controller
{

	public function index()
	{
		return "Blackboard Integration controller is working";
	}

	public function token_authorize()
	{
		$token = new classes\Token();

		try {
			$response = \Httpful\Request::post(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_AUTH_PATH'))
				->body('grant_type=client_credentials')
				->addHeaders(['Content-Type' => 'application/x-www-form-urlencoded'])
				->basicAuth(env('BB_KEY'), env('BB_SECRET'))
				->expectsJson()
				->send();

			if (200 == $response->code) {
				#print " Authorize Application...\n";
				$token = json_decode(json_encode($response->body));
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return false;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();			
		}

		return $token;
	}

	public function createDatasource($access_token)
	{
		$datasource = new classes\Datasource();

		try {
			$response = \Httpful\Request::post(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_DSK_PATH'))
				->body(json_encode($datasource))
				->addHeaders(['Content-Type' => 'application/json'])
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				->send();


			if (201 == $response->code) {
				//print "\n Create Datasource...\n";
				$datasource = json_decode(json_encode($response->body));
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return false;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return $datasource;
	}

	public function readDatasource($access_token, $dsk_id)
	{
		$datasource = new classes\Datasource();

		try {
			$response = \Httpful\Request::get(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_DSK_PATH') . '/' . $dsk_id)
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				->send();

			if (200 == $response->code) {
				//print "\n Read Datasource...\n";
				$datasource = json_decode(json_encode($response->body));
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return false;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return $datasource;
	}

	public function updateDatasource($access_token, $dsk_id)
	{
		$datasource = new classes\Datasource();

		$datasource->id = $dsk_id;


		try {
			$response = \Httpful\Request::patch(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_DSK_PATH') . '/' . $dsk_id)
				->body(json_encode($datasource))
				->addHeaders(['Content-Type' => 'application/json'])
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				->send();

			if (200 == $response->code) {
				//print "\n Update Datasource...\n";
				$datasource = json_decode(json_encode($response->body));
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return false;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return $datasource;
	}

	public function deleteDatasource($access_token, $dsk_id)
	{

		try {
			$response = \Httpful\Request::delete(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_DSK_PATH') . '/' . $dsk_id)
				->addHeaders(['Content-Type' => 'application/json'])
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				->send();

			if (204 == $response->code) {
				print "Datasource Deleted";
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return FALSE;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return TRUE;
	}

	public function createTerm($access_token, $dsk_id)
	{
		$term = new classes\Term();

		$term->dataSourceId = $dsk_id;
		$term->availability = new classes\Availability();


		try {
			$response = \Httpful\Request::post(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_TERM_PATH'))
				->body(json_encode($term))
				->addHeaders(['Content-Type' => 'application/json'])
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				->send();

			if (201 == $response->code) {
				//print "\n Create Term...\n";
				$term = json_decode(json_encode($response->body));
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return false;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return $term;
	}

	public function readTerm($access_token, $term_id)
	{
		$term = new classes\Term();


		try {
			$response = \Httpful\Request::get(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_TERM_PATH') . '/' . $term_id)
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				->send();

			if (200 == $response->code) {
				//print "\n Read Term...\n";
				$term = json_decode(json_encode($response->body));
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return false;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return $term;
	}

	public function updateTerm($access_token, $dsk_id, $term_id)
	{
		$term = new classes\Term();

		$term->id = $term_id;
		$term->dataSourceId = $dsk_id;


		try {
			$response = \Httpful\Request::patch(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_TERM_PATH') . '/' . $term_id)
				->body(json_encode($term))
				->addHeaders(['Content-Type' => 'application/json'])
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				->send();

			if (200 == $response->code) {
				//print "\n Update Term...\n";
				$term = json_decode(json_encode($response->body));
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return false;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return $term;
	}

	public function deleteTerm($access_token, $term_id)
	{

		try {
			$response = \Httpful\Request::delete(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_TERM_PATH') . '/' . $term_id)
				->addHeaders(['Content-Type' => 'application/json'])
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				->send();

			if (204 == $response->code) {
				print "Term Deleted";
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return FALSE;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return TRUE;
	}

	public function createCourse($access_token, $dsk_id, $term_id)
	{
		$course = new classes\Course();

		$course->dataSourceId = $dsk_id;
		$course->termId = $term_id;
		$course->availability = new classes\Availability();


		try {
			$response = \Httpful\Request::post(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_COURSE_PATH'))
				->body(json_encode($course))
				->addHeaders(['Content-Type' => 'application/json'])
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				//dd($response);
				->send();

			//dd($response);

			if (201 == $response->code) {
				#print "\n Create Course...\n";
				$course = json_decode(json_encode($response->body));
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return false;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return $course;
	}

	public function readCourse($access_token, $course_id)
	{
		$course = new classes\Course();

		//dd(env('BB_HOSTNAME') . env('BB_COURSE_PATH') . '/' . $course_id);

		try {
			$response = \Httpful\Request::get(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_COURSE_PATH') . '/' . $course_id)
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				->send();

			if (200 == $response->code) {
				#print "\n Read Course...\n";
				$course = json_decode(json_encode($response->body));
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return false;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return $course;
	}

	public function getCourseIdbyCourseId($access_token, $course_id)
	{
		$course = new classes\Course();

		try {
			$response = \Httpful\Request::get(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_COURSE_PATH') . '/courseId:' . $course_id)
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				->send();

			if (200 == $response->code) {
				$course = json_decode(json_encode($response->body));
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return false;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return $course;
	}

	public function getCourseGradebookColumnIdbyExternalId($access_token, $course_id, $external_id)
	{
		$result = "0";
		$coursegrade = new classes\Coursegrade();

		try {
			$response = \Httpful\Request::get(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_COURSE_PATH') . '/' . $course_id . '/gradebook/columns/externalId:' . $external_id)
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				->send();

			if (200 == $response->code) {
				$coursegrade = json_decode(json_encode($response->body));
				$result = $coursegrade->id;
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return false;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return $result;
	}

	public function getCourseGradebookColumns($access_token, $course_id)
	{
		$coursegrade = new classes\Coursegrade();

		try {
			$response = \Httpful\Request::get(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_COURSE_PATH') . '/' . $course_id . '/gradebook/columns')
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				->send();

			if (200 == $response->code) {
				$coursegrade = json_decode(json_encode($response->body));
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return false;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return $coursegrade;
	}

	public function createCourseGradebookColumn($access_token, $name, $course_id)
	{
		$coursegrade = new classes\Coursegrade();

		$coursegrade->name = $name;
		$coursegrade->score = new classes\Score();
		$coursegrade->description = 'Created by the Attendance App on ' . date("D M j Y G:i:s");
		$coursegrade->availability = new classes\Availability();

		try {
			$response = \Httpful\Request::post(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_COURSE_PATH') . '/' . $course_id . '/gradebook/columns')
				->body(json_encode($coursegrade))
				->addHeaders(['Content-Type' => 'application/json'])
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				->send();

			if (201 == $response->code) {
				#print "\n Create Course Gradebook Column...\n";
				$coursegrade = json_decode(json_encode($response->body));
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return false;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return $coursegrade;
	}

	public function getCourseGradebookColumnGrade($access_token, $course_id, $column_id, $user_id)
	{
		$coursegrade = new classes\Coursegrade();

		try {
			$response = \Httpful\Request::get(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_COURSE_PATH') . '/' . $course_id . '/gradebook/columns/' . $column_id . '/users/' . $user_id)
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				->send();

			if (200 == $response->code) {
				$coursegrade = json_decode(json_encode($response->body));
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return false;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return $coursegrade;
	}

	public function updateCourseGradebookColumnGrade($access_token, $course_id, $user_id, $column_id, $score)
	{
		$coursegradeentry = new classes\Coursegradeentry();

		$coursegradeentry->score = $score;
		$coursegradeentry->text = '1';
		$coursegradeentry->feedback = 'Added by the Attendance App on ' . date("D M j Y G:i:s");


		try {
			$response = \Httpful\Request::patch(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_COURSE_PATH') . '/' . $course_id . '/gradebook/columns/' . $column_id . '/users/' . $user_id)
				->body(json_encode($coursegradeentry))
				->addHeaders(['Content-Type' => 'application/json'])
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				->send();

			if (200 == $response->code) {
				#print "\n Update Course Gradebook User Grade...\n";
				$coursegradeentry = json_decode(json_encode($response->body));
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return false;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return $coursegradeentry;
	}

	public function updateCourse($access_token, $dsk_id, $course_id, $course_uuid, $course_created, $termId)
	{
		$course = new classes\Course();

		$course->id = $course_id;
		$course->uuid = $course_uuid;
		$course->created = $course_created;
		$course->dataSourceId = $dsk_id;
		$course->termId = $termId;


		try {
			$response = \Httpful\Request::patch(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_COURSE_PATH') . '/' . $course_id)
				->body(json_encode($course))
				->addHeaders(['Content-Type' => 'application/json'])
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				->send();

			if (200 == $response->code) {
				#print "\n Update Course...\n";
				$course = json_decode(json_encode($response->body));
			} else {
				return json_decode(json_encode($response->body));
				print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return false;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return $course;
	}

	public function deleteCourse($access_token, $course_id)
	{

		try {
			$response = \Httpful\Request::delete(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_COURSE_PATH') . '/' . $course_id)
				->addHeaders(['Content-Type' => 'application/json'])
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				->send();

			if (204 == $response->code) {
				print "Course Deleted";
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return FALSE;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return TRUE;
	}

	public function createUser($access_token, $dsk_id)
	{
		$user = new classes\User();

		$user->dataSourceId = $dsk_id;
		$user->availability = new classes\Availability();
		$user->name = new classes\Name();
		$user->contact = new classes\Contact();


		try {
			$response = \Httpful\Request::post(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_USER_PATH'))
				->body(json_encode($user))
				->addHeaders(['Content-Type' => 'application/json'])
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				->send();

			if (201 == $response->code) {
				//print "\n Create User...\n";
				$user = json_decode(json_encode($response->body));
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return false;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return $user;
	}

	public function readUser($access_token, $user_id)
	{
		$user = new classes\User();


		try {
			$response = \Httpful\Request::get(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_USER_PATH') . '/' . $user_id)
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				->send();

			if (200 == $response->code) {
				//print "\n Read User...\n";
				$user = json_decode(json_encode($response->body));
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return false;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return $user;
	}

	public function readUserCourses($access_token, $user_id)
	{
		$membership = new classes\Membership();


		try {
			$response = \Httpful\Request::get(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_USER_PATH') . '/userName:' . $user_id . '/courses')
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				->send();

			if (200 == $response->code) {
				//print "\n Read User Courses...\n";
				$membership = json_decode(json_encode($response->body));
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return false;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return $membership;
	}

	public function getUserIdbyNetid($access_token, $user_id)
	{
		$user = new classes\User();

		try {
			$response = \Httpful\Request::get(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_USER_PATH') . '/userName:' . $user_id)
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				->send();

			if (200 == $response->code) {
				$user = json_decode(json_encode($response->body));
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return false;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return $user;
	}

	public function updateUser($access_token, $dsk_id, $user_id, $user_uuid, $user_created)
	{
		$user = new classes\User();

		$user->id = $user_id;
		$user->uuid = $user_uuid;
		$user->created = $user_created;
		$user->dataSourceId = $dsk_id;

		try {
			$response = \Httpful\Request::patch(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_USER_PATH') . '/' . $user_id)
				->body(json_encode($user))
				->addHeaders(['Content-Type' => 'application/json'])
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				->send();

			if (200 == $response->code) {
				//print "\n Update User...\n";
				$user = json_decode(json_encode($response->body));
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return false;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return $user;
	}

	public function deleteUser($access_token, $user_id)
	{

		try {
			$response = \Httpful\Request::delete(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_USER_PATH') . '/' . $user_id)
				->addHeaders(['Content-Type' => 'application/json'])
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				->send();

			if (204 == $response->code) {
				print "User Deleted";
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return FALSE;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return TRUE;
	}


	public function createMembership($access_token, $dsk_id, $course_id, $user_id, $course_role)
	{
		$membership = new classes\Membership();

		$membership->dataSourceId = $dsk_id;
		$membership->availability = new classes\Availability();
		$membership->courseRoleId = $course_role;
		//$membership->userId = $user_id;
		//$membership->courseId = $course_id;

		//dump($membership);

		try {
			$response = \Httpful\Request::put(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_COURSE_PATH') . '/' . $course_id . '/users/' . $user_id)
				->addHeaders(['Content-Type' => 'application/json'])
				->addHeader('Authorization', "Bearer $access_token")
				->body(json_encode($membership))
				->expectsJson()
				->send();

	//dump($response);

			if (201 == $response->code) {
				//print "\n Create Membership...\n";
				$membership = json_decode(json_encode($response->body));
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return false;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return $membership;
	}

	public function readMembership($access_token, $course_id, $user_id)
	{
		$membership = new classes\Membership();


		try {
			$response = \Httpful\Request::get(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_COURSE_PATH') . '/' . $course_id . '/users/' . $user_id)
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				->send();

			if (200 == $response->code) {
				//print "\n Read Membership...\n";
				$membership = json_decode(json_encode($response->body));
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return false;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return $membership;
	}

	public function updateMembership($access_token, $dsk_id, $course_id, $user_id, $membership_created)
	{
		$membership = new classes\Membership();

		$membership->dataSourceId = $dsk_id;
		$membership->userId = $user_id;
		$membership->courseId = $course_id;
		$membership->created = $membership_created;

		try {
			$response = \Httpful\Request::patch(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_COURSE_PATH') . '/' . $course_id . '/users/' . $user_id)
				->body(json_encode($membership))
				->addHeaders(['Content-Type' => 'application/json'])
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				->send();

			if (200 == $response->code) {
				//print "\n Update Membership...\n";
				$membership = json_decode($response->getBody());
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return false;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return $membership;
	}

	public function deleteMembership($access_token, $course_id, $user_id)
	{

		try {
			$response = \Httpful\Request::delete(config('bbconfig.BB_HOSTNAME') . config('bbconfig.BB_COURSE_PATH') . '/' . $course_id . '/users/' . $user_id)
				->addHeaders(['Content-Type' => 'application/json'])
				->addHeader('Authorization', "Bearer $access_token")
				->expectsJson()
				->send();

			if (204 == $response->code) {
				print "Membership Deleted";
			} else {
				return json_decode(json_encode($response->body));
				// print 'Unexpected HTTP status: ' . $response->code;
				// $BbRestException = json_decode(json_encode($response->body));
				// var_dump($BbRestException);
				// return FALSE;
			}
		} catch (Exception $e) {
			return 'Error: ' . $e->getMessage();
		}

		return TRUE;
	}
}
