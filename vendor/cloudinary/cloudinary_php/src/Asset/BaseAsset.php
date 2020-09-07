<?php
/**
 * This file is part of the Cloudinary PHP package.
 *
 * (c) Cloudinary
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cloudinary\Asset;

use Cloudinary\ArrayUtils;
use Cloudinary\ClassUtils;
use Cloudinary\Configuration\AccountConfig;
use Cloudinary\Configuration\AssetConfigTrait;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Configuration\UrlConfig;
use Cloudinary\JsonUtils;
use Cloudinary\StringUtils;

/**
 * Class BaseAsset
 *
 * @api
 */
abstract class BaseAsset implements AssetInterface
{
    /**
     * @var string $assetType The type of the asset.
     */
    protected static $assetType;

    use AssetDescriptorTrait;
    use AssetConfigTrait;

    use DeliveryTypeTrait;
    use AssetFinalizerTrait;

    // Asset Configuration

    /**
     * @var AccountConfig $account The configuration of the account.
     */
    public $account;

    /**
     * @var UrlConfig $urlConfig The configuration of the URL.
     */
    public $urlConfig;

    /**
     * @var AssetDescriptor $asset The asset descriptor.
     */
    public $asset;

    /**
     * @var AuthToken $authToken The authentication token.
     */
    public $authToken;

    /**
     * @var array A list of the delivery types that support SEO suffix.
     */
    protected static $suffixSupportedDeliveryTypes = [];

    /**
     * BaseAsset constructor.
     *
     * @param       $source
     * @param mixed $configuration
     */
    public function __construct($source, $configuration = null)
    {
        if ($source instanceof $this) { // copy constructor
            $this->deepCopy($source);

            return;
        }

        if ($source instanceof self) { // here comes conversion
            // TODO: discuss configuration transfer
            $this->asset = clone $source->asset;

            $this->account   = clone $source->account;
            $this->urlConfig = clone $source->urlConfig;
            $this->authToken = clone $source->authToken;
            return;
        }

        if ($source instanceof AssetDescriptor) {
            $this->asset = clone $source;
        } else {
            $assetType   = static::getAssetType($this);
            $this->asset = new AssetDescriptor($source, $assetType);
        }

        if ($configuration === null) {
            $configuration = Configuration::instance(); // get global instance
        }

        $this->configuration($configuration);

        $this->authToken = new AuthToken($configuration);
    }

    /**
     * Internal method that returns the asset type of the current object.
     *
     * @param self|string $class The instance of the object.
     *
     * @return string
     *
     * @internal
     */
    protected static function getAssetType($class)
    {
        if (isset(static::$assetType)) {
            return static::$assetType;
        }

        if (! is_string($class)) {
            $class = ClassUtils::getClassName($class);
        }

        return StringUtils::camelCaseToSnakeCase(ClassUtils::getBaseName($class));
    }

    /**
     * Internal getter for a list of the delivery types that support SEO suffix.
     *
     * @return array
     *
     * @internal
     */
    public static function getSuffixSupportedDeliveryTypes()
    {
        return static::$suffixSupportedDeliveryTypes;
    }

    /**
     * Performs a deep copy from another asset.
     *
     * @param static $other The source asset.
     *
     * @internal
     */
    public function deepCopy($other)
    {
        $this->account   = clone $other->account;
        $this->urlConfig = clone $other->urlConfig;
        $this->asset     = clone $other->asset;
        $this->authToken = clone $other->authToken;
    }


    /**
     * Creates a new asset from the provided string (URL).
     *
     * @param string $string The asset string (URL).
     *
     * @return mixed
     */
    public static function fromString($string)
    {
        //TODO: Parse URL and populate the asset
    }


    /**
     * Creates a new asset from the provided JSON.
     *
     * @param string|array $json The asset json. Can be an array or a JSON string.
     *
     * @return mixed
     */
    public static function fromJson($json)
    {
        //TODO: implement me
    }


    /**
     * Creates a new asset from the provided source and an array of parameters.
     *
     * @param string $source The public ID of the asset.
     * @param array  $params The asset parameters.
     *
     * @return mixed
     */
    public static function fromParams($source, $params = [])
    {
        ArrayUtils::setDefaultValue($params, 'resource_type', static::getAssetType(static::class));

        $params['public_id'] = $source;

        $asset         = AssetDescriptor::fromParams($source, $params);
        $configuration = (new Configuration(Configuration::instance()));

        # set v1 defaults
        $configuration->url->secure = false;

        $configuration->importJson($params);

        return new static($asset, $configuration);
    }

    /**
     * Imports data from the provided string (URL).
     *
     * @param string $string The asset string (URL).
     *
     * @return mixed
     */
    public function importString($string)
    {
        //TODO: implement me
    }


    /**
     * Imports data from the provided JSON.
     *
     * @param string|array $json The asset json. Can be an array or a JSON string.
     *
     * @return mixed
     */
    public function importJson($json)
    {
        try {
            $json = JsonUtils::decode($json);

            $this->account = AccountConfig::fromJson($json, true);
            $this->urlConfig = UrlConfig::fromJson($json, false);
            $this->asset = AssetDescriptor::fromJson($json);
            $this->authToken = AuthToken::fromJson($json);
        } catch (\InvalidArgumentException $e) {
            $this->getLogger()->critical(
                'Error importing JSON',
                [
                    'exception' => $e->getMessage(),
                    'json' => json_encode($json),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]
            );
            throw $e;
        }

        return $this;
    }

    /**
     * Sets the asset configuration.
     *
     * @param array|Configuration $configuration The configuration source.
     *
     * @return static
     */
    public function configuration($configuration)
    {
        $tempConfiguration = new Configuration($configuration, true); // TODO: improve performance here
        $this->account   = $tempConfiguration->account;
        $this->urlConfig = $tempConfiguration->url;
        $this->logging   = $tempConfiguration->logging;

        return $this;
    }

    /**
     * Returns the public ID of the asset.
     *
     * @param bool $omitExtension Indicates whether to exclude the file extension.
     *
     * @return string
     */
    public function getPublicId($omitExtension = false)
    {
        return $this->asset->publicId($omitExtension);
    }

    /**
     * Sets the public ID of the asset.
     *
     * @param string $publicId The public ID.
     *
     * @return static
     */
    public function setPublicId($publicId)
    {
        $this->asset->setPublicId($publicId);

        return $this;
    }

    /**
     * Internal pre-serialization helper.
     *
     * @return array
     *
     * @internal
     */
    protected function prepareUrlParts()
    {
        return [
            'distribution' => $this->finalizeDistribution(),
            'asset_type'   => $this->finalizeAssetType(),
            'signature'    => $this->finalizeSimpleSignature(),
            'version'      => $this->finalizeVersion(),
            'source'       => $this->finalizeSource(),
        ];
    }

    /**
     * Serializes to URL string.
     *
     * @return string
     */
    public function toUrl()
    {
        return $this->finalizeUrlWithAuthToken(ArrayUtils::implodeUrl($this->prepareUrlParts()));
    }


    /**
     * Serializes to string.
     *
     * @return string
     */
    public function __toString()
    {
        try {
            return (string)$this->toUrl();
        } catch (\Exception $e) {
            trigger_error($e->getMessage(), E_USER_ERROR);
        }

        return '';
    }

    /**
     * Serialized to JSON.
     *
     * @param bool $includeEmptyKeys     Whether to include empty keys.
     * @param bool $includeEmptySections Whether to include empty sections.
     *
     * @return mixed
     */
    public function jsonSerialize($includeEmptyKeys = false, $includeEmptySections = false)
    {
        $json = $this->asset->jsonSerialize($includeEmptyKeys);

        foreach ([$this->account, $this->urlConfig] as $confSection) {
            $section = $confSection->jsonSerialize(false, $includeEmptyKeys, $includeEmptySections);
            if (! $includeEmptySections && empty(array_values($section)[0])) {
                continue;
            }
            $json = array_merge($json, $section);
        }

        return $json;
    }

    /**
     * Sets the property of the asset descriptor.
     *
     * @param string $propertyName The name of the property.
     * @param mixed $propertyValue The value of the property.
     *
     * @return $this
     *
     * @internal
     */
    public function setAssetProperty($propertyName, $propertyValue)
    {
        try {
            $this->asset->setAssetProperty($propertyName, $propertyValue);
        } catch (\UnexpectedValueException $e) {
            $this->getLogger()->critical(
                $e->getMessage(),
                [
                    'propertyName' => $propertyName,
                    'propertyValue' => $propertyValue,
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]
            );
            throw $e;
        }

        return $this;
    }

    /**
     * Sets the Account configuration key with the specified value.
     *
     * @param string $configKey   The configuration key.
     * @param mixed  $configValue THe configuration value.
     *
     * @return $this
     *
     * @internal
     */
    public function setAccountConfig($configKey, $configValue)
    {
        $this->account->setAccountConfig($configKey, $configValue);

        return $this;
    }

    /**
     * Sets the Url configuration key with the specified value.
     *
     * @param string $configKey   The configuration key.
     * @param mixed  $configValue THe configuration value.
     *
     * @return $this
     *
     * @internal
     */
    public function setUrlConfig($configKey, $configValue)
    {
        $this->urlConfig->setUrlConfig($configKey, $configValue);

        return $this;
    }
}
