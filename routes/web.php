<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {

    //Project
    $router->get('/GetDataProject', ['uses' => 'ProjectController@index']);
    $router->get('/DataProjectByid/{id}', ['uses' => 'ProjectController@show']);
    $router->post('/InsertDataProject', ['uses' => 'ProjectController@create']);
    $router->delete('/DeleteDataProject/{id}', ['uses' => 'ProjectController@destroy']);
    $router->post('/UpdateDataProject/{id}', ['uses' => 'ProjectController@update']);
    $router->post('/UpdateDataProjectSetDefault/{id}', ['uses' => 'ProjectController@updateSetDefault']);
    $router->get('/GetDataProjectSetDefault', ['uses' => 'ProjectController@GetProjectsetDefault']);
    $router->get('/getLastProjectID', ['uses' => 'ProjectController@getLastProjectID']);

    //Bussiness Type
    $router->get('/DataBussinessType', ['uses' => 'BussinessTypeController@index']);
    $router->post('/InsertDataBussinessType', ['uses' => 'BussinessTypeController@create']);
    $router->get('/DataBussinessTypeByid/{id}', ['uses' => 'BussinessTypeController@show']);
    $router->delete('/DeleteDataBussinessType/{id}', ['uses' => 'BussinessTypeController@destroy']);
    $router->post('/UpdateDataBussinessType/{id}', ['uses' => 'BussinessTypeController@update']);
    $router->get('/DataBussinessTypeby/{type}', ['uses' => 'BussinessTypeController@bytype']);

    //Country
    $router->get('/DataCountry', ['uses' => 'CountryController@index']);
    $router->post('/InsertDataCountry', ['uses' => 'CountryController@create']);
    $router->get('/DataCountryByid/{id}', ['uses' => 'CountryController@show']);
    $router->get('/DataLastInput', ['uses' => 'CountryController@showLastInput']);
    $router->delete('/DeleteDataCountry/{id}', ['uses' => 'CountryController@destroy']);
    $router->post('/UpdateCountry/{id}', ['uses' => 'CountryController@update']);

    //Position
    $router->get('/DataPosition', ['uses' => 'PositionController@index']);
    $router->post('/InsertDataPosition', ['uses' => 'PositionController@create']);
    $router->get('/DataPositionByid/{id}', ['uses' => 'PositionController@show']);
    $router->delete('/DeleteDataPosition/{id}', ['uses' => 'PositionController@destroy']);
    $router->post('/UpdatePosition/{id}', ['uses' => 'PositionController@update']);
    $router->get('/DataPositionbyPersonil/{PersonilID}', ['uses' => 'PositionController@PositionbyPersonil']);


    //Position Category
    $router->get('/DataPositionCategory', ['uses' => 'PositionCategoryController@index']);
    $router->post('/InsertDataPositionCategory', ['uses' => 'PositionCategoryController@create']);
    $router->get('/DataPositionCategoryByid/{id}', ['uses' => 'PositionCategoryController@show']);
    $router->delete('/DeleteDataPositionCategory/{id}', ['uses' => 'PositionCategoryController@destroy']);
    $router->post('/UpdatePositionCategory/{id}', ['uses' => 'PositionCategoryController@update']);

    //City
    $router->get('/DataCity', ['uses' => 'CityController@index']);
    $router->post('/InsertDataCity', ['uses' => 'CityController@create']);
    $router->get('/DataCityByid/{id}', ['uses' => 'CityController@show']);
    $router->get('/DataCityByCountryId/{id}', ['uses' => 'CityController@DataCityByCountryId']);
    $router->delete('/DeleteDataCity/{id}', ['uses' => 'CityController@destroy']);
    $router->post('/UpdateCity/{id}', ['uses' => 'CityController@update']);

    //BussinessPartner
    $router->get('/DataBusinessPartner', ['uses' => 'BussinessPartnerController@index']);
    $router->post('/InsertDataBusinessPartner', ['uses' => 'BussinessPartnerController@create']);
    $router->get('/DataBusinessPartnerByid/{id}', ['uses' => 'BussinessPartnerController@show']);
    $router->delete('/DeleteDataBusinessPartner/{id}', ['uses' => 'BussinessPartnerController@destroy']);
    $router->post('/UpdateDataBusinessPartner/{id}', ['uses' => 'BussinessPartnerController@update']);
    $router->get('/DataBusinessPartnerByType/{type}', ['uses' => 'BussinessPartnerController@Partnerbytype']);
    $router->get('/DataContractor/{id}', ['uses' => 'BussinessPartnerController@DataContractor']);


    //Personil
    $router->get('/DataPersonil', ['uses' => 'PersonilController@index']);
    $router->post('/InsertDataPersonil', ['uses' => 'PersonilController@create']);
    $router->get('/DataPersonilByid/{id}', ['uses' => 'PersonilController@show']);
    $router->delete('/DeleteDataPersonil/{id}', ['uses' => 'PersonilController@destroy']);
    $router->post('/UpdateDataPersonil/{id}', ['uses' => 'PersonilController@update']);
    $router->get('/DataPersonilbyPosition/{PositionID}', ['uses' => 'PersonilController@PersonilbyPosition']);
    $router->get('/DataPersonilbyPartner/{BussinessPartnerID}', ['uses' => 'PersonilController@PersonilbyPartner']);
    $router->get('/DataPersonilbyPartnerProject/{id}', ['uses' => 'PersonilController@PersonilbyPartnerProject']);

    //currency
    $router->get('/DataCurrency', ['uses' => 'CurrencyController@index']);
    $router->post('/InsertDataCurrency', ['uses' => 'CurrencyController@create']);
    $router->get('/DataCurrencyByid/{id}', ['uses' => 'CurrencyController@show']);
    $router->delete('/DeleteDataCurrency/{id}', ['uses' => 'CurrencyController@destroy']);
    $router->post('/UpdateCurrency/{id}', ['uses' => 'CurrencyController@update']);

    //unit
    $router->get('/DataUnit', ['uses' => 'UnitController@index']);
    $router->post('/InsertDataUnit', ['uses' => 'UnitController@create']);
    $router->get('/DataUnitByid/{id}', ['uses' => 'UnitController@show']);
    $router->delete('/DeleteDataUnit/{id}', ['uses' => 'UnitController@destroy']);
    $router->post('/UpdateUnit/{id}', ['uses' => 'UnitController@update']);

    //weather
    $router->get('/DataWeather', ['uses' => 'WeatherController@index']);
    $router->post('/InsertDataWeather', ['uses' => 'WeatherController@create']);
    $router->get('/DataWeatherByid/{id}', ['uses' => 'WeatherController@show']);
    $router->delete('/DeleteDataWeather/{id}', ['uses' => 'WeatherController@destroy']);
    $router->post('/UpdateWeather/{id}', ['uses' => 'WeatherController@update']);

    //PrivilegedName
    $router->get('/DataPrivilegedName', ['uses' => 'PrivilegedNameController@index']);
    $router->post('/InsertDataPrivilegedName', ['uses' => 'PrivilegedNameController@create']);
    $router->get('/DataPrivilegedNameByid/{id}', ['uses' => 'PrivilegedNameController@show']);
    $router->delete('/DeleteDataPrivilegedName/{id}', ['uses' => 'PrivilegedNameController@destroy']);
    $router->post('/UpdatePrivilegedName/{id}', ['uses' => 'PrivilegedNameController@update']);

    //Privileged
    $router->get('/DataPrivileged', ['uses' => 'UserPrivilegedController@index']);
    $router->post('/InsertDataPrivileged', ['uses' => 'UserPrivilegedController@create']);
    $router->get('/DataPrivilegedByid/{id}', ['uses' => 'UserPrivilegedController@show']);
    $router->get('/DataSpecPrivilegedByid/{id}', ['uses' => 'UserPrivilegedController@SpecPrivilegedByid']);
    $router->delete('/DeleteDataPrivileged/{id}', ['uses' => 'UserPrivilegedController@destroy']);
    $router->post('/UpdatePrivileged/{id}', ['uses' => 'UserPrivilegedController@update']);

     //user
     $router->get('/DataUser', ['uses' => 'UserController@index']);
     $router->post('/InsertDataUser', ['uses' => 'UserController@create']);
     $router->get('/DataUserByid/{id}', ['uses' => 'UserController@show']);
     $router->post('/getUser', ['uses' => 'UserController@getUser']);
     $router->post('/getGuest', ['uses' => 'UserController@getGuest']);
     $router->post('/getUserProject', ['uses' => 'UserController@getUserProject']);
     $router->get('/DataUserPrivilegedByid/{id}', ['uses' => 'UserController@UserPrivilegedByid']);
     $router->delete('/DeleteDataUser/{id}', ['uses' => 'UserController@destroy']);
     $router->post('/UpdateUser/{id}', ['uses' => 'UserController@update']);
     $router->get('/getUserPrivileged/{id}', ['uses' => 'UserController@getUserPrivileged']);

    //Project Number
    $router->get('/DataProjectNumber', ['uses' => 'ProjectNumberController@index']);
    $router->post('/InsertProjectNumber', ['uses' => 'ProjectNumberController@create']);
    $router->get('/DataProjectnumberByid/{id}', ['uses' => 'ProjectNumberController@showConsultant']);
    $router->get('/DataProjectnumberByidContractor/{id}', ['uses' => 'ProjectNumberController@showContractor']);
    $router->get('/DataLastProjectnumber', ['uses' => 'ProjectNumberController@getLastProjectNumber']);
    $router->get('/getProjectIDConsultant/{id}', ['uses' => 'ProjectNumberController@getProjectIDConsultant']);
    $router->get('/getProjectIDConContractor/{id}', ['uses' => 'ProjectNumberController@getProjectIDConContractor']);

    //Contractor Equipment
    $router->get('/DataContractorEquipment/{id}', ['uses' => 'ContractorEquipmentController@index']);
    $router->post('/InsertContractorEquipment', ['uses' => 'ContractorEquipmentController@create']);
    $router->delete('/DeleteContractorEquipment/{id}', ['uses' => 'ContractorEquipmentController@destroy']);
    $router->post('/UpdateContractorEquipment/{id}', ['uses' => 'ContractorEquipmentController@update']);
    $router->get('/DataContractorEquipmentByid/{id}', ['uses' => 'ContractorEquipmentController@show']);


    //Risk Management
    $router->get('/DataRiskManagement', ['uses' => 'RiskManagementController@index']);
    $router->post('/InsertRiskManagement', ['uses' => 'RiskManagementController@create']);
    $router->delete('/DeleteRiskManagement/{id}', ['uses' => 'RiskManagementController@destroy']);
    $router->post('/UpdateRiskManagement/{id}', ['uses' => 'RiskManagementController@update']);
    $router->get('/DataRiskManagementByid/{id}', ['uses' => 'RiskManagementController@show']);

    //BaselineBOQ
    $router->get('/DataBoq/{id}/{projectid}', ['uses' => 'BaselineBoqController@index']);
    $router->get('/DataBoqLevel/{id}/{itemid}/{projectid}', ['uses' => 'BaselineBoqController@DataBoqLevel']);
    $router->post('/InsertDataBoq', ['uses' => 'BaselineBoqController@create']);
    $router->get('/DataBoqByid/{id}', ['uses' => 'BaselineBoqController@show']);
    $router->delete('/DeleteBoq/{id}', ['uses' => 'BaselineBoqController@destroy']);
    $router->post('/UpdateBoq/{id}', ['uses' => 'BaselineBoqController@update']);
    $router->post('/UpdateBoqChildParentLevel/{id}', ['uses' => 'BaselineBoqController@UpdateBoqChildParentLevel']);
    $router->get('/DataBoqchild/{id}', ['uses' => 'BaselineBoqController@DataBoqchild']);
    $router->get('/getAllBoq/{contractorID}/{projectID}', ['uses' => 'BaselineBoqController@getAllBoq']);
    $router->get('/getWeightBoq/{projectid}/{contractorid}', ['uses' => 'BaselineBoqController@getWeightBoq']);

    $router->get('/DataBoqHistory', ['uses' => 'HistoryBoqController@index']);
    $router->post('/InsertDataBoqHistory', ['uses' => 'HistoryBoqController@create']);
    $router->get('/DataBoqByidHistory/{ProjectID}/{contractorID}/{created_at}/{time_at}', ['uses' => 'HistoryBoqController@DataBoqByidHistory']);
    $router->delete('/DeleteBoqHistory/{id}', ['uses' => 'HistoryBoqController@destroy']);
    $router->post('/UpdateBoqHistory/{id}', ['uses' => 'HistoryBoqController@update']);
    $router->get('/DataBoqchildHistory/{id}', ['uses' => 'HistoryBoqController@DataBoqchildHistory']);

    $router->get('/DataDocument/{projectID}/{contractorID}/{type}', ['uses' => 'DocumentsController@index']);
    $router->post('/InsertDataDocument', ['uses' => 'DocumentsController@create']);
    $router->get('/DataDocumentByid/{id}', ['uses' => 'DocumentsController@show']);
    $router->delete('/DeleteDataDocument/{id}', ['uses' => 'DocumentsController@destroy']);
    $router->post('/UpdateDataDocument/{id}', ['uses' => 'DocumentsController@update']);

    $router->get('/DataActualWbs/{contractorID}/{projectID}', ['uses' => 'ActualWbsController@index']);
    $router->post('/DataActualWbsDetail', ['uses' => 'ActualWbsController@DataActualWbsDetail']);
    $router->get('/GetActualParentItem/{projectID}/{consultantID}', ['uses' => 'ActualWbsController@GetActualParentItem']);
    $router->get('/GetActualChildItem/{projectID}/{consultantID}/{itemID}', ['uses' => 'ActualWbsController@GetActualChildItem']);
    $router->post('/InsertDataActualWbs', ['uses' => 'ActualWbsController@create']);
    $router->get('/DataActualWbsByid/{id}', ['uses' => 'ActualWbsController@show']);
    $router->get('/DataDetailActualWbsByid/{id}', ['uses' => 'ActualWbsController@DataDetailActualWbsByid']);
    $router->delete('/DeleteDataActualWbs/{id}', ['uses' => 'ActualWbsController@destroy']);
    $router->delete('/DeleteDataActualReportWbs/{id}', ['uses' => 'ActualWbsController@DeleteDataActualReportWbs']);
    $router->post('/UpdateDataActualWbs{id}', ['uses' => 'ActualWbsController@update']);
    $router->get('/DataActualWbschild/{id}/{contractorID}/{projectID}', ['uses' => 'ActualWbsController@DataActualWbschild']);
    $router->get('/getAllDataActualWbs/{contractorID}/{projectID}', ['uses' => 'ActualWbsController@getAllDataActualWbs']);
    //MobilizationDate
    $router->get('/DataMobilizationDate', ['uses' => 'MobilizationDateController@index']);
    $router->post('/InsertMobilizationDate', ['uses' => 'MobilizationDateController@create']);
    $router->get('/DataMobilizationDateByBusinessPartner/{BusinessPartner}', ['uses' => 'MobilizationDateController@byBusinessPartner']);
    $router->get('/DataMobilizationPositionCat/{id}', ['uses' => 'MobilizationDateController@DataMobilizationPositionCat']);
    $router->get('/DataMobilizationPosition/{id}', ['uses' => 'MobilizationDateController@DataMobilizationPosition']);

    $router->get('/DataProgressEvaluation', ['uses' => 'ProgressEvaluationController@index']);
    $router->post('/InsertDataProgressEvaluation', ['uses' => 'ProgressEvaluationController@create']);
    $router->get('/DataProgressEvaluationByid/{id}', ['uses' => 'ProgressEvaluationController@show']);
    $router->delete('/DeleteDataProgressEvaluation/{id}', ['uses' => 'ProgressEvaluationController@destroy']);
    $router->post('/UpdateDataProgressEvaluation/{id}', ['uses' => 'ProgressEvaluationController@update']);

    $router->get('/DataWbsHistory', ['uses' => 'WbsHistoryController@index']);
    $router->post('/InsertDataWbsHistory', ['uses' => 'WbsHistoryController@create']);
    $router->get('/DataWbsHistoryByid/{id}', ['uses' => 'WbsHistoryController@show']);
    $router->delete('/DeleteDataWbsHistory/{id}', ['uses' => 'WbsHistoryController@destroy']);

    $router->get('/DataDocument/{projectID}/{contractorID}', ['uses' => 'DocumentsController@index']);
    $router->post('/InsertDataDocument', ['uses' => 'DocumentsController@create']);
    $router->get('/DataDocumentByid/{id}', ['uses' => 'DocumentsController@show']);
    $router->delete('/DeleteDataDocument/{id}', ['uses' => 'DocumentsController@destroy']);
    $router->post('/InsertDataDocumentDetail', ['uses' => 'DocumentsController@createDocumentDetail']);

    $router->post('/InsertDataStation', ['uses' => 'StationProgressController@create']);
    $router->post('/InsertDataSubItem', ['uses' => 'SubStationProgressController@create']);
    $router->get('/DataStation/{projectID}/{contractorID}', ['uses' => 'StationProgressController@index']);
    $router->get('/DataStationDetail/{id}', ['uses' => 'StationProgressController@show']);
    $router->get('/getStationByParent/{id}', ['uses' => 'StationProgressController@getStationByParent']);
    $router->get('/getSubItem/{id}', ['uses' => 'SubStationProgressController@show']);
    $router->get('/getSubItemTable/{id}', ['uses' => 'SubStationProgressController@getSubItemTable']);
    $router->get('/getSubItemRowTable/{id}', ['uses' => 'SubStationProgressController@getSubItemRowTable']);
    $router->get('/getCompSubItemTable/{id}', ['uses' => 'SubStationProgressController@getCompSubItemTable']);
    $router->post('/UpdateSubItem/{id}/{stationID}', ['uses' => 'SubStationProgressController@update']);
    $router->post('/updateStation/{id}', ['uses' => 'StationProgressController@update']);
    $router->delete('/DeleteSubItem/{id}', ['uses' => 'SubStationProgressController@destroy']);
    $router->delete('/DeleteStation/{id}', ['uses' => 'StationProgressController@destroy']);

    $router->post('/InsertVisualProgress', ['uses' => 'VisualProgressController@create']);
    $router->post('/EditVisualProgress/{id}', ['uses' => 'VisualProgressController@update']);
    $router->post('/InsertVisualProgressImage', ['uses' => 'VisualProgressImageController@create']);
    $router->get('/DataVisualProgress/{projectID}/{contractorID}', ['uses' => 'VisualProgressController@index']);
    $router->get('/OtherDataVisualProgress/{projectID}/{contractorID}', ['uses' => 'VisualProgressController@showOtherVisual']);
    $router->get('/DataVisualProgressDetail/{id}', ['uses' => 'VisualProgressController@DataVisualProgressDetail']);
    $router->get('/OtherDataVisualProgressDetail/{id}', ['uses' => 'VisualProgressController@OtherDataVisualProgressDetail']);
    $router->delete('/DeleteImage/{id}', ['uses' => 'VisualProgressImageController@destroy']);
    $router->delete('/DeleteVisual/{id}', ['uses' => 'VisualProgressController@destroy']);
    $router->get('/getPerformance/{projectId}/{contractorId}', ['uses' => 'PerformanceAnalysisController@getPerformance']);
    $router->get('/getPerformanceDetail/{docID}', ['uses' => 'PerformanceAnalysisController@getPerformanceDetail']);
    $router->get('/getPerformanceList/{projectId}/{contractorId}', ['uses' => 'PerformanceAnalysisController@getPerformanceList']);
    $router->post('/InsertPerformance', ['uses' => 'PerformanceAnalysisController@create']);


    $router->delete('/DeleteMobilizationDate/{id}', ['uses' => 'MobilizationDateController@destroy']);
    $router->get('/DataMobilizationDateByid/{id}', ['uses' => 'MobilizationDateController@show']);
    $router->post('/UpdateMobilizationDate/{id}', ['uses' => 'MobilizationDateController@update']);

    //baseline wbs
    $router->get('/DataWbs/{id}/{projectid}', ['uses' => 'BaselineWbsController@index']);
    $router->get('/DataWbsLevel/{id}/{itemid}/{projectid}', ['uses' => 'BaselineWbsController@DataWbsLevel']);
    $router->post('/InsertDataWbs', ['uses' => 'BaselineWbsController@create']);
    $router->get('/DataWbsByid/{id}', ['uses' => 'BaselineWbsController@show']);
    $router->delete('/DeleteWbs/{id}', ['uses' => 'BaselineWbsController@destroy']);
    $router->post('/UpdateWbs/{id}', ['uses' => 'BaselineWbsController@update']);
    $router->post('/UpdateWbsChildParentLevel/{id}', ['uses' => 'BaselineWbsController@UpdateWbsChildParentLevel']);
    $router->get('/DataWbschild/{id}', ['uses' => 'BaselineWbsController@DataWbschild']);
    $router->get('/getAllWbs/{contractorID}/{projectID}', ['uses' => 'BaselineWbsController@getAllWbs']);
    $router->get('/getWeightWbs/{projectid}/{contractorid}', ['uses' => 'BaselineWbsController@getWeightWbs']);
    $router->get('/getWeightBaselineWbsByItem/{id}', ['uses' => 'BaselineWbsController@getWeightBaselineWbsByItem']);
    $router->get('/getBaselineChart/{projectid}/{contractorid}', ['uses' => 'BaselineWbsController@getBaselineChart']);

    $router->get('/DataCurrentWbs/{id}/{projectid}', ['uses' => 'CurrentWbsController@index']);
    $router->get('/DataCurrentWbsLevel/{id}/{itemid}/{projectid}', ['uses' => 'CurrentWbsController@DataActualWbsLevel']);
    $router->post('/InsertDataCurrentWbs', ['uses' => 'CurrentWbsController@create']);
    $router->get('/DataCurrentWbsByid/{id}', ['uses' => 'CurrentWbsController@show']);
    $router->delete('/DeleteCurrentWbs/{id}', ['uses' => 'CurrentWbsController@destroy']);
    $router->post('/UpdateCurrentWbs/{id}', ['uses' => 'CurrentWbsController@update']);
    $router->post('/UpdateCurrentWbsChildParentLevel/{id}', ['uses' => 'CurrentWbsController@UpdateWbsChildParentLevel']);
    $router->get('/DataCurrentWbschild/{id}', ['uses' => 'CurrentWbsController@DataWbschild']);
    $router->get('/getAllCurrentWbs/{contractorID}/{projectID}', ['uses' => 'CurrentWbsController@getAllCurrentWbs']);
    $router->get('/getWeightCurrentWbs/{projectid}/{contractorid}', ['uses' => 'CurrentWbsController@getWeightActualWbs']);
    $router->get('/getWeightCurrentWbsByItem/{id}', ['uses' => 'CurrentWbsController@getWeightCurrentWbsByItem']);
    $router->get('/getCurrentWbsChart/{projectid}/{contractorid}', ['uses' => 'CurrentWbsController@getCurrentWbsChart']);

    $router->post('/InsertDataCurrentWbsHistory', ['uses' => 'WbsHistoryController@create']);
    $router->get('/GetDataProjectOwner', ['uses' => 'ProjectController@GetDataProjectOwner']);
    $router->get('/GetDataProjectManagerOwner/{id}', ['uses' => 'ProjectController@getProjectManagerOwner']);


    //weather info
    $router->get('/weatherInfo', 'WeatherInfoController@index');
    $router->post('/weatherInfo', 'WeatherInfoController@store');
    $router->get('/weatherInfo/{id}', 'WeatherInfoController@show');
    $router->delete('/weatherInfo/{id}', 'WeatherInfoController@destroy');
    $router->post('/weatherInfo/{id}', 'WeatherInfoController@update');

    //issue management
    $router->get('/issue', 'IssueManagementController@index');
    $router->post('/issue', 'IssueManagementController@store');
    $router->get('/issue/{id}', 'IssueManagementController@show');
    $router->delete('/issue/{id}', 'IssueManagementController@destroy');
    $router->post('/issue/{id}', 'IssueManagementController@update');

    //monthly meeting
    $router->get('/meeting', 'MonthlyMeetingController@index');
    $router->post('/meeting', 'MonthlyMeetingController@store');
    $router->get('/meeting/{id}', 'MonthlyMeetingController@show');
    $router->delete('/meeting/{id}', 'MonthlyMeetingController@destroy');
    $router->post('/meeting/{id}', 'MonthlyMeetingController@update');
  
    //progress report
    $router->get('/detailProject/{projectID}/{contractorID}', 'ProgressReportController@getProject');
    $router->post('/getScheduledProgress','ProgressReportController@getScheduledProgress');
    $router->post('/getActualProgress','ProgressReportController@getActualProgress');
    $router->get('/getIssue/{projectID}','ProgressReportController@getIssue');
    $router->get('/riskReport/{projectID}/{contractorID}','ProgressReportController@riskReport');
    $router->get('/getProgressCurve/{projectID}/{contractorID}','ProgressReportController@getProgressCurve');
    $router->get('/getActualTable/{projectID}/{contractorID}','ProgressReportController@getActualTable');
    $router->get('/getBaseline/{projectID}/{contractorID}','ProgressReportController@getBaseline');
    $router->get('/getCurrentTable/{projectID}/{contractorID}','ProgressReportController@getCurrentTable');
    $router->get('/getTimeElapse/{projectID}/{contractorID}','ProgressReportController@getTimeElapse');
    

    $router->get('/paymentItemList/{id}', 'PaymentCertificateController@show');
    $router->get('/getPaymentListDetail/{id}', 'PaymentCertificateController@getPaymentListDetail');
    $router->get('/getCertificateTitle/{id}', 'PaymentCertificateController@getCertificateTitle');
    $router->get('/getItemNonVat/{id}', 'PaymentDeductionItemController@ItemNonVat');
    $router->get('/getItemVat/{id}', 'PaymentDeductionItemController@ItemVat');
    $router->get('/getList/{id}', 'PaymentCertificateController@getList');
    $router->post('/createCertificate', 'PaymentCertificateController@create');
    $router->post('/createDeduction', 'PaymentDeductionItemController@create');
    $router->delete('/deleteDeduction/{id}', 'PaymentDeductionItemController@destroy');
    
});
