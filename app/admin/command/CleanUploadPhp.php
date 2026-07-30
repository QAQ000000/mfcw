<?php

namespace app\admin\command;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use think\console\Command;
use think\console\Input;
use think\console\input\Option;
use think\console\Output;
use UnexpectedValueException;

class CleanUploadPhp extends Command
{
    protected function configure()
    {
        $this->setName('security:clean-upload-php')
            ->setDescription('Scan public/upload for PHP-related files; use --delete to remove them')
            ->addOption('delete', null, Option::VALUE_NONE, 'Delete matched files instead of only listing them');
    }

    protected function execute(Input $input, Output $output)
    {
        $uploadRoot = CMF_ROOT . 'public/upload';
        $files = $this->findPhpFiles($uploadRoot);
        if (empty($files)) {
            $output->writeln('No PHP-related files found under public/upload.');
            return 0;
        }

        $delete = (bool) $input->getOption('delete');
        foreach ($files as $file) {
            $relativePath = ltrim(substr($file, strlen($uploadRoot)), DIRECTORY_SEPARATOR);
            $output->writeln(($delete ? 'DELETE ' : 'FOUND  ') . $relativePath);
        }
        if (!$delete) {
            $output->writeln(sprintf('%d file(s) found. Re-run with --delete to remove them.', count($files)));
            return 0;
        }

        $failed = $this->deleteFiles($files);
        if (!empty($failed)) {
            foreach ($failed as $file) {
                $output->writeln('FAILED ' . $file);
            }
            return 1;
        }
        $output->writeln(sprintf('%d file(s) deleted.', count($files)));
        return 0;
    }

    private function findPhpFiles($root)
    {
        if (!is_dir($root)) {
            return [];
        }
        try {
            $directory = new RecursiveDirectoryIterator(
                $root,
                RecursiveDirectoryIterator::SKIP_DOTS
            );
            $iterator = new RecursiveIteratorIterator(
                $directory,
                RecursiveIteratorIterator::LEAVES_ONLY,
                RecursiveIteratorIterator::CATCH_GET_CHILD
            );
        } catch (UnexpectedValueException $exception) {
            return [];
        }

        $files = [];
        foreach ($iterator as $file) {
            if (!$file->isFile() && !$file->isLink()) {
                continue;
            }
            if (preg_match('/\.(?:php[^.]*|phtml|phtm?|phar)(?:\.|$)/i', $file->getFilename())) {
                $files[] = $file->getPathname();
            }
        }
        sort($files, SORT_STRING);
        return $files;
    }

    private function deleteFiles(array $files)
    {
        $failed = [];
        foreach ($files as $file) {
            if ((!is_file($file) && !is_link($file)) || !@unlink($file)) {
                $failed[] = $file;
            }
        }
        return $failed;
    }
}
