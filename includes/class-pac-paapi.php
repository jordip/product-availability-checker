<?php

/**
 * Define the Amazon PA API v5 functionality
 *
 * Loads and defines the Amazon PA API v5 functions.
 *
 * @since      1.0.0
 * @package    Pac
 * @subpackage Pac/includes
 * @author     Jordi Plana <hello@jordiplana.com>
 */

// Load dependencies
require_once PAC_PLUGIN_DIR . 'vendor/autoload.php';

use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\api\DefaultApi;
use Amazon\ProductAdvertisingAPI\v1\ApiException;
use Amazon\ProductAdvertisingAPI\v1\Configuration;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\GetItemsRequest;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\GetItemsResource;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\SearchItemsRequest;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\SearchItemsResource;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\PartnerType;

class Pac_Paapi
{

    /**
     * The options name to be used in this plugin
     *
     * @since  1.0.0
     * @access private
     * @var    string         $option_name     Option name of this plugin
     */
    private $option_name = 'pac';

    /**
     * PA API instance
     *
     * @var DefaultApi
     */
    protected $instance;

    /**
     * PA API config
     */
    protected $config;

    /**
     * PA API associate tag
     */
    protected $associate_tag;

    /**
     * Sets the configuration for the API
     *
     * @param  array $api
     * @return void
     */
    public function set_config($api)
    {
        $keys = ['api_key', 'api_secret', 'associate_tag', 'country', 'region'];
        foreach ($keys as $key) {
            $this->config[$key] = $api[$key];
        }
    }

    /**
     * Amazon Stores
     */
    public function get_amazon_stores()
    {
        $stores = array(
            'com.au' => __('Australia', 'aawp'),
            'com.br' => __('Brazil', 'aawp'),
            'ca' => __('Canada', 'aawp'),
            'cn' => __('China', 'aawp'),
            'de' => __('Germany', 'aawp'),
            'es' => __('Spain', 'aawp'),
            'fr' => __('France', 'aawp'),
            'in' => __('India', 'aawp'),
            'it' => __('Italy', 'aawp'),
            'co.jp' => __('Japan', 'aawp'),
            'com.mx' => __('Mexico', 'aawp'),
            'com.tr' => __('Turkey', 'aawp'),
            'co.uk' => __('UK', 'aawp'),
            'com' => __('US', 'aawp'),
            'ae' => __('United Arab Emirates', 'aawp')
        );

        return $stores;
    }

    /**
     * Loads API config
     *
     * @return void
     */
    public function load_amazon_api_config()
    {
        $api = [];
        $api_keys = ['api_key', 'api_secret', 'country', 'associate_tag'];
        foreach ($api_keys as $api_option) {
            $api[$api_option] = get_option($this->option_name . '_' . $api_option);
        }
        return $api;
    }

    /**
     * Sets an instance of the API, ready to be used
     *
     * @param  [type] $api
     * @return void
     */
    public function set_amazon_api_config_instance($api = null)
    {
        if (empty($api)) {
            // Load API config from DB
            $api = $this->load_amazon_api_config();

            // Configure
            $this->config = new Configuration();
            $this->config->setAccessKey($api['api_key']);
            $this->config->setSecretKey($api['api_secret']);
            $this->associate_tag = $api['associate_tag'];
            $this->config->setHost('webservices.amazon.' . $api['country']);
            $this->config->setRegion($this->get_amazon_api_region($api['country']));

            // @TODO: Remove
            // $this->config->setDebug(true);
            // $this->config->setDebugFile('debug.log');

            $this->instance = new DefaultApi(new GuzzleHttp\Client(), $this->config);
        }
    }

    /**
     * GetItems call
     *
     * @param  array $items
     * @return void
     */
    public function api_get_items($items)
    {
        /*
        * Choose resources you want from GetItemsResource enum
        * For more details, refer: https://webservices.amazon.com/paapi5/documentation/get-items.html#resources-parameter
        */
        $resources = array(
            GetItemsResource::ITEM_INFOTITLE,
            GetItemsResource::OFFERSLISTINGSPRICE,
            GetItemsResource::PARENT_ASIN
        );

        // Forming the request
        $getItemsRequest = new GetItemsRequest();
        $getItemsRequest->setItemIds($items);
        $getItemsRequest->setPartnerTag($this->associate_tag);
        $getItemsRequest->setPartnerType(PartnerType::ASSOCIATES);
        $getItemsRequest->setResources($resources);

        // Validating request
        $invalidPropertyList = $getItemsRequest->listInvalidProperties();
        $length = count($invalidPropertyList);
        if ($length > 0) {
            return false;
        }

        // Sending the request
        try {
            $getItemsResponse = $this->instance->getItems($getItemsRequest);
            if ($getItemsResponse->getItemsResult() != null) {
                return $getItemsResponse->getItemsResult()->getItems();
            }
        } catch (ApiException $exception) {
        } catch (Exception $exception) {
        }
        return false;
    }

    /**
     * Validates API config
     *
     * @param  array $api
     * @return boolean
     */
    public function validate_amazon_api($api)
    {
        // Configure
        $this->config = new Configuration();
        $this->config->setAccessKey($api['api_key']);
        $this->config->setSecretKey($api['api_secret']);
        $partnerTag = $api['associate_tag'];
        $this->config->setHost('webservices.amazon.' . $api['country']);
        $this->config->setRegion($this->get_amazon_api_region($api['country']));

        $this->instance = new DefaultApi(new GuzzleHttp\Client(), $this->config);

        // Request initialization
        $keyword = 'Harry Potter';
        $searchIndex = "All";
        $itemCount = 1;

        $resources = array(
            SearchItemsResource::ITEM_INFOTITLE,
            SearchItemsResource::OFFERSLISTINGSPRICE
        );

        // Forming the request
        $searchItemsRequest = new SearchItemsRequest();
        $searchItemsRequest->setSearchIndex($searchIndex);
        $searchItemsRequest->setKeywords($keyword);
        $searchItemsRequest->setItemCount($itemCount);
        $searchItemsRequest->setPartnerTag($partnerTag);
        $searchItemsRequest->setPartnerType(PartnerType::ASSOCIATES);
        $searchItemsRequest->setResources($resources);

        // Validating request
        $invalidPropertyList = $searchItemsRequest->listInvalidProperties();
        $length = count($invalidPropertyList);
        if ($length > 0) {
            return false;
        }

        // Sending the request
        try {
            $searchItemsResponse = $this->instance->searchItems($searchItemsRequest);
            return true;
        } catch (ApiException $exception) {
        } catch (Exception $exception) {
        }
        return false;
    }

    /**
     * Gets the region based on the country
     *
     * @param  [type] $country
     * @return void
     */
    public function get_amazon_api_region($country)
    {
        // Documentation: https://webservices.amazon.com/paapi5/documentation/common-request-parameters.html#host-and-region
        switch ($country) {
            case 'com.au':
                $region = 'us-west-2';
                break;
            case 'com.br':
                $region = 'us-east-1';
                break;
            case 'ca':
                $region = 'us-east-1';
                break;
            case 'fr':
                $region = 'eu-west-1';
                break;
            case 'de':
                $region = 'eu-west-1';
                break;
            case 'in':
                $region = 'eu-west-1';
                break;
            case 'it':
                $region = 'eu-west-1';
                break;
            case 'co.jp':
                $region = 'us-west-2';
                break;
            case 'com.mx':
                $region = 'us-east-1';
                break;
            case 'nl':
                $region = 'eu-west-1';
                break;
            case 'sg':
                $region = 'us-west-2';
                break;
            case 'es':
                $region = 'eu-west-1';
                break;
            case 'com.tr':
                $region = 'eu-west-1';
                break;
            case 'ae':
                $region = 'eu-west-1';
                break;
            case 'co.uk':
                $region = 'eu-west-1';
                break;
            default:
                $region = 'us-east-1';
                break;
        }
        return $region;
    }
}
