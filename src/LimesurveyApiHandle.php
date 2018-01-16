<?php

namespace LaravelLimesurveyApi\Handle;

use org\jsonrpcphp\JsonRPCClient;

/**
 * 方法注释中标注 TODO 表示尚未验证的方法
 *
 * Class LimesurveyApiHandle
 *
 * @package LaravelLimesurveyApi\Handle
 */
class LimesurveyApiHandle
{
    protected $url;

    protected $username;

    protected $password;

    protected $jsonRPCClient;

    protected $session_key;

    /**
     * LimesurveyApiHandle constructor.
     *
     * @param $url
     * @param $username
     * @param $password
     */
    public function __construct ( $url, $username, $password )
    {
        $this->url = $url;

        $this->username = $username;

        $this->password = $password;

        $this->get_jsonRPCClient();

        $this->session_key = $this->get_session_key( $this->username, $this->password );
    }

    private function get_jsonRPCClient ()
    {
        $this->jsonRPCClient = new JsonRPCClient( $this->url );
    }

    /**
     * Create and return a session key.
     *
     * Using this function you can create a new XML-RPC/JSON-RPC session key.
     * This is mandatory for all following LSRC2 function calls.
     *
     * * In case of success : Return the session key in string
     * * In case of error:
     *     * for protocol-level errors (invalid format etc), an error message.
     *     * For invalid username and password, returns a null error and the result body contains a 'status' name-value pair with the error message.
     *
     * @access public
     *
     * @param string $username
     * @param string $password
     *
     * @return string|array
     */
    public function get_session_key ( $username, $password )
    {
        return $this->jsonRPCClient->get_session_key( $username, $password );
    }

    /**
     * Activate an existing survey
     *
     * Return the result of the activation
     * Failure status : Invalid Survey ID, Activation Error, Invalid session key, No permission
     *
     * @access public
     *
     * @param int $iSurveyId ID of the Survey to be activated
     *
     * @return array in case of success result of the activation
     */
    public function activate_survey ( $iSurveyId )
    {
        return $this->jsonRPCClient->activate_survey( $this->session_key, $iSurveyId );
    }

    /**
     * TODO
     *
     * Initialise the token system of a survey where new participant tokens may be later added.
     *
     * @access public
     *
     * @param integer $iSurveyId        ID of the Survey where a survey participants table will be created for
     * @param array   $aAttributeFields An array of integer describing any additional attribute fields
     *
     * @return array Status=>OK when successful, otherwise the error description
     */
    public function activate_tokens ( $iSurveyId, array $aAttributeFields = [] )
    {
        return $this->jsonRPCClient->activate_tokens( $this->session_key, $iSurveyId, $aAttributeFields );
    }

    /**
     * TODO
     *
     * Add an empty group with minimum details to a chosen survey.
     * Used as a placeholder for importing questions.
     * Returns the groupid of the created group.
     *
     * @param int    $iSurveyID         ID of the Survey to add the group
     * @param string $sGroupTitle       Name of the group
     * @param string $sGroupDescription Optional description of the group
     *
     * @return array|int The id of the new group - Or status
     */
    public function add_group ( $iSurveyID, $sGroupTitle, $sGroupDescription = '' )
    {
        return $this->jsonRPCClient->addGroup( $this->session_key, $iSurveyID, $sGroupTitle, $sGroupDescription );
    }

    /**
     * TODO
     *
     * @param int    $iSurveyID ID of the Survey for which a survey participants table will be created
     * @param string $sLanguage A valid language shortcut to add to the current Survey. If the language already exists no error will be given.
     *
     * @return array Status=>OK when successful, otherwise the error description
     */
    public function add_language ( $iSurveyID, $sLanguage )
    {
        return $this->jsonRPCClient->add_language( $this->session_key, $iSurveyID, $sLanguage );
    }

    /**
     * TODO
     *
     * Add participants to the tokens collection of the survey.
     *
     * The parameters $aParticipantData is a 2 dimensionnal array containing needed participant data.
     *
     * @see     \Token for all available attribute,
     * @example : `[ {"email":"me@example.com","lastname":"Bond","firstname":"James"},{"email":"me2@example.com","attribute_1":"example"} ]`
     *
     * Returns the inserted data including additional new information like the Token entry ID and the token string. In case of errors in some data, return it in errors.
     *
     * @access  public
     *
     * @param int   $iSurveyID        ID of the Survey
     * @param array $aParticipantData Data of the participants to be added
     * @param bool  $bCreateToken     Optional - Defaults to true and determins if the access token automatically created
     *
     * @return array The values added
     */
    public function add_participants ( $iSurveyID, $aParticipantData, $bCreateToken )
    {
        return $this->jsonRPCClient->add_participants( $this->session_key, $iSurveyID, $aParticipantData, $bCreateToken );
    }

    /**
     * TODO
     *
     * Add a response to the survey responses collection.
     * Returns the id of the inserted survey response
     *
     * @access public
     *
     * @param int   $iSurveyID     ID of the Survey to insert responses
     * @param array $aResponseData The actual response
     *
     * @return int|array The response ID
     */
    public function add_response ( $iSurveyID, $aResponseData )
    {
        return $this->jsonRPCClient->add_response( $this->session_key, $iSurveyID, $aResponseData );
    }

    /**
     * TODO
     *
     * Add an empty survey with minimum details
     *
     * This just tries to create an empty survey with the minimal settings.
     *
     * Failure status: Invalid session key, No permission, Faulty parameters, Creation Failed result
     *
     * @access public
     *
     * @param int    $iSurveyID       The desired ID of the Survey to add
     * @param string $sSurveyTitle    Title of the new Survey
     * @param string $sSurveyLanguage Default language of the Survey
     * @param string $sformat         (optional) Question appearance format (A, G or S) for "All on one page", "Group by Group", "Single questions", default to group by group (G)
     *
     * @return int|array The survey id in case of success
     */
    public function add_survey ( $iSurveyID, $sSurveyTitle, $sSurveyLanguage, $sformat )
    {
        return $this->jsonRPCClient->add_survey( $this->session_key, $iSurveyID, $sSurveyTitle, $sSurveyLanguage, $sformat );
    }

    /**
     * TODO
     *
     * RPC Routine to copy a survey.
     *
     * @access public
     *
     * @param int    $iSurveyID_org Id of the source survey
     * @param string $sNewname      name of the new survey
     *
     * @return On success: new $iSurveyID in array['newsid']. On failure array with error information
     */
    public function copy_survey ( $iSurveyID_org, $sNewname )
    {
        return $this->jsonRPCClient->copy_survey( $this->session_key, $iSurveyID_org, $sNewname );
    }

    /**
     * TODO
     *
     * Import a participant into the LimeSurvey cpd. It stores attributes as well, if they are registered before within ui
     *
     * Call the function with $response = $myJSONRPCClient->cpd_importParticipants( $sessionKey, $aParticipants);
     *
     * @param array $aParticipants
     * [[0] => ["email"=>"dummy-02222@limesurvey.com","firstname"=>"max","lastname"=>"mustermann"]]
     *
     * @return array with status
     */
    public function cpd_importParticipants ( array $aParticipants = [] )
    {
        return $this->jsonRPCClient->cpd_importParticipants( $this->session_key, $aParticipants );
    }

    /**
     * TODO
     *
     * Delete a group from a chosen survey .
     * Returns the id of the deleted group.
     *
     * @access public
     *
     * @param int $iSurveyID ID of the Survey that the group belongs
     * @param int $iGroupID  ID of the group to delete
     *
     * @return array|int The ID of the deleted group or status
     */
    public function delete_group ( $iSurveyID, $iGroupID )
    {
        return $this->jsonRPCClient->delete_group( $this->session_key, $iSurveyID, $iGroupID );
    }

    /**
     * TODO
     *
     * RPC Routine to delete a language from a survey.
     *
     * @access public
     *
     * @param integer $iSurveyID ID of the Survey for which a survey participants table will be created
     * @param string  $sLanguage A valid language shortcut to delete from the current Survey. If the language does not exist in that Survey no error will be given.
     *
     * @return array Status=>OK when successful, otherwise the error description
     */
    public function delete_language ( $iSurveyID, $sLanguage )
    {
        return $this->jsonRPCClient->delete_language( $this->session_key, $iSurveyID, $sLanguage );
    }

    /**
     * TODO
     *
     * Delete multiple participants from the survey participants table of a survey.
     * Returns the id of the deleted token
     *
     * @access public
     *
     * @param int   $iSurveyID ID of the Survey that the participants belong to
     * @param array $aTokenIDs ID of the tokens/participants to delete
     *
     * @return array Result of deletion
     */
    public function delete_participants ( $iSurveyID, array $aTokenIDs = [] )
    {
        return $this->jsonRPCClient->delete_participants( $this->session_key, $iSurveyID, $aTokenIDs );
    }

    /**
     * TODO
     *
     * Delete a question from a survey .
     * Returns the id of the deleted question.
     *
     * @access public
     *
     * @param int $iQuestionID ID of the Question to delete
     *
     * @return array|int ID of the deleted Question or status
     */
    public function delete_question ( $iQuestionID )
    {
        return $this->jsonRPCClient->delete_question( $this->session_key, $iQuestionID );
    }

    /**
     * TODO
     *
     * Delete a survey.
     *
     * Failure status: Invalid session key, No permission
     *
     * @access public
     *
     * @param int $iSurveyID The ID of the Survey to be deleted
     *
     * @return array Returns status : status are OK in case of success
     */
    public function delete_survey ( $iSurveyID )
    {
        return $this->jsonRPCClient->delete_survey( $this->session_key, $iSurveyID );
    }

    /**
     * TODO
     *
     * Export responses in base64 encoded string
     *
     * @access public
     *
     * @param int     $iSurveyID         ID of the Survey
     * @param string  $sDocumentType     any format available by plugins (for example : pdf, csv, xls, doc, json)
     * @param string  $sLanguageCode     (optional) The language to be used
     * @param string  $sCompletionStatus (optional) 'complete','incomplete' or 'all' - defaults to 'all'
     * @param string  $sHeadingType      (optional) 'code','full' or 'abbreviated' Optional defaults to 'code'
     * @param string  $sResponseType     (optional)'short' or 'long' Optional defaults to 'short'
     * @param integer $iFromResponseID   (optional)
     * @param integer $iToResponseID     (optional)
     * @param array   $aFields           (optional) Selected fields
     *
     * @return array|string On success: Requested file as base 64-encoded string. On failure array with error information
     */
    public function export_responses ( $iSurveyID, $sDocumentType, $sLanguageCode, $sCompletionStatus, $sHeadingType, $sResponseType, $iFromResponseID, $iToResponseID, array $aFields = [] )
    {
        return $this->jsonRPCClient->export_responses( $this->session_key, $iSurveyID, $sDocumentType, $sLanguageCode, $sCompletionStatus, $sHeadingType, $sResponseType, $iFromResponseID, $iToResponseID, $aFields );
    }

    /**
     * TODO
     *
     * Export token response in a survey.
     * Returns the requested file as base64 encoded string
     *
     * @access public
     *
     * @param int    $iSurveyID         ID of the Survey
     * @param string $sDocumentType     pdf, csv, xls, doc, json
     * @param string $sToken            The token for which responses needed
     * @param string $sLanguageCode     The language to be used
     * @param string $sCompletionStatus Optional 'complete','incomplete' or 'all' - defaults to 'all'
     * @param string $sHeadingType      'code','full' or 'abbreviated' Optional defaults to 'code'
     * @param string $sResponseType     'short' or 'long' Optional defaults to 'short'
     * @param array  $aFields           Optional Selected fields
     *
     * @return array|string On success: Requested file as base 64-encoded string. On failure array with error information
     */
    public function export_responses_by_token ( $iSurveyID, $sDocumentType, $sToken, $sLanguageCode, $sCompletionStatus, $sHeadingType, $sResponseType, array $aFields = [] )
    {
        return $this->jsonRPCClient->export_responses_by_token( $this->session_key, $iSurveyID, $sDocumentType, $sToken, $sLanguageCode, $sCompletionStatus, $sHeadingType, $sResponseType, $aFields );
    }

    /**
     * TODO
     *
     * Export statistics of a survey to a user.
     *
     * Allow to export statistics available Returns string - base64 encoding of the statistics.
     *
     * @access public
     *
     * @param int       $iSurveyID ID of the Survey
     * @param string    $docType   (optional) Type of documents the exported statistics should be (pdf|xls|html)
     * @param string    $sLanguage (optional) language of the survey to use (default from Survey)
     * @param string    $graph     (optional) Create graph option (default : no)
     * @param int|array $groupIDs  (optional) array or integer containing the groups we choose to generate statistics from
     *
     * @return string|array in case of success : Base64 encoded string with the statistics file
     */
    public function export_statistics ( $iSurveyID, $docType, $sLanguage, $graph, $groupIDs )
    {
        return $this->jsonRPCClient->export_statistics( $this->session_key, $iSurveyID, $docType, $sLanguage, $graph, $groupIDs );
    }

    /**
     * TODO
     *
     * RPC Routine to export submission timeline.
     * Returns an array of values (count and period)
     *
     * @access public
     *
     * @param int    $iSurveyID ID of the Survey
     * @param string $sType     (day|hour)
     * @param string $dStart
     * @param string $dEnd
     *
     * @return array On success: The timeline. On failure array with error information
     */
    public function export_timeline ( $iSurveyID, $sType, $dStart, $dEnd )
    {
        return $this->jsonRPCClient->export_timeline( $this->session_key, $iSurveyID, $sType, $dStart, $dEnd );
    }

    /**
     * TODO
     *
     * Get the properties of a group of a survey .
     *
     * Returns array of properties needed or all properties
     *
     * @see    \QuestionGroup for available properties
     *
     * @access public
     *
     * @param int   $iGroupID       Id of the group to get properties of
     * @param array $aGroupSettings The properties to get
     *
     * @return array in case of success the requested values in array
     */
    public function get_group_properties ( $iGroupID, array $aGroupSettings = [] )
    {
        return $this->jsonRPCClient->get_group_properties( $this->session_key, $iGroupID, $aGroupSettings );
    }

    /**
     * TODO
     *
     * Get survey language properties.
     *
     * @see    \SurveyLanguageSetting for available properties
     *
     * @access public
     *
     * @param int         $iSurveyID             ID of the Survey
     * @param array|null  $aSurveyLocaleSettings (optional) Properties to get, default to all attributes
     * @param string|null $sLang                 (optional) Language to use, default to Survey->language
     *
     * @return array in case of success The requested values
     */
    public function get_language_properties ( $iSurveyID, $aSurveyLocaleSettings, $sLang )
    {
        return $this->jsonRPCClient->get_language_properties( $this->session_key, $iSurveyID, $aSurveyLocaleSettings, $sLang );
    }

    /**
     * TODO
     *
     * Get settings of a token/participant of a survey.
     *
     * Allow to request for a specific participant. If more than one participant is returned with specified attribute(s) an error is returned.
     *
     * @access public
     *
     * @param int       $iSurveyID             ID of the Survey to get token properties
     * @param array|int $aTokenQueryProperties of participant properties used to query the participant, or the token id as an integer
     * @param array     $aTokenProperties      The properties to get
     *
     * @return array The requested values
     */
    public function get_participant_properties ( $iSurveyID, $aTokenQueryProperties, array $aTokenProperties = [] )
    {
        return $this->jsonRPCClient->get_participant_properties( $this->session_key, $iSurveyID, $aTokenQueryProperties, $aTokenProperties );
    }

    /**
     * TODO
     *
     * Get properties of a question in a survey.
     *
     * @see    \Question for available properties.
     * Some more properties are available_answers, subquestions, attributes, attributes_lang, answeroptions, defaultvalue
     *
     * @access public
     *
     * @param int    $iQuestionID       ID of the question to get properties
     * @param array  $aQuestionSettings (optional) properties to get, default to all
     * @param string $sLanguage         (optional) parameter language for multilingual questions, default are \Survey->language
     *
     * @return array The requested values
     */
    public function get_question_properties ( $iQuestionID, array $aQuestionSettings = [], $sLanguage )
    {
        return $this->jsonRPCClient->get_question_properties( $this->session_key, $iQuestionID, $aQuestionSettings, $sLanguage );
    }

    /**
     * TODO
     *
     * Find response IDs given a survey ID and a token.
     *
     * @param int    $iSurveyID
     * @param string $sToken
     *
     * @return array
     */
    public function get_response_ids ( $iSurveyID, $sToken )
    {
        return $this->jsonRPCClient->get_response_ids( $this->session_key, $iSurveyID, $sToken );
    }

    /**
     * TODO
     *
     * Get a global setting
     *
     * Function to query site settings. Can only be used by super administrators.
     *
     * @access public
     *
     * @param string $sSetttingName Name of the setting to get
     *
     * @return string|array The requested value or an array with the error in case of error
     */
    public function get_site_settings ( $sSetttingName )
    {
        return $this->jsonRPCClient->get_site_settings( $this->session_key, $sSetttingName );
    }

    /**
     * TODO
     *
     * Get survey summary, regarding token usage and survey participation.
     *
     * Returns the requested value as string, or all status in an array
     *
     * Available status are
     * * For Survey stats
     *     * completed_responses
     *     * incomplete_responses
     *     * full_responses
     * * For token part
     *     * token_count
     *     * token_invalid
     *     * token_sent
     *     * token_opted_out
     *     * token_completed
     * All available status can be sent using `all`
     *
     * Failure status : No available data, No such property, Invalid session key, No permission
     *
     * @access public
     *
     * @param int    $iSurveyID ID of the Survey to get summary
     * @param string $sStatName (optional) Name of the summary option, or all to send all in an array (all by default)
     *
     * @return string|array in case of success the requested value or an array of all values
     */
    public function get_summary ( $iSurveyID, $sStatName )
    {
        return $this->jsonRPCClient->get_summary( $this->session_key, $iSurveyID, $sStatName );
    }

    /**
     * TODO
     *
     * RPC Routine to get survey properties.
     * Get properties of a survey
     *
     * All internal properties of a survey are available.
     *
     * @see    \Survey for the list of available properties
     *
     * Failure status : Invalid survey ID, Invalid session key, No permission, No valid Data
     *
     * @access public
     *
     * @param int        $iSurveyID       The id of the Survey to be checked
     * @param array|null $aSurveySettings (optional) The properties to get
     *
     * @return array
     */
    public function get_survey_properties ( $iSurveyID, $aSurveySettings )
    {
        return $this->jsonRPCClient->get_survey_properties( $this->session_key, $iSurveyID, $aSurveySettings );
    }

    /**
     * TODO
     *
     * Obtain all uploaded files for a single response
     *
     * @access public
     *
     * @param int $iSurveyID ID of the Survey
     * @param int $sToken    Response token
     *
     * @return array On success: array containing all uploads of the specified response
     *               On failure: array with error information
     */
    public function get_uploaded_files ( $iSurveyID, $sToken )
    {
        return $this->jsonRPCClient->get_uploaded_files( $this->session_key, $iSurveyID, $sToken );
    }

    /**
     * TODO
     *
     * Import a group and add to a chosen survey - imports lsg,csv
     *
     * @access public
     *
     * @param int    $iSurveyID            The ID of the Survey that the group will belong
     * @param string $sImportData          String containing the BASE 64 encoded data of a lsg,csv
     * @param string $sImportDataType      lsg,csv
     * @param string $sNewGroupName        Optional new name for the group
     * @param string $sNewGroupDescription Optional new description for the group
     *
     * @return array|integer iGroupID  - ID of the new group or status
     */
    public function import_group ( $iSurveyID, $sImportData, $sImportDataType, $sNewGroupName, $sNewGroupDescription )
    {
        return $this->jsonRPCClient->import_group( $this->session_key, $iSurveyID, $sImportData, $sImportDataType, $sNewGroupName, $sNewGroupDescription );
    }

    /**
     * TODO
     *
     * Import a question from lsq file
     *
     * @access public
     *
     * @param int    $iSurveyID         The ID of the Survey that the question will belong to
     * @param int    $iGroupID          The ID of the Group that the question will belong to
     * @param string $sImportData       String containing the BASE 64 encoded data of a lsq
     * @param string $sImportDataType   lsq
     * @param string $sMandatory        (optional) Mandatory question option (default to No)
     * @param string $sNewQuestionTitle (optional) new title for the question
     * @param string $sNewqQuestion     (optional) new question text
     * @param string $sNewQuestionHelp  (optional) new question help text
     *
     * @return array|integer The id of the new question in case of success. Array if errors
     */
    public function import_question ( $iSurveyID, $iGroupID, $sImportData, $sImportDataType, $sMandatory, $sNewQuestionTitle, $sNewqQuestion, $sNewQuestionHelp )
    {
        return $this->jsonRPCClient->import_question( $this->session_key, $iSurveyID, $iGroupID, $sImportData, $sImportDataType, $sMandatory, $sNewQuestionTitle, $sNewqQuestion, $sNewQuestionHelp );
    }

    /**
     * TODO
     *
     * Import a survey in a known format
     *
     * Allow importing lss, csv, xls or survey zip archive in BASE 64 encoded.
     *
     * Failure status: Invalid session key, No permission, The import error
     *
     * @access public
     *
     * @param string  $sImportData     String containing the BASE 64 encoded data of a lss, csv, txt or survey lsa archive
     * @param string  $sImportDataType lss, csv, txt or lsa
     * @param string  $sNewSurveyName  (optional) The optional new name of the survey
     * @param integer $DestSurveyID    (optional) This is the new ID of the survey - if already used a random one will be taken instead
     *
     * @return int|array The ID of the new survey in case of success
     */
    public function import_survey ( $sImportData, $sImportDataType, $sNewSurveyName, $DestSurveyID )
    {
        return $this->jsonRPCClient->import_survey( $this->session_key, $sImportData, $sImportDataType, $sNewSurveyName, $DestSurveyID );
    }

    /**
     * TODO
     *
     * Invite participants in a survey
     *
     * Returns array of results of sending
     *
     * @access public
     *
     * @param int   $iSurveyID ID of the survey that participants belong
     * @param array $aTokenIds Ids of the participant to invite
     * @param bool  $bEmail    Send only pending invites (TRUE) or resend invites only (FALSE)
     *
     * @return array Result of the action
     */
    public function invite_participants ( $iSurveyID, $aTokenIds, $bEmail )
    {
        return $this->jsonRPCClient->invite_participants( $this->session_key, $iSurveyID, $aTokenIds, $bEmail );
    }

    /**
     * Return the ids and all attributes of groups belonging to survey.
     *
     * @access public
     *
     * @param int $iSurveyID ID of the Survey containing the groups
     *
     * @return array in case of success the list of groups
     */
    public function list_groups ( $iSurveyID )
    {
        return $this->jsonRPCClient->list_groups( $this->session_key, $iSurveyID );
    }

    /**
     * TODO
     *
     * Return the ids and propertries of token/participants of a survey.
     *
     * if $bUnused is true, user will get the list of uncompleted tokens (token_return functionality).
     * Parameters iStart and iLimit are used to limit the number of results of this call.
     *
     * By default return each participant with basic information
     * * tid : the token id
     * * token : the token for this participant
     * * participant_info : an array with firstname, lastname and email
     * Parameter $aAttributes can be used to add more attribute in participant_info array
     *
     * @access public
     *
     * @param int        $iSurveyID   ID of the Survey to list participants
     * @param int        $iStart      Start id of the token list
     * @param int        $iLimit      Number of participants to return
     * @param bool       $bUnused     If you want unused tokens, set true
     * @param bool|array $aAttributes The extented attributes that we want
     * @param array      $aConditions Optional conditions to limit the list, e.g. with array('email' => 'info@example.com')
     *
     * @return array The list of tokens
     */
    public function list_participants ( $iSurveyID, $iStart, $iLimit, $bUnused, $aAttributes, $aConditions )
    {
        return $this->jsonRPCClient->list_participants( $this->session_key, $iSurveyID, $iStart, $iLimit, $bUnused, $aAttributes, $aConditions );
    }

    /**
     * Return the ids and info of (sub-)questions of a survey/group.
     * Returns array of ids and info.
     *
     * @access public
     *
     * @param int    $iSurveyID ID of the Survey to list questions
     * @param int    $iGroupID  Optional id of the group to list questions
     * @param string $sLanguage Optional parameter language for multilingual questions
     *
     * @return array The list of questions
     */
    public function list_questions ( $iSurveyID, $iGroupID, $sLanguage = 'zh-Hans' )
    {
        return $this->jsonRPCClient->list_questions( $this->session_key, $iSurveyID, $iGroupID, $sLanguage );
    }

    /**
     * List the survey belonging to a user （根据$sUsername的权限进行问卷的查询）
     *
     * If user is admin he can get surveys of every user (parameter sUser) or all surveys (sUser=null)
     * Else only the surveys belonging to the user requesting will be shown.
     *
     * Returns array with
     * * `sid` the ids of survey
     * * `surveyls_title` the title of the survey
     * * `startdate` start date
     * * `expires` expiration date
     * * `active` if survey is active (Y) or not (!Y)
     *
     * @access public
     *
     * @param string|null $sUsername (optional) username to get list of surveys
     *
     * @return array In case of success the list of surveys
     */
    public function list_surveys ( $sUsername = null )
    {
        return $this->jsonRPCClient->list_surveys( $this->session_key, $sUsername );
    }

    /**
     * Get list the ids and info of users.
     *
     * Returns array of ids and info.
     *
     * Failure status : No users found, Invalid session key, No permission (super admin is required)
     *
     * @param int $uid Optional parameter user id.
     *
     * @return  array The list of users in case of success
     */
    public function list_users ( $uid = null )
    {
        return $this->jsonRPCClient->list_users( $this->session_key, $uid );
    }

    /**
     * TODO
     *
     * Send register mails to participants in a survey
     *
     * Returns array of results of sending
     *
     * Default behaviour is to send register emails to not invited, not reminded, not completed and in valid frame date participant.
     *
     * $overrideAllConditions replaces this default conditions for selecting the participants. A typical use case is to select only one participant
     * ````
     * $overrideAllConditions = Array();
     * $overrideAllConditions[] = 'tid = 2';
     * $response = $myJSONRPCClient->mail_registered_participants( $sessionKey, $survey_id, $overrideAllConditions );
     * ````
     *
     * @access public
     *
     * @param int   $iSurveyID             ID of the Survey that participants belong
     * @param array $overrideAllConditions replace the default conditions
     *
     * @return array Result of the action
     */
    public function mail_registered_participants ( $iSurveyID, array $overrideAllConditions = [] )
    {
        return $this->jsonRPCClient->mail_registered_participants( $this->session_key, $iSurveyID, $overrideAllConditions );
    }

    /**
     * TODO
     *
     * Close the RPC session
     *
     * Using this function you can close a previously opened XML-RPC/JSON-RPC session.
     *
     * @access public
     *
     * @return string OK
     */
    public function release_session_key ()
    {
        return $this->jsonRPCClient->release_session_key( $this->session_key );
    }

    /**
     * TODO
     *
     * Send a reminder to participants in a survey
     * Returns array of results of sending
     *
     * @access public
     *
     * @param int   $iSurveyID       ID of the Survey that participants belong
     * @param int   $iMinDaysBetween (optional) parameter days from last reminder
     * @param int   $iMaxReminders   (optional) parameter Maximum reminders count
     * @param array $aTokenIds       Ids of the participant to remind (optional filter)
     *
     * @return array in case of success array of result of each email send action and count of invitations left to send in status key
     */
    public function remind_participants ( $iSurveyID, $iMinDaysBetween, $iMaxReminders, array $aTokenIds = [] )
    {
        return $this->jsonRPCClient->remind_participants( $this->session_key, $iSurveyID, $iMinDaysBetween, $iMaxReminders, $aTokenIds );
    }

    /**
     * TODO
     *
     * Set group properties.
     *
     * @see    \QuestionGroup for available properties and restriction
     *
     * Some attribute can not be set
     * sid
     * gid
     *
     * @access public
     *
     * @param integer $iGroupID   - ID of the Survey
     * @param array   $aGroupData - An array with the particular fieldnames as keys and their values to set on that particular survey
     *
     * @return array Of succeeded and failed modifications according to internal validation.
     */
    public function set_group_properties ( $iGroupID, $aGroupData )
    {
        return $this->jsonRPCClient->set_group_properties( $this->session_key, $iGroupID, $aGroupData );
    }

    /**
     * TODO
     *
     * Set survey language properties.
     *
     * @see    \SurveyLanguageSetting for available properties.
     *
     * Some properties can not be set
     *  surveyls_language
     *  surveyls_survey_id
     *
     * @access public
     *
     * @param integer $iSurveyID         - ID of the Survey
     * @param array   $aSurveyLocaleData - An array with the particular fieldnames as keys and their values to set on that particular survey
     * @param string  $sLanguage         - Optional - Language to update  - if not give the base language of the particular survey is used
     *
     * @return array in case of success 'status'=>'OK', when save successful otherwise error text.
     */
    public function set_language_properties ( $iSurveyID, array $aSurveyLocaleData = [], $sLanguage )
    {
        return $this->jsonRPCClient->set_language_properties( $this->session_key, $iSurveyID, $aSurveyLocaleData, $sLanguage );
    }

    /**
     * TODO
     *
     * Set properties of a survey participant/token.
     *
     * Allow to set properties about a specific participant, only one particpant can be updated.
     *
     * @see    \Token for available properties
     *
     * @access public
     *
     * @param int       $iSurveyID             Id of the Survey that participants belong
     * @param array|int $aTokenQueryProperties of participant properties used to query the participant, or the token id as an integer
     * @param array     $aTokenData            Data to change
     *
     * @return array Result of the change action
     */
    public function set_participant_properties ( $iSurveyID, $aTokenQueryProperties, array $aTokenData = [] )
    {
        return $this->jsonRPCClient->set_participant_properties( $this->session_key, $iSurveyID, $aTokenQueryProperties, $aTokenData );
    }

    /**
     * TODO
     *
     * Set question properties.
     *
     * @see    \Question for available properties.
     *
     * Restricted properties:
     * * qid
     * * gid
     * * sid
     * * parent_qid
     * * language
     * * type
     * * question_order in some condition (with dependecies)
     *
     * @access public
     *
     * @param integer $iQuestionID   - ID of the question
     * @param array   $aQuestionData - An array with the particular fieldnames as keys and their values to set on that particular question
     * @param string  $sLanguage     Optional parameter language for multilingual questions
     *
     * @return array Of succeeded and failed modifications according to internal validation.
     */
    public function set_question_properties ( $iQuestionID, array $aQuestionData = [], $sLanguage )
    {
        return $this->jsonRPCClient->set_question_properties( $this->session_key, $iQuestionID, $aQuestionData, $sLanguage );
    }

    /**
     * TODO
     *
     * Set Quota Attributes
     * Retuns an array containing the boolean 'success' and 'message' with either errors or Quota attributes (on success)
     *
     * @access public
     *
     * @param integer $iQuotaId   Quota ID
     * @param array   $aQuotaData Quota attributes as array eg ['active'=>1,'limit'=>100]
     *
     * @return array ['success'=>bool, 'message'=>string]
     */
    public function set_quota_properties ( $iQuotaId, array $aQuotaData = [] )
    {
        return $this->jsonRPCClient->set_quota_properties( $this->session_key, $iQuotaId, $aQuotaData );
    }

    /**
     * TODO
     *
     * Set survey properties.
     *
     * @see    \Survey for the list of available properties
     * Properties available are restricted
     * * Always
     *     * sid
     *     * active
     *     * language
     *     * additional_languages
     * * If survey is active
     *     * anonymized
     *     * datestamp
     *     * savetimings
     *     * ipaddr
     *     * refurl
     *
     * In case of partial success : return an array with key as properties and value as boolean , true if saved with success.
     *
     * Failure status : Invalid survey ID, Invalid session key, No permission, No valid Data
     *
     * @access public
     *
     * @param integer $iSurveyID   - ID of the Survey
     * @param array   $aSurveyData - An array with the particular fieldnames as keys and their values to set on that particular Survey
     *
     * @return array Of succeeded and failed nodifications according to internal validation
     */
    public function set_survey_properties ( $iSurveyID, array $aSurveyData = [] )
    {
        return $this->jsonRPCClient->set_survey_properties( $this->session_key, $iSurveyID, $aSurveyData );
    }

    /**
     * TODO
     *
     * Update a response in a given survey.
     * Routine supports only single response updates.
     * Response to update will be identified either by the response id, or the token if response id is missing.
     * Routine is only applicable for active surveys with alloweditaftercompletion = Y.
     *
     * @access public
     *
     * @param int   $iSurveyID     Id of the Survey to update response
     * @param array $aResponseData The actual response
     *
     * @return string|boolean TRUE(bool) on success. errormessage on error
     */
    public function update_response ( $iSurveyID, array $aResponseData = [] )
    {
        return $this->jsonRPCClient->update_response( $this->session_key, $iSurveyID, $aResponseData );
    }

    /**
     * TODO
     *
     * Uploads one file to be used later.
     * Returns the metadata on success.
     *
     * @access public
     *
     * @param int    $iSurveyID    ID of the Survey to insert file
     * @param string $sFieldName   the Field to upload file
     * @param string $sFileName    the uploaded file name
     * @param string $sFileContent the uploaded file content encoded as BASE64
     *
     * @return array The file metadata with final upload path or error description
     */
    public function upload_file ( $iSurveyID, $sFieldName, $sFileName, $sFileContent )
    {
        return $this->jsonRPCClient->upload_file( $this->session_key, $iSurveyID, $sFieldName, $sFileName, $sFileContent );
    }
}
