<?php

// System success code
const CODE_SUCCESS_200 = 200;
const CODE_SUCCESS_201 = 201;
const CODE_SUCCESS_203 = 203;
const CODE_SUCCESS_204 = 204;

// System error code
const CODE_ERROR_400 = 400;
const CODE_ERROR_401 = 401;
const CODE_ERROR_403 = 403;
const CODE_ERROR_404 = 404;
const CODE_ERROR_500 = 500;

const SORT_BY_ASC = 'asc';
const SORT_BY_DESC = 'desc';

// Status message
const MESSAGE_ERROR = 'danger';
const MESSAGE_WARNING = 'warning';
const MESSAGE_SUCCESS = 'success';

/**
 * Const status confirm email
 */
const TENTATIVE = 1;
const ENABLED = 2;

/**
 * status_room
 */
const STATUS_AVAILABLE = 1;
const STATUS_NOT_AVAILABLE = 2;

/**
 * status_room_user
 */
const STATUS_APPROVE = 1;
const STATUS_REJECT = 2;

const PER_PAGE = 10;

// Filesystem
define("LOCAL_PUBLIC_FOLDER", env('LOCAL_PUBLIC_FOLDER', '/uploads'));
