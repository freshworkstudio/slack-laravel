<?php

namespace Maknz\Slack\Laravel;

use Maknz\Slack\Client as Client;
use GuzzleHttp\Client as Guzzle;

class ServiceProviderLaravel5 extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__.'/config/config.php' => config_path('slack.php')]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/config.php', 'slack');

        $this->app->bind(Client::class, function ($app) {
            return new Client(
                config('slack.endpoint'),
                [
                    'channel' => config('slack.channel'),
                    'username' => config('slack.username'),
                    'icon' => config('slack.icon'),
                    'link_names' => config('slack.link_names'),
                    'unfurl_links' => config('slack.unfurl_links'),
                    'unfurl_media' => config('slack.unfurl_media'),
                    'allow_markdown' => config('slack.allow_markdown'),
                    'markdown_in_attachments' => config('slack.markdown_in_attachments'),
                ],
                new Guzzle
            );
        });

    }
}
