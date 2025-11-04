<?php

// config/ip.php

return [

    /*
    |--------------------------------------------------------------------------
    | Intellectual Property Configuration
    |--------------------------------------------------------------------------
    */

    'notification' => [
        // Enable/disable notifications
        'enabled' => env('IP_NOTIFICATIONS_ENABLED', true),
        
        // Notify admin on new registrations
        'notify_admin_on_registration' => env('IP_NOTIFY_ADMIN', true),
        
        // Admin email for notifications
        'admin_email' => env('IP_ADMIN_EMAIL', 'admin@thonburi-culture.test'),
        
        // Days before expiry to send notifications
        'expiry_warning_days' => [30, 15, 7, 1],
    ],

    'registration' => [
        // Auto-generate registration numbers
        'auto_generate_number' => env('IP_AUTO_GENERATE_NUMBER', true),
        
        // Registration number prefix
        'number_prefix' => env('IP_NUMBER_PREFIX', 'IP'),
        
        // Registration number format
        'number_format' => '{prefix}-{type}-{year}-{sequence}',
        
        // Require admin approval for registration
        'require_approval' => env('IP_REQUIRE_APPROVAL', true),
    ],

    'storage' => [
        // Disk for file storage
        'disk' => env('IP_STORAGE_DISK', 'public'),
        
        // Directory for attachments
        'path' => 'intellectual-properties',
        
        // Maximum file size (in KB)
        'max_file_size' => env('IP_MAX_FILE_SIZE', 10240), // 10MB
        
        // Allowed file types
        'allowed_mimes' => [
            'pdf',
            'doc',
            'docx',
            'jpg',
            'jpeg',
            'png',
            'zip',
        ],
        
        // Maximum number of attachments per IP
        'max_attachments' => env('IP_MAX_ATTACHMENTS', 10),
    ],

    'expiry' => [
        // Enable auto-expiry
        'auto_expire_enabled' => env('IP_AUTO_EXPIRE_ENABLED', true),
        
        // Default expiry period (in years) for each type
        'default_periods' => [
            'copyright' => 50,
            'patent' => 20,
            'trademark' => 10,
            'local_wisdom' => null, // No expiry
            'trade_secret' => null, // No expiry
            'other' => 10,
        ],
    ],

    'pagination' => [
        // Default number of items per page
        'per_page' => env('IP_PER_PAGE', 15),
        
        // Maximum items per page
        'max_per_page' => env('IP_MAX_PER_PAGE', 100),
    ],

    'search' => [
        // Enable full-text search
        'full_text_search' => env('IP_FULL_TEXT_SEARCH', true),
        
        // Minimum search term length
        'min_search_length' => 3,
        
        // Search result limit
        'search_limit' => 50,
    ],

    'security' => [
        // Enable rate limiting
        'rate_limit_enabled' => env('IP_RATE_LIMIT_ENABLED', true),
        
        // Rate limit: requests per minute
        'rate_limit' => env('IP_RATE_LIMIT', 60),
        
        // Enable audit logging
        'audit_enabled' => env('IP_AUDIT_ENABLED', true),
    ],

    'cache' => [
        // Cache duration (in minutes)
        'ttl' => env('IP_CACHE_TTL', 60),
        
        // Cache key prefix
        'prefix' => 'ip',
        
        // Enable caching for list queries
        'enable_list_cache' => env('IP_CACHE_LIST', true),
    ],

];

// ============================================
// .env.example additions
// ============================================

/*

# Intellectual Property Configuration
IP_NOTIFICATIONS_ENABLED=true
IP_NOTIFY_ADMIN=true
IP_ADMIN_EMAIL=admin@thonburi-culture.test

IP_AUTO_GENERATE_NUMBER=true
IP_NUMBER_PREFIX=IP
IP_REQUIRE_APPROVAL=true

IP_STORAGE_DISK=public
IP_MAX_FILE_SIZE=10240
IP_MAX_ATTACHMENTS=10

IP_AUTO_EXPIRE_ENABLED=true
IP_PER_PAGE=15
IP_MAX_PER_PAGE=100

IP_FULL_TEXT_SEARCH=true
IP_RATE_LIMIT_ENABLED=true
IP_RATE_LIMIT=60
IP_AUDIT_ENABLED=true

IP_CACHE_TTL=60
IP_CACHE_LIST=true

*/

