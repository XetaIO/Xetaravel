<?php
namespace XetaravelInstaller;

use Composer\Script\Event;
use Exception;
use Illuminate\Support\Facades\Hash;

/**
 * Provides installation hooks for when Xetaravel is installed via
 * composer.
 */
class Installer
{
    public static function postInstall(Event $event)
    {
        $io = $event->getIO();
        $io->write("<info>
  __          __  _
  \ \        / / | |
   \ \  /\  / /__| | ___ ___  _ __ ___   ___
    \ \/  \/ / _ \ |/ __/ _ \| '_ ` _ \ / _ \
     \  /\  /  __/ | (_| (_) | | | | | |  __/
      \/  \/ \___|_|\___\___/|_| |_| |_|\___|

                   _
                  | |
                  | |_ ___
                  | __/ _ \
                  | || (_) |
                   \__\___/

  __   __    _                            _
  \ \ / /   | |                          | |
   \ V / ___| |_ __ _ _ __ __ ___   _____| |
    > < / _ \ __/ _` | '__/ _` \ \ / / _ \ |
   / . \  __/ || (_| | | | (_| |\ V /  __/ |
  /_/ \_\___|\__\__,_|_|  \__,_| \_/ \___|_|

        </info>");
        $rootDir = base_path();

        static::createEnvTesting($rootDir, $io);
        static::configDatabase($rootDir, $io);
    }

    /**
     * Create the .env.testing file if it does not exist.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     *
     * @return void
     */
    public static function createEnvTesting($dir, $io)
    {
        $env = $dir . '/.env.testing';
        $defaultEnv = $dir . '/.env.testing.exemple';

        if (!file_exists($env)) {
            copy($defaultEnv, $env);
            $io->write('<info>Created `.env.testing` file.</info>');
        }
    }

    /**
     * Set the database value in the application's env file.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     *
     * @return void
     */
    public static function configDatabase($dir, $io)
    {
        $env = $dir . '/.env';
        $content = file_get_contents($env);

        $databaseName = $io->ask('What is the database host ? ', 'localhost');
        $content = str_replace('__XETARAVEL_DATABASE_HOST__', $databaseName, $content, $count);

        $databaseName = $io->ask('What is the database name ? ', 'xetaravel_dev');
        $content = str_replace('__XETARAVEL_DATABASE_NAME__', $databaseName, $content, $count);

        $databaseName = $io->ask('What is the database username ? ', 'xetaravel');
        $content = str_replace('__XETARAVEL_DATABASE_USERNAME__', $databaseName, $content, $count);

        $databaseName = $io->ask('What is the database password ? ', 'secret');
        $content = str_replace('__XETARAVEL_DATABASE_PASSWORD__', $databaseName, $content, $count);

        if ($count == 0) {
            $io->writeError('<warning>No database placeholder to replace in the `.env` file.</warning>');

            return;
        }

        $result = file_put_contents($env, $content);
        if ($result) {
            $io->write('<info>Updated database information in `.env`.</info>');

            return;
        }
        $io->writeError('<warning>Unable to update database information in `.env`.</warning>');
    }
}
