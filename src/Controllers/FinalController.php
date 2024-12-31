<?php

namespace MtdVision\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use MtdVision\LaravelInstaller\Events\LaravelInstallerFinished;
use MtdVision\LaravelInstaller\Helpers\EnvironmentManager;
use MtdVision\LaravelInstaller\Helpers\FinalInstallManager;
use MtdVision\LaravelInstaller\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param  \MtdVision\LaravelInstaller\Helpers\InstalledFileManager  $fileManager
     * @param  \MtdVision\LaravelInstaller\Helpers\FinalInstallManager  $finalInstall
     * @param  \MtdVision\LaravelInstaller\Helpers\EnvironmentManager  $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        event(new LaravelInstallerFinished);

        return view('vendor.installer.finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
