<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\TownController;
use App\Http\Controllers\StatusHistoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AssetTypeController;
use App\Http\Controllers\SlotTypeController;
use App\Http\Controllers\AdvertController;
use App\Http\Controllers\DayController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\FrequencyController;
use App\Http\Controllers\OccurenceController;
use App\Http\Controllers\InstitutionTypeController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserActivityController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\InstitutionAccessController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\ValidAssetTypeController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PaymentPreferenceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ServiceCoverageController;
use App\Http\Controllers\SlotCoverageController;
use App\Http\Controllers\TransactionTypeController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\VerificationTypeController;
use App\Http\Controllers\PlanTypeController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\RepeatedAdvertController;
use App\Http\Controllers\FeedbackController; 

//Mailing
use App\Http\Controllers\MailController;
use App\Http\Controllers\EmailVerificationController;

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

Route::middleware(['cors'])->group(function () {

  //without authentication 
  Route::get('/', [UserController::class,'root'])->name('root');
  Route::post('login', [UserController::class,'login']);
  Route::post('signup', [UserController::class,'signup']);

  Route::post('forgot-password', [UserController::class, 'forgotPassword']);
  Route::post('reset-password', [UserController::class, 'reset']);

  //services 
  Route::get('services',[ServiceController::class, 'getServices']);
  Route::get('services/{id}',[ServiceController::class, 'getService']);

  //slots 
  Route::get('slots',[SlotController::class, 'getSlots']);
  Route::get('slots/{id}',[SlotController::class, 'getSlot']);

  //categories 
  Route::get('categories',[CategoryController::class, 'getCategories']);
  Route::get('categories/{id}',[CategoryController::class, 'getCategory']);

  //tags 
  Route::get('tags',[TagController::class, 'getTags']);
  Route::get('tags/{id}',[TagController::class, 'getTag']);

  //institutions 
  Route::get('institutions',[InstitutionController::class, 'getInstitutions']);
  Route::get('institutions/{id}',[InstitutionController::class, 'getInstitution']);

  //subscribers 
  Route::post('subscribers',[SubscriberController::class,'addSubscriber']);

  //feedbacks 
  Route::post('feedbacks',[FeedbackController::class,'addFeedback']);

  Route::middleware(['auth:sanctum'])->group(function () {   
    Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail']);
    Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
  }); 

  Route::middleware(['auth:sanctum', 'verified'])->group(function () {   
 
    //general for all logged in users.

    Route::post('logout', [UserController::class, 'logout']);

    //settings
    Route::post('users/update',[UserController::class,'updateUser']);
    Route::get('users/{id}',[UserController::class, 'getUser']);

    //statuses
    Route::get('statuses',[StatusController::class, 'getStatuses']);
    Route::get('statuses/{id}',[StatusController::class, 'getStatus']);

    //statuses
    Route::get('stathis',[StatusHistoryController::class, 'getStatusHistories']); 
    Route::get('stathis/{id}',[StatusHistoryController::class, 'getStatusHistory']);  
    Route::post('stathis',[StatusHistoryController::class,'addStatusHistory']);

    //chats
    Route::get('chats',[ChatController::class, 'getChats']);
    Route::get('chats/{id}',[ChatController::class, 'getChat']);
    Route::post('chats',[ChatController::class,'addChat']);
    Route::put('chats/read/{id}',[ChatController::class,'markAsRead']);
    Route::put('chats/uread/{id}',[ChatController::class,'markAsUnRead']);
    Route::delete('chats/{id}',[ChatController::class,'deleteChat']);

    //notifications
    Route::get('notifications',[NotificationController::class, 'getNotifications']);
    Route::get('notifications/{id}',[NotificationController::class, 'getNotification']);
    Route::post('notifications',[NotificationController::class,'addNotification']);
    Route::put('notifications/read/{id}',[NotificationController::class,'markAsRead']);
    Route::put('notifications/uread/{id}',[NotificationController::class,'markAsUnRead']);
    Route::delete('notifications/{id}',[NotificationController::class,'deleteNotification']);

    //followers
    Route::get('followers',[FollowerController::class, 'getFollowers']);
    Route::get('followers/{id}',[FollowerController::class, 'getFollower']);
    Route::post('followers',[FollowerController::class,'addFollower']);

    //ratings
    Route::get('ratings',[RatingController::class, 'getRatings']);
    Route::get('ratings/{id}',[RatingController::class, 'getRating']);
    Route::post('ratings',[RatingController::class,'addRating']);

    //adverts
    Route::get('adverts',[AdvertController::class, 'getAdverts']); 
    Route::get('adverts/{id}',[AdvertController::class, 'getAdvert']);  
    Route::post('adverts',[AdvertController::class,'addAdvert']);
    Route::post('adverts/{id}',[AdvertController::class,'updateAdvert']);
    Route::delete('adverts/{id}',[AdvertController::class,'deleteAdvert']);

    //repeated adverts
    Route::get('repeatedadverts',[RepeatedAdvertController::class, 'getRepeatedAdverts']); 
    Route::get('repeatedadverts/{id}',[RepeatedAdvertController::class, 'getRepeatedAdvert']);  
    Route::post('repeatedadverts',[RepeatedAdvertController::class,'addRepeatedAdvert']);

    //asset types
    Route::get('assettypes',[AssetTypeController::class, 'getAssetTypes']);
    Route::get('assettypes/{id}',[AssetTypeController::class, 'getAssetType']);

    //user activity
    Route::post('activity',[UserActivityController::class, 'addUserActivity']);

    //colors
    Route::get('colors',[ColorController::class, 'getColors']);
    Route::get('colors/{id}',[ColorController::class, 'getColor']);

    //labels
    Route::get('labels',[LabelController::class, 'getLabels']);
    Route::get('labels/{id}',[LabelController::class, 'getLabel']);

    //countries
    Route::get('countries',[CountryController::class, 'getCountries']);
    Route::get('countries/{id}',[CountryController::class, 'getCountry']);

    //regions
    Route::get('regions',[RegionController::class, 'getRegions']);
    Route::get('regions/{id}',[RegionController::class, 'getRegion']);

    //cities
    Route::get('cities',[CityController::class, 'getCities']);
    Route::get('cities/{id}',[CityController::class, 'getCity']);

    //towns
    Route::get('towns',[TownController::class, 'getTowns']);
    Route::get('towns/{id}',[TownController::class, 'getTown']);

    //days
    Route::get('days',[DayController::class, 'getDays']);
    Route::get('days/{id}',[DayController::class, 'getDay']);

    //subscriptions
    Route::get('subscriptions/{id}',[SubscriptionController::class, 'getSubscription']);
    Route::post('subscriptions',[SubscriptionController::class,'addSubscription']);

    //transactions
    Route::post('transactions',[TransactionController::class,'addTransaction']);
    Route::get('transactions/{id}',[TransactionController::class, 'getTransaction']);

    //frequencies
    Route::get('frequencies',[FrequencyController::class, 'getFrequencies']);
    Route::get('frequencies/{id}',[FrequencyController::class, 'getFrequency']);

    //units
    Route::get('units',[UnitController::class, 'getUnits']);
    Route::get('units/{id}',[UnitController::class, 'getUnit']);

    //user activity
    Route::post('activity',[UserActivityController::class, 'addUserActivity']);

    //plans
    Route::get('plans',[PlanController::class, 'getPlans']);
    Route::get('plans/{id}',[PlanController::class, 'getPlans']);

    //service coverages
    Route::get('servicecovs',[ServiceCoverageController::class, 'getServiceCoverages']);
    Route::get('servicecovs/{id}',[ServiceCoverageController::class, 'getServiceCoverage']);

    //slot coverages
    Route::get('slotcovs',[SlotCoverageController::class, 'getSloteCoverages']);
    Route::get('slotcovs/{id}',[SlotCoverageController::class, 'getSloteCoverage']);


    //payment methods
    Route::get('paymentmethods',[PaymentMethodController::class, 'getPaymentMethods']);
    Route::get('paymentmethods/{id}',[PaymentMethodController::class, 'getPaymentMethod']);

    //payment preferences
    Route::get('paymentprefs',[PaymentPreferenceController::class, 'getPaymentPreferences']);
    Route::get('paymentprefs/{id}',[PaymentPreferenceController::class, 'getPaymentPreference']);

    //verification
    Route::post('verifications',[VerificationController::class,'addVerification']);


    //END GENERAL 


    //admin-manager
    Route::middleware('role:admin-manager')->group(function () {   
    
    
    });

    //manager
    Route::middleware('role:manager')->group(function () {   

        //slot types
        Route::get('slottypes',[SlotTypeController::class, 'getSlotTypes']);
        Route::get('slottypes/{id}',[SlotTypeController::class, 'getSlotType']);
        Route::post('slottypes',[SlotTypeController::class,'addSlotType']);
        Route::put('slottypes/{id}',[SlotTypeController::class,'updateSlotType']);
        Route::delete('slottypes/{id}',[SlotTypeController::class,'deleteSlotType']);

        //sizes
        Route::get('sizes',[SizeController::class, 'getSizes']);
        Route::get('sizes/{id}',[SizeController::class, 'getSize']);
        Route::post('sizes',[SizeController::class,'addSize']);
        Route::put('sizes/{id}',[SizeController::class,'updateSize']);
        Route::delete('sizes/{id}',[SizeController::class,'deleteSize']);

        //occurences
        Route::get('occurences',[SizeController::class, 'getOccurences']);
        Route::get('occurences/{id}',[SizeController::class, 'getOccurence']);
        Route::post('occurences',[SizeController::class,'addOccurence']);
        Route::put('occurences/{id}',[SizeController::class,'updateOccurence']);
        Route::delete('occurences/{id}',[SizeController::class,'deleteOccurence']);

        //institytion types
        Route::get('institutiontypes',[InstitutionTypeController::class, 'getInstitutionTypes']);
        Route::get('institutiontypes/{id}',[InstitutionTypeController::class, 'getInstitutionType']);

        //institytion types
        Route::get('institutionaccesses',[InstitutionAccessController::class, 'getInstitutionAccesses']);
        Route::get('institutionaccesses/{id}',[InstitutionAccessController::class, 'getInstitutionAccess']);
 
        //plans
        Route::post('plans',[PlanController::class,'addPlan']);
        Route::put('plans/{id}',[PlanController::class,'updatePlan']);
        Route::delete('plans/{id}',[PlanController::class,'deletePlan']);

        //plan types
        Route::get('plantypes',[PlanTypeController::class, 'getPlanTypes']);
        Route::get('plantypes/{id}',[PlanTypeController::class, 'getPlanType']);

        //service coverages
        Route::post('servicecovs',[ServiceCoverageController::class,'addServiceCoverage']);
        Route::put('servicecovs/{id}',[ServiceCoverageController::class,'updateServiceCoverage']);
        Route::delete('servicecovs/{id}',[ServiceCoverageController::class,'deleteServiceCoverage']);

        //slot coverages
        Route::post('slotcovs',[SlotCoverageController::class,'addSlotCoverage']);
        Route::put('slotcovs/{id}',[SlotCoverageController::class,'updateSlotCoverage']);
        Route::delete('slotcovs/{id}',[SlotCoverageController::class,'deleteSlotCoverage']);

        //valid asset types
        Route::get('vassettypes',[ValidAssetTypeController::class, 'getValidAssetTypes']);
        Route::get('vassettypes/{id}',[ValidAssetTypeController::class, 'getValidAssetType']);
        Route::post('vassettypes',[ValidAssetTypeController::class,'addValidAssetType']);
        Route::put('vassettypes/{id}',[ValidAssetTypeController::class,'updateValidAssetType']);
        Route::delete('vassettypes/{id}',[ValidAssetTypeController::class,'deleteValidAssetType']);

        // repeated adverts
        Route::put('repeatedadverts/{id}',[RepeatedAdvertController::class,'updateRepeatedAdvert']);
        Route::delete('repeatedadverts/{id}',[RepeatedAdvertController::class,'deleteRepeatedAdvert']);
        
    
    });

    //admin
    Route::middleware('role:admin')->group(function () {   
      Route::post('send-mail', [MailController::class, 'sendMail']);

      //users
      Route::get('users',[UserController::class, 'getUsers']);
      Route::post('users/ban/{id}',[UserController::class,'banUser']);
      Route::post('users/activate/{id}',[UserController::class,'activateUser']);
      Route::post('users/markdel/{id}',[UserController::class,'markUserDeletion']);
      Route::delete('users/{id}',[UserController::class,'deleteUser']);

      //tags
      Route::post('tags',[TagController::class,'addTag']);
      Route::put('tags/{id}',[TagController::class,'updateTag']);
      Route::delete('tags/{id}',[TagController::class,'deleteTag']);

      //categories
      Route::post('categories',[CategoryController::class,'addCategory']);
      Route::post('categories/{id}',[CategoryController::class,'updateCategory']);
      Route::delete('categories/{id}',[CategoryController::class,'deleteCategory']);

      //institutions
      Route::post('institutions',[InstitutionController::class,'addInstitution']);
      Route::post('institutions/{id}',[InstitutionController::class,'updateInstitution']);
      Route::delete('institutions/{id}',[InstitutionController::class,'deleteInstitution']);

      //services
      Route::post('services',[ServiceController::class,'addService']);
      Route::post('services/{id}',[ServiceController::class,'updateService']);
      Route::post('services/susp/{id}',[ServiceController::class,'suspendService']);
      Route::delete('services/{id}',[ServiceController::class,'deleteService']);

      //slots
      Route::post('slots',[SlotController::class,'addSlot']);
      Route::post('slots/{id}',[SlotController::class,'updateSlot']);
      Route::post('slots/susp/{id}',[SlotController::class,'suspendSlot']);
      Route::delete('slots/{id}',[SlotController::class,'deleteSlot']);

      //statuses
      Route::post('statuses',[StatusController::class,'addStatus']);
      Route::put('statuses/{id}',[StatusController::class,'updateStatus']);
      Route::delete('statuses/{id}',[StatusController::class,'deleteStatus']);

      //subscribers
      Route::get('subscribers',[SubscriberController::class, 'getSubscribers']);
      Route::get('subscribers/{id}',[SubscriberController::class, 'getSubscriber']);
      Route::delete('subscribers/{id}',[SubscriberController::class,'deleteSubscriber']);

      //tags
      Route::post('assettypes',[AssetTypeController::class,'addAssetType']);
      Route::put('assettypes/{id}',[AssetTypeController::class,'updateAssetType']);
      Route::delete('assettypes/{id}',[AssetTypeController::class,'deleteAssetType']);

      //colors
      Route::post('colors',[ColorController::class,'addColor']);
      Route::put('colors/{id}',[ColorController::class,'updateColor']);
      Route::delete('colors/{id}',[ColorController::class,'deleteColor']);

      //labels
      Route::post('labels',[LabelController::class,'addLabel']);
      Route::put('labels/{id}',[LabelController::class,'updateLabel']);
      Route::delete('labels/{id}',[LabelController::class,'deleteLabel']);

      //days
      Route::post('days',[DayController::class,'addDay']);
      Route::put('days/{id}',[DayController::class,'updateDay']);
      Route::delete('days/{id}',[DayController::class,'deleteDay']);

      //roles
      Route::get('roles',[RoleController::class, 'getRoles']);
      Route::get('roles/{id}',[RoleController::class, 'getRole']);
      Route::post('roles',[RoleController::class,'addRole']);
      Route::put('roles/{id}',[RoleController::class,'updateRole']);
      Route::delete('roles/{id}',[RoleController::class,'deleteRole']);


      //payment methods
      Route::post('paymentmethods',[PaymentMethodController::class,'addPaymentMethod']);
      Route::put('paymentmethods/{id}',[PaymentMethodController::class,'updatePaymentMethod']);
      Route::delete('paymentmethods/{id}',[PaymentMethodController::class,'deletePaymentMethod']);


      //payment preferences
      Route::post('paymentprefs',[PaymentPreferenceController::class,'addPaymentPreference']);
      Route::put('paymentprefs/{id}',[PaymentPreferenceController::class,'updatePaymentPreference']);
      Route::delete('paymentprefs/{id}',[PaymentPreferenceController::class,'deletePaymentPreference']);

      //subscriptions
      Route::get('subscriptions',[SubscriptionController::class, 'getSubscriptions']);
      Route::put('subscriptions/{id}',[SubscriptionController::class,'updateSubscription']);
      Route::delete('subscriptions/{id}',[SubscriptionController::class,'deleteSubscription']);

      //transactions
      Route::get('transactions',[TransactionController::class, 'getTransactions']);
      Route::get('transactions/{id}',[TransactionController::class, 'getTransaction']);

      //transactiontypes
      Route::get('transactiontypes',[TransactionTypeController::class, 'getTransactionTypes']);
      Route::get('transactiontypes/{id}',[TransactionTypeController::class, 'getTransactionType']);
      Route::post('transactiontypes',[TransactionTypeController::class,'addTransactionType']);
      Route::put('transactiontypes/{id}',[TransactionTypeController::class,'updateTransactionType']);
      Route::delete('transactiontypes/{id}',[TransactionTypeController::class,'deleteTransactionType']);

      //countries
      Route::post('countries',[CountryController::class,'addCountry']);
      Route::put('countries/{id}',[CountryController::class,'updateCountry']);
      Route::delete('countries/{id}',[CountryController::class,'deleteCountry']);

      //regions
      Route::post('regions',[RegionController::class,'addRegion']);
      Route::put('regions/{id}',[RegionController::class,'updateRegion']);
      Route::delete('regions/{id}',[RegionController::class,'deleteRegion']);

      //cities
      Route::post('cities',[CityController::class,'addCity']);
      Route::put('cities/{id}',[CityController::class,'updateCity']);
      Route::delete('cities/{id}',[CityController::class,'deleteCity']);

      //towns
      Route::post('towns',[TownController::class,'addTown']);
      Route::put('towns/{id}',[TownController::class,'updateTown']);
      Route::delete('towns/{id}',[TownController::class,'deleteTown']);

      //followers
      Route::delete('followers/{id}',[FollowerController::class,'deleteFollower']);

      //ratings
      Route::delete('ratings/{id}',[RatingController::class,'deleteRating']);

      //frequencies
      Route::post('frequencies',[FrequencyController::class,'addFrequency']);
      Route::put('frequencies/{id}',[FrequencyController::class,'updateFrequency']);
      Route::delete('frequencies/{id}',[FrequencyController::class,'deleteFrequency']);

      //institution types
      Route::post('institutiontypes',[InstitutionTypeController::class,'addInstitutionType']);
      Route::put('institutiontypes/{id}',[InstitutionTypeController::class,'updateInstitutionType']);
      Route::delete('institutiontypes/{id}',[InstitutionTypeController::class,'deleteInstitutionType']);

      //institution accesses
      Route::post('institutionaccesses',[InstitutionAccessController::class,'addInstitutionAccess']);
      Route::put('institutionaccesses/{id}',[InstitutionAccessController::class,'updateInstitutionAccess']);
      Route::delete('institutionaccesses/{id}',[InstitutionAccessController::class,'deleteInstitutionAccess']);

      //units
      Route::post('units',[UnitController::class,'addUnit']);
      Route::put('units/{id}',[UnitController::class,'updateUnit']);
      Route::delete('units/{id}',[UnitController::class,'deleteUnit']);

      //user activities
      Route::get('activity',[UserActivityController::class, 'getUserActivities']);
      Route::get('activity/{id}',[UserActivityController::class, 'getUserActivity']);

      //verification types
      Route::get('verificationtypes',[VerificationTypeController::class, 'getVerificationTypes']);
      Route::get('verificationtypes/{id}',[VerificationTypeController::class, 'getVerificationType']);
      Route::post('verificationtypes',[VerificationTypeController::class, 'addVerificationType']);
      Route::put('verificationtypes/{id}',[VerificationTypeController::class,'updateVerificationType']);
      Route::delete('verificationtypes/{id}',[VerificationTypeController::class,'deleteVerificationType']);

      //verifications
      Route::get('verifications',[VerificationController::class, 'getVerifications']);
      Route::get('verifications/{id}',[VerificationController::class, 'getVerification']);
      Route::post('verifications',[VerificationController::class,'addVerification']);
      Route::put('verifications/{id}',[VerificationController::class,'updateVerification']);
      Route::delete('verifications/{id}',[VerificationController::class,'deleteVerification']);

      //plan types
      Route::post('plantypes',[PlanTypeController::class,'addPlanType']);
      Route::put('plantypes/{id}',[PlanTypeController::class,'updatePlanType']);
      Route::delete('plantypes/{id}',[PlanTypeController::class,'deletePlanType']);

      //user roles
      Route::get('userroles',[UserRoleController::class, 'getUserRoles']);
      Route::get('userroles/{id}',[UserRoleController::class, 'getUserRole']);
      Route::post('userroles',[UserRoleController::class,'addUserRole']);
      Route::put('userroles/{id}',[UserRoleController::class,'updateUserRole']);
      Route::delete('userroles/{id}',[UserRoleController::class,'deleteUserRole']);

       //feedback
       Route::get('feedback',[FeedbackController::class, 'getAllFeedback']);
       Route::get('feedback/{id}',[FeedbackController::class, 'getFeedback']);
       Route::delete('feedback/{id}',[FeedbackController::class,'deleteFeedback']);
 

    });

  
  });

});
 

