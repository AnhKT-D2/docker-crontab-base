<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * ErrorType enum.
 */
class ErrorType extends BaseEnum
{

    const STATUS_200 = 200;

    const STATUS_500 = 500;

    const CODE_4000 = '4000';
    const STATUS_4000 = 400;

    // Authentication failed
    const CODE_4010 = '4010';
    const STATUS_4010 = 401;

    // Token has expired
    const CODE_4011 = '4011';
    const STATUS_4011 = 401;

    // email invite has expired
    const CODE_4014 = '4014';
    const STATUS_4014 = 401;

    // Token is invalid
    const CODE_4012 = '4012';
    const STATUS_4012 = 401;

    // Token is already used
    const CODE_4013 = '4013';
    const STATUS_4013 = 401;

    // Not authorized
    const CODE_4030 = '4030';
    const STATUS_4030 = 403;

    // Access denied
    const CODE_4031 = '4031';
    const STATUS_4031 = 403;

    // Blocked
    const CODE_4032 = '4032';
    const STATUS_4032 = 403;

    // Data duplicate on unique column
    const CODE_4033 = '4033';
    const STATUS_4033 = 403;

    // No account
    const CODE_4040 = '4040';
    const STATUS_4040 = 404;

    // No data
    const CODE_4041 = '4041';
    const STATUS_4041 = 404;

    // Not logged in
    const CODE_4042 = '4042';
    const STATUS_4042 = 404;

    // Invalid HTTP method
    const CODE_4050 = '4050';
    const STATUS_4050 = 405;

    // This process has been already executed
    const CODE_4090 = '4090';
    const STATUS_4090 = 409;

    //The account cannot be registered
    const CODE_4091 = '4091';
    const STATUS_4091 = 409;

    // Validation error
    const CODE_4220 = '4220';
    const STATUS_4220 = 422;

    // Another user is operating
    const CODE_4230 = '4230';
    const STATUS_4230 = 423;

    // System error
    const CODE_5000 = '5000';
    const STATUS_5000 = 500;

    // Unexpected error
    const CODE_5001 = '5001';
    const STATUS_5001 = 500;

    // DB error
    const CODE_5002 = '5002';
    const STATUS_5002 = 500;

    // Registration failed
    const CODE_5003 = '5003';
    const STATUS_5003 = 500;

    // Update failed
    const CODE_5004 = '5004';
    const STATUS_5004 = 500;

    // Deletion failed
    const CODE_5005 = '5005';
    const STATUS_5005 = 500;

    // Settlement failed
    const CODE_5006 = '5006';
    const STATUS_5006 = 500;

    // Data has been changed by another user
    const CODE_5007 = '5007';
    const STATUS_5007 = 500;

}
