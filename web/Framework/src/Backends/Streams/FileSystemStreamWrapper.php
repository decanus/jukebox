<?php

namespace Jukebox\Framework\Backends\Streams
{

    abstract class FileSystemStreamWrapper implements StreamWrapperInterface
    {
        private $file_handle = null;
        private $dir_handle = null;

        private static $basedir;

        public static function setUp($dir)
        {
            static::$basedir = $dir;
            stream_wrapper_register(static::getProtocol(), get_called_class());
        }

        public static function tearDown()
        {
            stream_wrapper_unregister(static::getProtocol());
        }

        public function dir_closedir(): bool
        {
            closedir($this->dir_handle);
            $this->dir_handle = null;
            return true;
        }

        public function dir_opendir(string $path, int $options): bool
        {
            $this->dir_handle = opendir($this->translate($path));
            return is_resource($this->dir_handle);
        }

        public function dir_readdir(): string
        {
            return readdir($this->dir_handle);
        }

        public function dir_rewinddir(): bool
        {
            $result = is_resource($this->dir_handle);
            rewinddir($this->dir_handle);
            return $result;
        }

        public function mkdir(string $path, int $mode, int $options): bool
        {
            return mkdir($this->translate($path), $mode, $options);
        }

        public function rename(string $path_from, string $path_to): bool
        {
            return rename($this->translate($path_from), $this->translate($path_to));
        }

        public function rmdir(string $path, int $options): bool
        {
            return rmdir($this->translate($path), $options);
        }

        public function stream_cast(int $cast_as)
        {
            // TODO: Implement stream_cast() method.
        }

        public function stream_close()
        {
            fclose($this->file_handle);
            $this->file_handle = null;
        }

        public function stream_eof(): bool
        {
            return feof($this->file_handle);
        }

        public function stream_flush(): bool
        {
            return fflush($this->file_handle);
        }

        public function stream_lock(int $operation): bool
        {
            return flock($this->file_handle, $operation);
        }

        public function stream_metadata(string $path, int $option, $value)
        {
            switch ($option) {
                case STREAM_META_ACCESS:
                    return chmod($this->translate($path), $value);
                case STREAM_META_GROUP:
                case STREAM_META_GROUP_NAME:
                    return chgrp($this->translate($path), $value);
                case STREAM_META_OWNER:
                case STREAM_META_OWNER_NAME:
                    return chown($this->translate($path), $value);
                case STREAM_META_TOUCH:
                    array_unshift($value, $this->translate($path));
                    return call_user_func_array('touch', $value);
            }

            return false;
        }

        public function stream_open(string $path, string $mode, int $options, string &$opened_path): bool
        {
            $this->file_handle = fopen($this->translate($path), $mode, $options);
            return $this->file_handle !== false;
        }

        public function stream_read(int $count): string
        {
            return fread($this->file_handle, $count);
        }

        public function stream_seek(int $offset, int $whence = SEEK_SET): bool
        {
            return fseek($this->file_handle, $offset, $whence);
        }

        public function stream_set_option(int $option, int $arg1, int $arg2): bool
        {
            // TODO: Implement stream_set_option() method.
        }

        public function stream_stat(): array
        {
            return fstat($this->file_handle);
        }

        public function stream_tell(): int
        {
            return ftell($this->file_handle);
        }

        public function steam_truncate(int $new_size): bool
        {
            return ftruncate($this->file_handle, $new_size);
        }

        public function stream_write(string $data): int
        {
            return fwrite($this->file_handle, $data);
        }

        public function unlink(string $path): bool
        {
            return unlink($this->translate($path));
        }

        public function url_stat(string $path, int $flags)
        {
            $filename = $this->translate($path);

            if (!file_exists($filename)) {
                return false;
            }

            return stat($filename);
        }

        abstract protected function getProtocol(): string;

        private function translate(string $path): string
        {
            return static::$basedir . '/' . explode('://', $path)[1];
        }
    }
}
