<?php

namespace App\Jobs;

use App\Course;
use Carbon\Carbon;
// use FFMpeg;
use FFMpeg\Coordinate\Dimension;
// use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class ConvertVideoForDownloading implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $course;

    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    public function handle()
    {
        // create a video format...
        $lowBitrateFormat = (new X264)->setKiloBitrate(500);

        // open the uploaded video from the right disk...
        FFMpeg::fromDisk('videos_disk')
            ->open($this->course->videoPath)

            // add the 'resize' filter...
            ->addFilter(function ($filters) {
                $filters->resize(new Dimension(720, 540));
            })

            // call the 'export' method...
            ->export()

            // tell the MediaExporter to which disk and in which format we want to export...
            ->toDisk('downloadable_videos')
            ->inFormat($lowBitrateFormat)

            // call the 'save' method with a filename...
            ->save($this->course->id .'_'.$this->course->title .'_'.$this->course->tutor_id .'_'. '.mp4');
        // $ffmpeg = FFMpeg\FFMpeg::create(array(
        //     'ffmpeg.binaries' => '/opt/local/ffmpeg/bin/ffmpeg',
        //     'ffprobe.binaries' => '/opt/local/ffmpeg/bin/ffprobe',
        //     'timeout' => 3600, // The timeout for the underlying process
        //     'ffmpeg.threads' => 12, // The number of threads that FFMpeg should use
        // ), $logger);
        // update the database so we know the convertion is done!
        $this->video->update([
            'converted_for_downloading_at' => Carbon::now(),
        ]);
    }
}
