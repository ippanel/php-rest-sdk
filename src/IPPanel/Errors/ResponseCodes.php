<?php

namespace IPPanel\Errors;


abstract class ResponseCodes
{
    /**
     * Error when executing repository query
     * @var string
     */
    const ErrCredential = '10001';

    /**
     * Message body is empty 
     * @var string
     */
    const ErrMessageBodyIsEmpty = "10002";


    /**
     * User is limited
     * @var string
     */
    const ErrUserLimited = "10003";

    /**
     * Number not assigned to you
     * @var string
     */
    const ErrNumberNotAssignedToYou = "10004";


    /**
     * recipients is empty
     * @var string
     */
    const ErrRecipientsEmpty = "10005";

    /**
     * Credit not enough
     * @var string
     */
    const ErrCreditNotEnough = "10006";

    /**
     * Number not profit for bulk send
     * @var string
     */
    const ErrNumberNotProfitForBulkSend = "10007";

    /**
     * Number deactivated temporally
     * @var string
     */
    const ErrNumberDeactiveTemp = "10008";

    /**
     * Maximum recipients number exceeded
     * @var string
     */
    const ErrMaximumRecipientExceeded = "10009";

    /**
     * Gateway is offline
     * @var string
     */
    const ErrGatewayOffline = "10010";

    /**
     * Pricing not defined for user
     * @var string
     */
    const ErrNoPricing = "10011";

    /**
     * Ticket is invalid
     * @var string
     */
    const ErrTicketIsInvalid = "10012";

    /**
     * Access denied
     * @var string
     */
    const ErrAccessDenied = "10013";

    /**
     * Pattern is invalid
     * @var string
     */
    const ErrPatternIsInvalid = "10014";

    /**
     * Pattern parameters is invalid
     * @var string
     */
    const ErrPatternParamettersInvalid = "10015";

    /**
     * Pattern is inactive
     * @var string
     */
    const ErrPatternIsInactive = "10016";

    /**
     * Pattern recipient invalid
     * @var string
     */
    const ErrPatternRecipientInvalid = "10017";

    /**
     * Send time is 8-23
     * @var string
     */
    const ErrItsTimeToSleep = "10019";

    /**
     * One/all of users documents not approved
     * @var string
     */
    const ErrDocumentsNotApproved = "10021";

    /**
     * Internal error
     * @var string
     */
    const ErrInternal = "10022";

    /**
     * Number not found
     * @var string
     */
    const ErrNumberNotFound = "10023";

    /**
     * Gateway disabled
     * @var string
     */
    const ErrGatewayDisabled = "10024";

    /**
     * Inputs have some problems
     * @var string
     */
    const ErrUnprocessableEntity = "422";

    /**
     * Unauthorized
     * @var string
     */
    const ErrUnauthorized = "1401";

    /**
     * Api key is not valid
     * @var string
     */
    const ErrKeyNotValid = "1402";

    /**
     * Api key revoked
     * @var string
     */
    const ErrKeyRevoked = "1403";
}
