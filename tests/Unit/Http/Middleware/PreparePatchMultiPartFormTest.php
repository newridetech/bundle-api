<?php

namespace Absolvent\api\tests\Unit\Http\Middleware;

use Absolvent\api\Http\Middleware\PreparePatchMultiPartForm;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

final class PreparePatchMultiPartFormTest extends TestCase
{
    public function testPathWithMultipartFormData()
    {
        $request = new Request();
        $request->setMethod('PATCH');
        $request->headers->set('Content-Type', 'multipart/form-data; boundary=---------------------------9051914041544843365972754266');

        $nextCalled = false;

        $stream = "
-----------------------------9051914041544843365972754266
Content-Disposition: form-data; name=\"text\"

text default
-----------------------------9051914041544843365972754266
Content-Disposition: form-data; name=\"file1\"; filename=\"a.txt\"
Content-Type: text/plain

Content of a.txt.

-----------------------------9051914041544843365972754266
Content-Disposition: form-data; name=\"file2\"; filename=\"a.html\"
Content-Type: text/html

<!DOCTYPE html><title>Content of a.html.</title>

-----------------------------9051914041544843365972754266--
";

        $middleware = new PreparePatchMultiPartForm($stream);
        $middleware->handle($request, function () use (&$nextCalled) {
            $nextCalled = true;
        });

        self::assertSame('text default', $request->request->get('text'));
        self::assertNotNull($request->files->get('file1'));
        self::assertNotNull($request->files->get('file2'));

        self::assertTrue($nextCalled);
    }
}
