<?php

namespace Absolvent\api\Http\Middleware;

use Closure;
use Riverline\MultiPartParser\Part;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use SplFileInfo;

/**
 * Class PreparePatchMultiPartForm
 *
 * Allows to process PATCH requests that has Content-Type of multipart/form-data
 *
 * @package Absolvent\AbsolventBackend\app\Http\Middleware
 */
class PreparePatchMultiPartForm
{
    /** @var string */
    private $content;

    public function __construct($content = 'php://input')
    {
        $this->content = $content === 'php://input' ? file_get_contents('php://input') : $content;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Closure                  $next
     *
     * @return mixed
     * @throws \InvalidArgumentException
     * @throws \LogicException
     */
    public function handle($request, Closure $next)
    {
        if ($request->getMethod() !== 'PATCH') {
            return $next($request);
        }

        $contentType = $request->headers->get('Content-Type');
        if (!starts_with($contentType, 'multipart/form-data;')) {
            return $next($request);
        }


        if (!$this->content) {
            return $next($request);
        }

        $document = new Part("Content-Type: $contentType\n\n{$this->content}");
        if (!$document->isMultiPart()) {
            return $next($request);
        }

        unset($this->content);

        foreach ($document->getParts() as $part) {
            $name = $part->getName();
            if ($part->isFile()) {
                $dir = ini_get('upload_tmp_dir');
                if (!$dir) {
                    $dir = sys_get_temp_dir();
                }
                $path = tempnam($dir, 'php-file-upload');
                file_put_contents($path, $part->getBody());
                $size = (new SplFileInfo($path))->getSize();
                $file = new UploadedFile($path, $part->getFileName(), $part->getMimeType(), $size, UPLOAD_ERR_OK, true);
                $request->files->set($name, $file);
                $_FILES[$name]['name'][] = $part->getFileName();
                $_FILES[$name]['type'][] = $part->getMimeType();
                $_FILES[$name]['error'][] = UPLOAD_ERR_OK;
                $_FILES[$name]['size'][] = $size;
                $_FILES[$name]['tmp_name'][] = $path;
            } else {
                $request->request->set($name, $part->getBody());
            }
        }

        unset($document);

        return $next($request);
    }
}
