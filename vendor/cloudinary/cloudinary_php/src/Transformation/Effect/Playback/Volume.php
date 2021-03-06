<?php
/**
 * This file is part of the Cloudinary PHP package.
 *
 * (c) Cloudinary
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cloudinary\Transformation;

use Cloudinary\Utils;

/**
 * Controls the volume of an audio or video file.
 *
 * **Learn more**: <a
 * href="https://cloudinary.com/documentation/audio_transformations#adjust_the_audio_volume" target="_blank">
 * Adjust the audio volume</a>
 *
 * @api
 */
class Volume extends LimitedEffectParam
{
    const MUTE = 'mute';

    /**
     * Volume constructor.
     *
     * @param       $volume
     */
    public function __construct($volume = null)
    {
        parent::__construct(PlaybackEffect::VOLUME, EffectRange::AUDIO_VOLUME);

        $this->setVolume($volume);
    }

    /**
     * Increases or decreases the volume by the specified number of decibels.
     *
     * @param int $dBOffset The offset in dB.
     *
     * @return Volume
     */
    public function offset($dBOffset)
    {
        return $this->setVolume(Utils::formatSigned($dBOffset) . 'dB');
    }

    /**
     * Increases or decreases the volume by a percentage of the current volume.
     *
     * @param int $level The percentage change of volume (Range: -100 to 400).
     *
     * @return Volume
     */
    public function relative($level)
    {
        return $this->setVolume($level);
    }

    /**
     * Mutes the volume.
     *
     * You can use this on the base video to deliver a video without sound, or with a video overlay
     * to ensure that only the sound from the base video plays.
     *
     * @return Volume
     */
    public function mute()
    {
        return $this->setVolume(self::MUTE);
    }

    /**
     * Increases or decreases the volume by a percentage of the current volume.
     *
     * @param int $value The percentage change of volume (Range: -100 to 400).
     *
     * @return Volume
     */
    protected function setVolume($value)
    {
        $this->value->setSimpleValue('volume', $value);

        return $this;
    }
}
