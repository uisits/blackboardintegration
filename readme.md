Installation:  
composer require uisits/blackboardintegration  

Usage:  
1. use uisits\blackboardintegration\Http\controllers\BlackboardintegrationController as bb;  
2. $bbinteract = new bb();  
3. Call the method that you need  

Example:   
$classid = "123456";   
$token = ($bb->token_authorize())->access_token;  
$courseid = ($bb->getCourseIdbyCourseId($token, $classid))->id;  
$course = $bb->readCourse($token, $courseid);  

Available Methods:  
- token_authorize(): creates and returns the token object
- createDatasource($access_token): Creates and returns a new datasource 
- readDatasource($access_token, $dsk_id): Gets and returns a datasource with id of $dsk_id
- updateDatasource($access_token, $dsk_id): Updates and returns a datasource with id of $dsk_id
- deleteDatasource($access_token, $dsk_id): Deletes datasource with id of $dsk_id and returns True or False depending on success
- createTerm($access_token, $dsk_id): Creates and returns a new Blackboard Term on datasource with id of $dsk_id
- readTerm($access_token, $term_id): Gets and returns a Term with an id of $term_id
- updateTerm($access_token, $dsk_id, $term_id): Updates Term with a disk id of $dsk_id and term id of $term_id
- deleteTerm($access_token, $term_id): Deletes Term with an id of $term_id
- createCourse($access_token, $dsk_id, $term_id): Creates and returns a new course 
- readCourse($access_token, $course_id): Gets and returns a course with id of $course_id
- getCourseIdbyCourseId($access_token, $course_id): Gets and returns the course that has the external id of $course_id
- getCourseGradebookColumnIdbyExternalId($access_token, $course_id, $external_id): Gets and returns a gradebook column with the external id of $external_id from the course of $course_id
- getCourseGradebookColumns($access_token, $course_id): Gets and returns a collection of all of the gradebook columns for a course with course id of $course_id
- createCourseGradebookColumn($access_token, $name, $course_id): Creates and returns a gradebook column called $name for the course with an id of $course_id
- getCourseGradebookColumnGrade($access_token, $course_id, $column_id, $user_id): Gets and returns the grade object for the student of $user_id in the gradebook column with id of $column_id in the course with $course_id
- updateCourseGradebookColumnGrade($access_token, $course_id, $user_id, $column_id, $score): Updates and returns a grade with a value of $score for the student of $user_id in the gradebook column with id of $column_id in the course with $course_id
- updateCourse($access_token, $dsk_id, $course_id, $course_uuid, $course_created, $termId): Updates Course values of $dsk_id, $course_uuid, $course_created, and $termId where the course id is $course_id
- deleteCourse($access_token, $course_id): Deletes Course with an id of $course_id and returns True or False depending on success
- createUser($access_token, $dsk_id): Creates and returns a user created on the datasource with id of $dsk_id
- readUser($access_token, $user_id): Gets and returns a user with an id of $user_id
- readUserCourses($access_token, $user_id): Gets and returns a collection of courses associated with the user with an id of $user_id
- getUserIdbyNetid($access_token, $user_id): Gets and returns the user object that has a netid of $user_id
- updateUser($access_token, $dsk_id, $user_id, $user_uuid, $user_created): Updates and returns a user with the values of $dsk_id, $user_uuid, and $user_created for a user with an id of $user_id
- deleteUser($access_token, $user_id): Deletes a user with an id of $user_id and returns True or False depending on success
- createMembership($access_token, $dsk_id, $course_id, $user_id): Creates and returns a membership for a user with id of $user_id in course with an id of $course_id
- readMembership($access_token, $course_id, $user_id): Gets and returns a membership for a user with id of $user_id for the course with $course_id
- updateMembership($access_token, $dsk_id, $course_id, $user_id, $membership_created): Updates and returns a membership with values of $membership_created and $dsk_id for user with $user_id in course with $course_id
- deleteMembership($access_token, $course_id, $user_id): Deletes a membership for a user with $user_id and course with $course_id and returns True or False depending on success

Resources:  
Blackboard API: https://developer.blackboard.com/portal/displayApi