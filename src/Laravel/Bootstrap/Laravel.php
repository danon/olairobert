<?php
namespace Plast\Laravel\Bootstrap;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\ApplicationBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
                'images'    => $this->images(),
            ]))
                ->name('images.index');

            Route::get('/images2/{name}', function (Request $request, string $name) {
                return response()->file(public_path('images') . DIRECTORY_SEPARATOR . $name);
            });

            Route::post('/upload', function (Request $request) {
                $request->validate(['image' => 'required|image|mimes:jpeg,jpg,png|max:10240']);
                $imageName = \time() . '.' . $request->file('image')->extension();
                $request->image->move(public_path('images'), $imageName);
                return redirect()
                    ->back()
                    ->with('success', 'File has been uploaded');
            })
                ->name('images.store');
        });
        $this->application = $builder->create();
    }

    private function app(string $laravelPath): Application
    {
        return new NamespaceApplication(
            $laravelPath,
            'Plast\Laravel\\',
            \dirName(__DIR__));
    }

    private function images(): iterable
    {
        $fileNames = \scanDir(public_path('images'));
        foreach (\array_reverse($fileNames) as $fileName) {
            if (\in_array($fileName, ['.', '..'], true)) {
                continue;
            }
            yield "images2/$fileName";
        }
    }
}
