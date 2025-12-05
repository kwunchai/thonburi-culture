@echo off
cd c:\laragon\www\thonburi-culture
echo Checking activities table structure...
php artisan tinker --execute="use Illuminate\Support\Facades\Schema; \$columns = Schema::getColumnListing('activities'); foreach(\$columns as \$column) { echo \$column . PHP_EOL; }"