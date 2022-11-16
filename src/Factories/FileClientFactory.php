<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Factories;

use Aws\Credentials\Credentials;
use Aws\S3\S3Client;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\Filesystem;
use League\Flysystem\Ftp\FtpAdapter;
use League\Flysystem\Ftp\FtpConnectionOptions;

final class FileClientFactory
{
    private const HOST = 'darwin-dist-44ae45.nationalrail.co.uk';

    private const S3_BUCKET = 'darwin.xmltimetable';
    private const S3_PREFIX = 'PPTimetable/';

    public function makeFtp(string $user, string $pass): Filesystem
    {
        $filesystem = new Filesystem(
            new FtpAdapter(
                FtpConnectionOptions::fromArray([
                    'host'     => self::HOST,
                    'root'     => '',
                    'username' => $user,
                    'password' => $pass,
                ])
            )
        );

        return $filesystem;
    }

    public function makeS3(string $key, string $secret): Filesystem
    {
        $credentials = new Credentials($key, $secret);

        $s3 = new S3Client([
            'version'     => 'latest',
            'region'      => 'eu-west-1',
            'credentials' => $credentials,
        ]);

        $filesystem = new Filesystem(
            new AwsS3V3Adapter(
                $s3,
                self::S3_BUCKET,
                self::S3_PREFIX
            )
        );

        return $filesystem;
    }
}
