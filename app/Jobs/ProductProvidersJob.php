<?php

namespace App\Jobs;

use App\Services\ProductProviders\ProductProviderManager;

class ProductProvidersJob extends Job
{
    protected $parameters;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ProductProviderManager $manager)
    {
        $manager->dispatch($this->parameters);
    }
}
