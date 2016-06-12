<?php

namespace Jukebox\Backend\Commands
{

    use Jukebox\Framework\ValueObjects\Sources\Source;

    class InsertTrackSourceCommand extends AbstractDatabaseBackendCommand
    {
        public function execute(int $track, Source $source, string $sourceData, int $duration): bool
        {
            return $this->getDatabaseBackend()->execute(
                'INSERT INTO track_sources (track, duration, source, source_data) VALUES(:track, :duration, :source, :source_data)',
                [':track' => $track, ':duration' => $duration, ':source' => (string) $source, ':source_data' => $sourceData]
            );
        }
    }
}
