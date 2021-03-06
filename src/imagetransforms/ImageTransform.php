<?php
/**
 * ImageOptimize plugin for Craft CMS 3.x
 *
 * Automatically optimize images after they've been transformed
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2017 nystudio107
 */

namespace nystudio107\imageoptimize\imagetransforms;

use nystudio107\imageoptimize\helpers\UrlHelper;

use craft\elements\Asset;
use craft\helpers\Assets as AssetsHelper;
use craft\models\AssetTransform;

/**
 * @author    nystudio107
 * @package   ImageOptimize
 * @since     1.0.0
 */
abstract class ImageTransform implements ImageTransformInterface
{
    // Public Static Methods
    // =========================================================================

    /**
     * @param Asset               $asset
     * @param AssetTransform|null $transform
     * @param array               $params
     *
     * @return string|null
     */
    public static function getTransformUrl(Asset $asset, $transform, array $params = [])
    {
        $url = null;

        return $url;
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public static function getWebPUrl(string $url): string
    {
        return $url;
    }

    /**
     * @param Asset $asset
     * @param array $params
     *
     * @return null|string
     */
    public static function getPurgeUrl(Asset $asset, array $params = [])
    {
        $url = null;

        return $url;
    }

    /**
     * @param string $url
     * @param array  $params
     *
     * @return bool
     */
    public static function purgeUrl(string $url, array $params = []): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public static function getTransformParams(): array
    {
        $params = [
        ];

        return $params;
    }

    /**
     * @param Asset $asset
     *
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public static function getAssetUri(Asset $asset)
    {
        $volume = $asset->getVolume();
        $assetUrl = AssetsHelper::generateUrl($volume, $asset);
        $assetUri = parse_url($assetUrl, PHP_URL_PATH);

        return $assetUri;
    }

    /**
     * @param string $url
     */
    public static function prefetchRemoteFile($url)
    {
        // Get an absolute URL with protocol that curl will be happy with
        $url = UrlHelper::absoluteUrlWithProtocol($url);
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_NOBODY         => 1,
        ]);
        curl_exec($ch);
        curl_close($ch);
    }
}
