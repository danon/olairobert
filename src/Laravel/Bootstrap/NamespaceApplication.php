<?php
namespace Plast\Laravel\Bootstrap;

use function Illuminate\Filesystem\join_paths;

class NamespaceApplication extends \Illuminate\Foundation\Application
{
    public function __construct(
        string $laravelFileSystemPath,
        string $laravelClassesNamespace,
        string $laravelClassesPath)
    {
        parent::__construct($laravelFileSystemPath);
        $this->namespace = $laravelClassesNamespace;
        $this->useAppPath($laravelClassesPath);
    }

    public function getCachedServicesPath(): string
    {
        return "$this->basePath/storage/bootstrap/cache/services.php";
    }

    public function getCachedPackagesPath(): string
    {
        return "$this->basePath/storage/bootstrap/cache/packages.php";
    }

    public function resourcePath($path = ''): string
    {
        return join_paths($this->appPath, 'resources', $path);
    }
}
