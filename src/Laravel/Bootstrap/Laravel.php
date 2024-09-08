<?php
namespace Plast\Laravel\Bootstrap;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\ApplicationBuilder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Plast\Image;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

readonly class Laravel
{
    public Application $application;

    public function __construct(string $laravelPath)
    {
        $_SERVER['APP_DEBUG'] = 'true';
        $builder = new ApplicationBuilder($this->app($laravelPath));
        $builder->withKernels();
        $builder->withExceptions();
        $builder->withRouting(function (): void {
            Route::get('/', fn() => view('index', [
                'uploadUrl' => route('images.store'),
                'images'    => \iterator_to_array($this->thumbnails()),
            ]))
                ->name('images.index');

            Route::get('/images/{name}', function (Request $request, string $name) {
                return $this->respondFile($this->path('images', $name));
            });

            Route::get('/thumbnails/{name}', function (Request $request, string $name) {
                return $this->respondFile($this->path('thumbnails', $name));
            });

            Route::get('/background.jpg', function () {
                return response()->file(public_path('background.jpg'));
            });

            Route::post('/upload', function (Request $request) {
                $request->validate([
                    'photos'   => 'required',
                    'photos.*' => 'max:10240',
                ]);
                if ($request->hasFile('photos')) {
                    $image = new Image();
                    foreach ($request->file('photos') as $photo) {
                        $filename = \uniqId() . '.' . $photo->extension();
                        $photo->move(public_path('originals'), $filename);
                        $this->saveInOptimalFormat($image, $filename);
                    }
                }
                return redirect()
                    ->back()
                    ->with('success', 'File has been uploaded');
            })
                ->name('images.store');
        });
        $this->application = $builder->create();
    }

    private function respondFile(string $path): BinaryFileResponse|Response
    {
        if (\file_exists($path)) {
            return response()->file($path);
        }
        return response(status:404);
    }

    private function app(string $laravelPath): Application
    {
        return new NamespaceApplication(
            $laravelPath,
            'Plast\Laravel\\',
            \dirName(__DIR__));
    }

    private function thumbnails(): iterable
    {
        $fileNames = \scanDir(public_path('thumbnails'));
        foreach (\array_reverse($fileNames) as $fileName) {
            if (\in_array($fileName, ['.', '..'], true)) {
                continue;
            }
            yield "thumbnails/$fileName";
        }
    }

    private function path(string $publicPath, string $filename): string
    {
        return public_path($publicPath) . DIRECTORY_SEPARATOR . $filename;
    }

    private function saveInOptimalFormat(Image $image, string $filename): void
    {
        $this->createThumbnailsAndCovertWebp($image,
            $filename,
            $this->mapExtension($filename, 'webp'));
    }

    private function createThumbnailsAndCovertWebp(Image $image, string $fileOriginal, string $fileWebp): void
    {
        $image->saveAsWebp(
            $this->path('originals', $fileOriginal),
            $this->path('thumbnails', $fileWebp),
            $this->path('images', $fileWebp));
    }

    private function mapExtension(string $filename, string $extension): string
    {
        $extensionLength = \strLen(\pathInfo($filename, \PATHINFO_EXTENSION));
        return \subStr($filename, 0, -$extensionLength) . $extension;
    }
}
