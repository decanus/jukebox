<?php

namespace Jukebox\Framework\Backends
{

    use TheSeer\DirectoryScanner\DirectoryScanner;
    use TheSeer\DirectoryScanner\IncludeExcludeFilterIterator;

    class FileBackend
    {
        /**
         * @param string $path
         *
         * @return string
         * @throws \Exception
         */
        public function load(string $path): string
        {
            if (!file_exists($path)) {
                throw new \Exception('File "' . $path . '" not found');
            }
            
            $handle = fopen($path, 'r');
            $content = stream_get_contents($handle, filesize($path));
            fclose($handle);
            
            return $content;
        }
        
        /**
         * @param string $path
         *
         * @return bool
         */
        public function exists(string $path): bool
        {
            return file_exists($path);
        }
        
        // @codeCoverageIgnoreStart
        /**
         * @param $path
         *
         * @return int
         */
        public function getFileModifiedTime(string $path): int
        {
            return filemtime($path);
        }
        
        /**
         * @param string $filename
         * @param string $content
         *
         * @throws \Exception
         */
        public function save(string $filename, string $content)
        {
            $result = file_put_contents($filename, $content);
            if ($result === false) {
                throw new \Exception('Could not save to file "' . $filename . '"');
            }
        }
        
        public function delete(string $filename): bool
        {
            if (!$this->exists($filename)) {
                return;
            }
            
            return unlink($filename);
        }
        
        /**
         * @param string $dirName
         * @param int    $chmod
         */
        public function makeDir(string $dirName, int $chmod = 0755)
        {
            mkdir($dirName, $chmod, true);
        }
        // @codeCoverageIgnoreEnd

        public function scanDirectory($path, $queries): IncludeExcludeFilterIterator
        {
            $scanner = new DirectoryScanner;
            foreach ($queries as $query) {
                $scanner->addInclude($query);
            }
            return $scanner($path);
        }


    }
}
