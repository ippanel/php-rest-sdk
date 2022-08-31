<?php

namespace IPPanel\Errors;


abstract class ResponseCodes
{
    const ErrForbidden = 403;
    const ErrNotFound = 404;
    const ErrUnprocessableEntity = 422;
    const ErrInternalServer = 500;
}
