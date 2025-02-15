<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Login
Route::post('/login', [
    'as' => 'login.login',
    'uses' => 'Api\Auth\AuthController@login'
]);

Route::get('/debug-sentry', function () {
    throw new \RuntimeException('My first Sentry error!');
});

Route::post('/logout', [
    'as' => 'login.logout',
    'uses' => 'Api\Auth\AuthController@logout'
]);

Route::get('/refresh', [
    'as' => 'login.refresh',
    'uses' => 'Api\Auth\AuthController@refresh'
]);

Route::get('/helpers/offers', 'Api\LandingPageController@offers');

Route::resource('/users', 'Api\UserController');

Route::put('/users/activate/{activationToken}', 'Api\UserController@activateUser');

//For Logged Users
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::resource('/user_statuses', 'Api\UserStatusController');
    //Route::resource('/users', 'Api\UserController');
//    Route::resource('/cities', 'Api\CityController');
    Route::resource('/university-types', 'Api\UniversityTypeController');
    //Route::resource('/universities', 'Api\UniversityController');
    //Route::resource('/companies', 'Api\CompanyController');
    Route::resource('/specializations', 'Api\SpecializationController');
    Route::resource('/students', 'Api\StudentController');
    Route::resource('/user-universities', 'Api\UserUniversityController');
    Route::resource('/user-companies', 'Api\UserCompanyController');
    Route::resource('/offers/categories', 'Api\OfferCategoryController');
//    Route::resource('/offers', 'Api\OfferController');
    //Route::resource('/agreements', 'Api\AgreementController');
    //Route::resource('/internships', 'Api\InternshipController');
    Route::resource('/journals', 'Api\JournalController');
    Route::post('/university/generate-code', 'Api\UniversityController@setNewAccessCode');
    Route::post('/university/use-code', 'Api\UniversityController@useCode');
    Route::post('/company/generate-code', 'Api\CompanyController@setNewAccessCode');
    Route::post('/company/use-code', 'Api\CompanyController@useCode');
    Route::post('/journals/confirmMany', 'Api\JournalController@confirmMany');
    Route::get('/company/{id}/users', 'Api\CompanyController@getUsers');
    Route::get('/universities/{id}/users', 'Api\UniversityController@getUsers');
    //Route::get('/universities/{id}/agreements', 'Api\UniversityController@getUniversityAgreements');
    //Route::get('/universities/{id}/internships', 'Api\UniversityController@getInternships');
    //Route::get('/universities/{university_id}/students', 'Api\UniversityStudentController@index');
    //Route::get('/companies/{id}/offers', 'Api\CompanyController@getCompanyOffers');
    //Route::get('/companies/{id}/agreements', 'Api\CompanyController@getCompanyAgreements');
    Route::get('/companies/{id}/interns', 'Api\CompanyController@getInterns');
//    Route::post('/agreements/{id}/active', 'Api\AgreementController@active');
    Route::get('/internships/{id}/confirm', 'Api\InternshipController@confirm');
    Route::get('/user/internships', 'Api\UserController@getInternships');
    Route::get('/user/journals', 'Api\UserController@getJournals');
    Route::get('/user/interns', 'Api\UserController@getInterns');
    Route::get('/internships/{internship}/tasks', 'Api\TaskController@index');

    //NEW ENDPOINTS
    Route::post('/internships', 'Api\InternshipController@store');
    Route::get('/internships/statuses', 'Api\InternshipController@getInternshipStatuses');
    Route::get('/internships/{internship}','Api\InternshipController@show');
    Route::put('/internships/{internship}/summarize-internship','Api\InternshipController@summarizeInternship');
    Route::put('/internships/{id}/change-status','Api\InternshipController@changeInternshipStatus');
    Route::get('/internships/{internship}/students','Api\InternshipStudentController@index');
    Route::get('/internships/{internship}/students/{student}','Api\InternshipController@getInternshipStudent');
    Route::get('/internships/{internship}/students/{student}/download', 'Api\InternshipController@downloadInternshipJournal');
    Route::put('/internships/{internship}/students/{student}/set-grade','Api\InternshipController@setInternshipStudentGrade');
    Route::get('/internships/{internship}/students/{student}/journal-entries', 'Api\StudentJournalEntryController@index');
    Route::post('/internships/{internship}/students/{student}/journal-entries', 'Api\StudentJournalEntryController@createJournalEntry');
    Route::get('/internships/{internship}/students/{student}/journal-entries/{journalEntry}','Api\JournalController@show');
    Route::delete('/internships/{internship}/students/{student}/journal-entries/{studentJournalEntry}','Api\StudentJournalEntryController@deleteStudentJournalEntry');
    Route::put('/internships/{internship}/students/{student}/journal-entries/{studentJournalEntry}','Api\StudentJournalEntryController@updateStudentJournalEntry');
    Route::put('/internships/{internship}/students/{student}/journal-entries/{studentJournalEntry}/accept','Api\StudentJournalEntryController@acceptStudentJournalEntry');
    Route::post('/internships/{internship}/students/{student}/journal-entries/{studentJournalEntry}/comments','Api\StudentJournalEntryController@createJournalEntryComment');
    Route::get('/internships/{internship}/students/{student}/journal-entries/{studentJournalEntry}/comments','Api\StudentJournalEntryController@getStudentJournalEntryComments');
    Route::delete('/internships/{internship}/students/{student}/journal-entries/{studentJournalEntry}/comments/{comment}','Api\StudentJournalEntryController@deleteStudentJournalEntryComment');

    # Internship Task
    Route::post('/internships/{internship}/tasks', 'Api\TaskController@store');
    Route::get('/internships/{internship}/students/{student}/tasks', 'Api\StudentTaskController@getStudentTasks');
    Route::post('/internships/{internship}/students/{student}/tasks', 'Api\StudentJournalEntryController@createStudentTask');
    Route::delete('/internships/{internship}/students/{student}/tasks/{task}', 'Api\StudentJournalEntryController@deleteStudentTask');
    Route::put('/internships/{internship}/students/{student}/tasks/{task}/accept', 'Api\StudentJournalEntryController@acceptStudentTask');

    # New endpoints
    Route::get('/cities','Api\CityController@index');
    Route::get('/cities/{postcode?}','Api\CityController@showByPostcode');
    Route::post('/cities', 'Api\CityController@create');
    Route::put('/cities', 'Api\CityController@edit');
    Route::delete('/cities/{id}', 'Api\CityController@delete');

    # Companies
    Route::get('/companies', 'Api\CompanyController@index');
    Route::post('/companies','Api\CompanyController@createCompany');
    Route::get('/companies/categories', 'Api\CompanyCategoryController@index');
    Route::get('/companies/{slug}', 'Api\CompanyController@getCompany');
    Route::put('/companies/{slug}', 'Api\CompanyController@updateCompanyData');
    Route::get('/companies/{slug}/offers','Api\CompanyController@getCompanyOffers');
    Route::get('/companies/{slug}/workers','Api\CompanyController@getCompanyWorkers');
    Route::put('/companies/{slug}/workers/{userId}/reject','Api\CompanyController@deleteCompanyWorker');
    Route::post('/companies/{slug}/workers/{userId}','Api\CompanyController@addWorkerToCompany');
    Route::put('/companies/{slug}/workers/{userId}/change-roles','Api\CompanyController@changeCompanyWorkerRoles');
    Route::put('/companies/{slug}/workers/{userId}/accept','Api\CompanyController@acceptCompanyWorker');
    Route::put('/companies/{slug}/workers/{userId}/activate','Api\CompanyController@activateCompanyWorker');
    Route::put('/companies/{slug}/workers/{userId}/deactivate','Api\CompanyController@deactivateCompanyWorker');
    Route::get('/companies/{slug}/agreements','Api\CompanyController@getAgreements');
    Route::get('/companies/{slug}/questionnaires','Api\CompanyController@getCompanyQuestionnaires');
    Route::post('/companies/{slug}/questionnaires','Api\CompanyController@createCompanyQuestionnaire');
    Route::post('/companies/{slug}/settings/logo', 'Api\CompanyController@updateCompanyLogo');
    Route::get('/companies/{slug}/settings/generate-code', 'Api\CompanyController@setNewAccessCode');

    # Offers
    Route::get('/offers','Api\OfferController@index');
    Route::post('/offers', 'Api\OfferController@createOffer');
    Route::get('/offers/statuses', 'Api\OfferStatusController@index');
    Route::get('/offers/categories', 'Api\OfferCategoryController@index');
    Route::get('/offers/{slug}','Api\OfferController@show');
    Route::put('/offers/{slug}/accept','Api\OfferController@accept');
    Route::put('/offers/{slug}/reject','Api\OfferController@reject');

    # Agreements
    Route::post('/agreements', 'Api\AgreementController@createAgreement');
    Route::get('/agreements/{slug}', 'Api\AgreementController@show');
    Route::get('/agreements/{slug}/accept','Api\AgreementController@accept');
    Route::get('/agreements/{slug}/reject','Api\AgreementController@reject');
    Route::get('/agreements/{slug}/apply', 'Api\InternshipController@applyToInternship');
    Route::put('/agreements/{slug}/activate', 'Api\AgreementController@activateAgreement');
    Route::put('/agreements/{slug}/deactivate', 'Api\AgreementController@deactivateAgreement');
    Route::delete('/agreements/{slug}', 'Api\agreementController@deleteAgreement');

    # Universities
    Route::get('/universities', 'Api\UniversityController@getUniversities');
    Route::post('/universities', 'Api\UniversityController@createUniversity');
    Route::get('/universities/{slug}', 'Api\UniversityController@getUniversity');
    Route::put('/universities/{slug}', 'Api\UniversityController@updateUniversityData');
    Route::get('/universities/{slug}/offers', 'Api\UniversityController@getUniversityOffers');
    Route::get('/universities/{slug}/workers','Api\UniversityController@getWorkers');
    Route::post('/universities/{slug}/workers/{userId}','Api\UniversityController@addWorkerToUniversity');
    Route::put('/universities/{slug}/workers/{userId}/change-roles','Api\UniversityController@changeUniversityWorkerRoles');
    Route::put('/universities/{slug}/workers/{userId}/verify','Api\UniversityController@verifyUniversityWorker');
    Route::put('/universities/{slug}/workers/{userId}/reject','Api\UniversityController@rejectUniversityWorker');
    Route::put('/universities/{slug}/workers/{userId}/activate','Api\UniversityController@activateUniversityWorker');
    Route::put('/universities/{slug}/workers/{userId}/deactivate','Api\UniversityController@deactivateUniversityWorker');
    Route::get('/universities/{slug}/students','Api\UniversityController@getStudents');
    Route::post('/universities/{slug}/students/{userId}','Api\UniversityController@addStudentToUniversity');
    Route::post('/universities/{slug}/students/{userId}/verify','Api\UniversityController@verifyStudentInUniversity');
    Route::post('/universities/{slug}/students/{userId}/reject','Api\UniversityController@rejectStudentInUniversity');
    Route::get('/universities/{slug}/agreements','Api\UniversityController@getAgreements');
    Route::post('/universities/{slug}/agreements','Api\UniversityController@createOwnAgreement');
    Route::get('/universities/{slug}/internships','Api\UniversityController@getInternships2');
    Route::get('/universities/{slug}/faculties','Api\UniversityController@getFaculties');
    Route::post('/universities/{slug}/faculties','Api\UniversityController@createUniversityFaculty');
    Route::post('/universities/{slug}/faculties/{facultyId}/fields','Api\UniversityController@createUniversityFacultyField');
    Route::post('/universities/{slug}/faculties/{facultyId}/fields/{fieldId}/specializations','Api\UniversityController@createUniversityFacultyFieldSpecialization');
    Route::put('/universities/{slug}/faculties/{facultyId}','Api\UniversityController@updateUniversityFaculty');
    Route::put('/universities/{slug}/faculties/{facultyId}/fields/{fieldId}','Api\UniversityController@updateUniversityFacultyField');
    Route::put('/universities/{slug}/faculties/{facultyId}/fields/{fieldId}/specializations/{specializationId}','Api\UniversityController@updateUniversityFacultyFieldSpecialization');
    Route::delete('/universities/{slug}/faculties/{facultyId}','Api\UniversityController@deleteUniversityFaculty');
    Route::delete('/universities/{slug}/faculties/{facultyId}/fields/{fieldId}','Api\UniversityController@deleteUniversityFacultyField');
    Route::delete('/universities/{slug}/faculties/{facultyId}/fields/{fieldId}/specializations/{specializationId}','Api\UniversityController@deleteUniversityFacultyFieldSpecialization');
    Route::get('/universities/{slug}/offers','Api\UniversityController@getOffers');
    Route::get('/universities/{slug}/questionnaires','Api\UniversityController@getUniversityQuestionnaires');
    Route::post('/universities/{slug}/questionnaires','Api\UniversityController@createUniversityQuestionnaire');
    Route::post('/universities/{slug}/settings/logo', 'Api\UniversityController@updateUniversityLogo');

    # Student
    Route::post('/students/internships', 'Api\StudentController@createStudentOwnInternship');
    Route::post('/students/internships/{internshipId}/attachments', 'Api\StudentController@storeStudentInternshipAttachment');

    # Users
    Route::get('/users/{id}', 'Api\UserController@show');

    # Chat
    Route::post('/chats/', 'Api\ChatController@addUserToChat');
    Route::get('/chats/{uuid}', 'Api\ChatController@getChatMessages');
    Route::post('/chats/{uuid}', 'Api\ChatController@sendMessage');

    # User
    Route::get('/me/internships/{status?}', 'Api\UserController@getUserInternships');
    Route::get('/me/internships', 'Api\UserController@getUserInternships');
    Route::get('/me/universities', 'Api\UserUniversityController@index');
    Route::get('/me/universities/student', 'Api\StudentController@getStudentUniversities');
    Route::get('/me/companies', 'Api\UserCompanyController@index');
    Route::get('/me/notifications', 'Api\NotificationController@index');
    Route::get('/me/notifications/unread', 'Api\NotificationController@getUnreadNotifications');
    Route::put('/me/notifications/{uuid}', 'Api\NotificationController@markAsRead');
    Route::get('/me/offers','Api\StudentController@getAvailableInternshipOffers');
    Route::get('/me/messages', 'Api\UserMessageController@index');
    Route::get('/me/chats', 'Api\ChatController@getUserChats');
    Route::put('/me/personal-data', 'Api\UserController@updatePersonalData');
    Route::put('/me/password', 'Api\UserController@updatePassword');
    Route::post('/me/avatar', 'Api\UserController@updateAvatar');

    # Statistics
    Route::get('/statistics/offers/count','Api\StatisticController@getNumberOfOffers');
    Route::get('/statistics/offers/new/count/','Api\StatisticController@getNumberOfNewOffers');
    Route::get('/statistics/users/count','Api\StatisticController@getNumberOfUsers');
    Route::get('/statistics/agreements/count','Api\StatisticController@getNumberOfAgreements');
    Route::get('/statistics/universities/count','Api\StatisticController@getNumberOfUniversities');
    Route::get('/statistics/companies/count','Api\StatisticController@getNumberOfCompanies');
    Route::get('/statistics/attachments/count','Api\StatisticController@getNumberOfAttachments');
    Route::get('/statistics/offers/attachments/count','Api\StatisticController@getNumberOfOffersAttachments');

    # Questionnaires
    Route::get('/questionnaires','Api\QuestionnaireController@getQuestionnaires');
    Route::get('/questionnaires/{questionnaireId}','Api\QuestionnaireController@getQuestionnaire');
    Route::put('/questionnaires/{questionnaireId}','Api\QuestionnaireController@updateQuestionnaire');
    Route::get('/questionnaires/{questionnaireId}/questions','Api\QuestionnaireController@getQuestionnaireQuestions');
    Route::post('/questionnaires/{questionnaireId}/questions','Api\QuestionnaireController@modifyQuestionnaireQuestions');
    Route::get('/questionnaires/{questionnaireId}/answers','Api\QuestionnaireController@getQuestionnaireAnswers');
    Route::post('/questionnaires/{questionnaireId}/answers','Api\QuestionnaireController@addQuestionnaireAnswers');
    Route::get('/questionnaires/{questionnaireId}/questions/{questionId}','Api\QuestionnaireController@getQuestionnaireQuestion');
    Route::get('/questionnaires/{questionnaireId}/questions/{questionId}/answers','Api\QuestionnaireController@getQuestionnaireQuestionAnswers');
    Route::get('/questionnaires/{questionnaireId}/questions/{questionId}/answers/{answerId}','Api\QuestionnaireController@getQuestionnaireQuestionAnswer');
    Route::get('/questionnaires/{id}/statistics/weeks','Api\QuestionnaireController@getQuestionnaireAnswerStatisticsByWeek');

    Route::get('/faculties', 'Api\FacultyController@getFaculties');

    Route::get('/roles', 'Api\RoleController@getAvailableRolesByGroups');

    Route::get('/test', 'Api\TestController@test');
    Route::post('/test', 'Api\TestController@testPost');

    # Admin
    Route::get('/admin/universities/verified', 'Api\UniversityController@getAllVerifiedUniversities');
    Route::get('/admin/universities/unverified', 'Api\UniversityController@getUniversitiesToVerification');
    Route::post('/admin/universities/{slug}/verify', 'Api\UniversityController@verifyUniversity');
    Route::post('/admin/universities/{slug}/reject', 'Api\UniversityController@rejectUniversity');
    Route::get('/admin/companies/verified', 'Api\CompanyController@getAllVerifiedCompanies');
    Route::get('/admin/companies/unverified', 'Api\CompanyController@getCompaniesToVerification');
    Route::post('/admin/companies/{slug}/verify', 'Api\CompanyController@verifyCompany');
    Route::post('/admin/companies/{slug}/reject', 'Api\CompanyController@rejectCompany');

    Route::get('/attachments/{path}', 'Api\AttachmentController@downloadAttachment');


    Route::get('/me', [
        'as' => 'login.me',
        'uses' => 'Api\Auth\AuthController@me'
    ]);
});

Route::post('/forgot-password', 'Api\Auth\AuthController@forgotPassword');
Route::post('/reset-password', 'Api\UserController@resetPassword');

//For not logged in users
Route::get('/specializations', 'Api\SpecializationController@index');
Route::get('/university/{id}/faculties', 'Api\UniversityController@universityFaculties');
Route::get('/faculty/{id}/fields', 'Api\FacultyController@facultyFields');
Route::get('/field/{id}/specializations', 'Api\FieldController@fieldSpecializations');
Route::post('/students', 'Api\StudentController@store');
