<?php
// use Str;

function get_db_config()
{
    if (getenv('IS_IN_HEROKU')) {

        $url_pgsql = parse_url(getenv('DATABASE_URL'));

        $url_redis = parse_url(getenv('REDIS_URL'));

        return $db_config = [
            'db' => [
                'connection' => 'pgsql',
                'host'       => $url_pgsql['host'],
                'database'   => substr($url_pgsql['path'], 1),
                'username'   => $url_pgsql['user'],
                'password'   => $url_pgsql['pass'],
                'port'       => $url_pgsql['port'],
            ],
            'redis' => [
                'client'   => 'predis',
                'host'     => $url_redis['host'],
                'port'     => $url_redis['port'],
                'username' => $url_redis['user'],
                'password' => $url_redis['pass']
            ],
        ];

    } else {
        return $db_config = [
            'db' => [
                'connection' => env('DB_CONNECTION', 'mysql'),
                'host'       => env('DB_HOST', 'localhost'),
                'database'   => env('DB_DATABASE', 'forge'),
                'username'   => env('DB_USERNAME', 'forge'),
                'password'   => env('DB_PASSWORD', ''),
                'port'       => env('DB_PORT', 3306)
            ],
            'redis' => [
                'client' => env('REDIS_CLIENT', 'phpredis'),
                'host' => env('REDIS_HOST', '127.0.0.1'),
                'port' => env('REDIS_PORT', 6379),
                'username' => null,
                'password' => env('REDIS_PASSWORD', null),
            ],
        ];
    }
}

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function category_nav_active($category_id)
{
    return active_class((if_route('categories.show') && if_route_param('category', $category_id)));
}

function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return Str::limit($excerpt, $length);
}

function model_admin_link($title, $model)
{
    return model_link($title, $model, 'admin');
}

function model_link($title, $model, $prefix='')
{
    $model_name = model_plural_name($model);

    $prefix = $prefix ? "/$prefix/" : "/";

    $url = config('app.url') . $prefix . $model_name . "/" . $model->id;

    return '<a href="' . $url . '" target="_blank">' . $title . '</a>';
}

function model_plural_name($model)
{
    $full_class_name = get_class($model);

    $class_name = class_basename($full_class_name);

    $snake_case_name = Str::snake($class_name);

    return Str::plural($snake_case_name);
}
