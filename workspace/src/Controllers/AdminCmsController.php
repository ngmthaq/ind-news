<?php

namespace Src\Controllers;

use Src\Repos\FeatureRepoInterface;

class AdminCmsController extends Controller
{
    protected FeatureRepoInterface $featureRepo;

    public function __construct(FeatureRepoInterface $featureRepo)
    {
        $this->featureRepo = $featureRepo;
    }
}
